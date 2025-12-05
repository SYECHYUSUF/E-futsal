<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Field;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\WhatsAppService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class ReservationController extends Controller
{
    protected $whatsappService;

    public function __construct(WhatsAppService $whatsappService)
    {
        $this->whatsappService = $whatsappService;
    }


    public function index()
    {
        $reservations = Auth::user()
            ->reservations()
            ->with('field')
            ->latest()
            ->get();

        // Mengarahkan ke view customer.reservations.index
        return view('customer.reservations.index', compact('reservations'));
    }


    public function create(Request $request)
    {
        $fieldId = $request->query('field_id');

        if (!$fieldId) {
            return redirect()->route('customer.fields.index')
                ->with('error', 'Silakan pilih lapangan terlebih dahulu.');
        }

        $field = Field::with(['galleries', 'facilities'])->findOrFail($fieldId);

        return view('customer.reservations.create', compact('field'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'field_id'     => 'required|exists:fields,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time'   => 'required',
            'end_time'     => 'required|after:start_time',
        ]);

        $field = Field::findOrFail($request->field_id);

        $bookingDate = $request->booking_date;
        $startTime   = $request->start_time;
        $endTime     = $request->end_time;

        $start = Carbon::createFromFormat('Y-m-d H:i', $bookingDate . ' ' . $startTime);
        $end   = Carbon::createFromFormat('Y-m-d H:i', $bookingDate . ' ' . $endTime);

        if ($end->lessThanOrEqualTo($start)) {
            $end->addDay();
        }

        $duration = $end->diffInHours($start);

        // if ($duration < 1) {
        //     return back()->withErrors(['end_time' => 'Durasi minimal 1 jam.'])->withInput();
        // }

        $totalPrice = $duration * $field->hourly_rate;

        $reservation = Reservation::create([
            'user_id'      => Auth::id(),
            'field_id'     => $field->id,
            'booking_date' => $bookingDate,
            'start_time'   => $startTime,
            'end_time'     => $endTime,
            'total_price'  => $totalPrice,
            'status'       => 'pending',
        ]);

        $message = "Halo Admin, ada booking baru dari *" . Auth::user()->name . "*.\n\n";
        $message .= "Lapangan: *" . $field->name . "*\n"; // $field->name
        $message .= "Tanggal: *" . Carbon::parse($reservation->booking_date)->format('d F Y') . "*\n";
        $message .= "Jam: *" . $reservation->start_time . " - " . $reservation->end_time . "*\n";
        $message .= "Total Harga: *Rp " . number_format($totalPrice, 0, ',', '.') . "*\n\n";
        $message .= "Mohon segera dikonfirmasi.";

        $adminNumber = env('WHATSAPP_ADMIN_NUMBER');

        if ($adminNumber) {
            $this->whatsappService->sendMessage($adminNumber, $message);
        }

        return redirect()->route('reservations.index')
            ->with('success', 'Booking berhasil dibuat! Menunggu konfirmasi admin.');
    }

    public function show(Reservation $reservation)
    {
        // Pastikan user hanya bisa melihat reservasinya sendiri
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        return view('customer.reservations.show', compact('reservation'));
    }

    /**
     * Upload Bukti Pembayaran
     */
    public function uploadPayment(Request $request, Reservation $reservation)
    {
        // Validasi User & Status
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        // Validasi Gambar
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Hapus bukti lama jika ada (untuk re-upload)
        if ($reservation->payment_proof) {
            Storage::disk('public')->delete($reservation->payment_proof);
        }

        // Simpan Gambar Baru
        $path = $request->file('payment_proof')->store('payment_proofs', 'public');

        // Update Database
        $reservation->update([
            'payment_proof' => $path,
            // Opsional: Ubah status jadi 'paid' agar admin tahu sudah bayar
            // Atau biarkan 'pending' sampai admin konfirmasi manual
            'status' => 'paid'
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diupload!');
    }
}

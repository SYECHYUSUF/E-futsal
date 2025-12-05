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
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $reservations = $user->reservations()
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
        // 1. Validasi
        $request->validate([
            'field_id'     => 'required|exists:fields,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time'   => 'required',
            'end_time'     => 'required',
        ]);

        $field = Field::findOrFail($request->field_id);

        // 2. Setup Waktu
        $bookingDate = $request->booking_date;
        $startTime   = $request->start_time;
        $endTime     = $request->end_time;

        $start = Carbon::createFromFormat('Y-m-d H:i', $bookingDate . ' ' . $startTime);
        $end   = Carbon::createFromFormat('Y-m-d H:i', $bookingDate . ' ' . $endTime);

        // 3. Logika Lintas Hari (Overnight)
        // Jika jam selesai lebih kecil dari jam mulai (misal: Mulai 23:00, Selesai 01:00)
        // Maka anggap selesai besok harinya.
        if ($end->lessThanOrEqualTo($start)) {
            $end->addDay();
        }

        // 4. Hitung Durasi via Timestamp (Anti Minus)
        // Rumus: (Waktu Selesai - Waktu Mulai) dalam detik / 3600 detik
        $seconds = $end->timestamp - $start->timestamp;
        $duration = $seconds / 3600;

        // Validasi Booking Aneh (Misal durasi 0 atau negatif karena kesalahan sistem)
        if ($duration <= 0) {
            return back()->withErrors(['end_time' => 'Durasi booking tidak valid.'])->withInput();
        }

        // 5. Hitung Harga
        // ceil() membulatkan ke atas (misal main 1.5 jam dihitung bayar 2 jam, ubah jika kebijakan beda)
        $totalPrice = ceil($duration) * $field->hourly_rate;

        // 6. Simpan
        $reservation = Reservation::create([
            'user_id'      => Auth::id(),
            'field_id'     => $field->id,
            'booking_date' => $bookingDate,
            'start_time'   => $startTime,
            'end_time'     => $endTime,
            'total_price'  => $totalPrice,
            'status'       => 'pending',
        ]);

        // 7. Notifikasi WA
        $message = "Halo Admin, ada booking baru dari *" . Auth::user()->name . "*.\n\n";
        $message .= "Lapangan: *" . $field->name . "*\n";
        $message .= "Tanggal: *" . Carbon::parse($reservation->booking_date)->format('d F Y') . "*\n";
        $message .= "Jam: *" . $reservation->start_time . " - " . $reservation->end_time . "*\n";
        $message .= "Durasi: *" . $duration . " Jam*\n";
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
        // 1. Validasi User
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        // 2. Validasi Gambar
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 3. Hapus bukti lama jika ada
        if ($reservation->payment_proof) {
            Storage::disk('public')->delete($reservation->payment_proof);
        }

        // 4. Simpan Gambar Baru
        $path = $request->file('payment_proof')->store('payment_proofs', 'public');

        // 5. Update Database (Ubah status jadi 'paid' agar admin cek)
        $reservation->update([
            'payment_proof' => $path,
            'status' => 'paid' 
        ]);

        // --- TAMBAHAN NOTIFIKASI WA KE ADMIN ---
        try {
            $adminNumber = env('WHATSAPP_ADMIN_NUMBER', '085342505228'); // Default nomor Anda
            
            $message = "Halo Admin, user *" . Auth::user()->name . "* telah mengupload bukti pembayaran.\n\n";
            $message .= "No Invoice: *RES-" . $reservation->id . "*\n";
            $message .= "Tanggal Main: *" . \Carbon\Carbon::parse($reservation->booking_date)->format('d F Y') . "*\n";
            $message .= "Total: *Rp " . number_format($reservation->total_price, 0, ',', '.') . "*\n\n";
            $message .= "Mohon segera dicek dan dikonfirmasi.";

            $this->whatsappService->sendMessage($adminNumber, $message);
        
        } catch (\Exception $e) {
            // Jangan sampai error WA mengganggu proses upload
            \Illuminate\Support\Facades\Log::error("Gagal notif upload bayar: " . $e->getMessage());
        }
        // ----------------------------------------

        return back()->with('success', 'Bukti pembayaran berhasil diupload! Admin telah dinotifikasi.');
    }
}

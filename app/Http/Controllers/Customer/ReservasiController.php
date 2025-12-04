<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Lapangan;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservasiController extends Controller
{
    public function index()
    {
        $reservasis = Reservasi::with('lapangan')->where('user_id', Auth::id())->latest()->get();
        return view('customer.reservasi.index', compact('reservasis'));
    }

    public function create(Request $request)
    {
        $lapangans = Lapangan::all();
        $selectedLapangan = null;
        if ($request->has('lapangan_id')) {
            $selectedLapangan = Lapangan::find($request->lapangan_id);
        }
        return view('customer.reservasi.create', compact('lapangans', 'selectedLapangan'));
    }

    /**
     * API Internal untuk mengecek jam yang sudah dibooking
     */
    public function checkAvailability(Request $request)
    {
        $getRequest = $request->all();
        
        // Ambil semua reservasi pada tanggal & lapangan tersebut yang statusnya BUKAN cancelled
        $bookings = Reservasi::where('lapangan_id', $getRequest['lapangan_id'])
            ->where('tanggal_main', $getRequest['tanggal'])
            ->where('status', '!=', 'cancelled')
            ->get();

        $bookedSlots = [];

        foreach ($bookings as $booking) {
            // Konversi jam mulai ke integer (misal "14:00:00" jadi 14)
            $startHour = (int) substr($booking->jam_mulai, 0, 2);
            $duration = $booking->durasi;

            // Masukkan semua jam yang terpakai ke dalam array
            for ($i = 0; $i < $duration; $i++) {
                $bookedSlots[] = $startHour + $i;
            }
        }

        return response()->json($bookedSlots);
    }

    public function store(Request $request)
    {
        $request->validate([
            'lapangan_id' => 'required|exists:lapangans,id',
            'tanggal_main' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required',
            'durasi' => 'required|integer|min:1',
        ]);

        $lapangan = Lapangan::findOrFail($request->lapangan_id);
        
        // Hitung total harga
        $totalHarga = $lapangan->harga_per_jam * $request->durasi;

        // Hitung jam selesai
        $jamMulaiTimestamp = strtotime($request->tanggal_main . ' ' . $request->jam_mulai);
        $jamSelesaiTimestamp = strtotime("+{$request->durasi} hours", $jamMulaiTimestamp);
        $jamSelesai = date('H:i:s', $jamSelesaiTimestamp);

        // Cek bentrok sekali lagi di backend untuk keamanan
        $isConflict = Reservasi::where('lapangan_id', $request->lapangan_id)
            ->where('tanggal_main', $request->tanggal_main)
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($request, $jamSelesai) {
                $query->whereBetween('jam_mulai', [$request->jam_mulai, $jamSelesai])
                      ->orWhereBetween('jam_selesai', [$request->jam_mulai, $jamSelesai]);
            })->exists();

        // Note: Validasi bentrok sederhana, logic detail bisa dikembangkan
        
        Reservasi::create([
            'user_id' => Auth::id(),
            'lapangan_id' => $request->lapangan_id,
            'tanggal_main' => $request->tanggal_main,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $jamSelesai,
            'durasi' => $request->durasi,
            'total_harga' => $totalHarga,
            'status' => 'pending',
        ]);

        return redirect()->route('reservasi.index')->with('success', 'Booking berhasil! Silakan lakukan pembayaran.');
    }
}
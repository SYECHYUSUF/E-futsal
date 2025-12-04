<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\Lapangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Services\WhatsAppService;


class ReservasiController extends Controller
{
    protected $whatsappService;

    public function __construct(WhatsAppService $whatsappService)
    {
        $this->whatsappService = $whatsappService;
    }

    /**
     * Menampilkan riwayat reservasi customer.
     * Menggunakan view: resources/views/customer/reservasi/index.blade.php
     */
    public function index()
    {
        // BARIS YANG MEMANGGIL RELASI
        $reservasis = Auth::user()->reservasis()->with('lapangan')->latest()->get(); 
        return view('customer.reservasi.index', compact('reservasis'));
    }

    /**
     * Menampilkan form reservasi (create).
     */
    public function create(Request $request)
    {
        $lapanganId = $request->query('lapangan_id');

        if (!$lapanganId) {
            return redirect()->route('lapangan.index')->with('error', 'Silakan pilih lapangan terlebih dahulu.');
        }

        $lapangan = Lapangan::findOrFail($lapanganId);

        return view('customer.reservasi.create', compact('lapangan'));
    }

    /**
     * Menyimpan data reservasi dan mengirim notifikasi WA.
     */
    public function store(Request $request)
    {
        $request->validate([
            'lapangan_id'     => 'required|exists:lapangan,id',
            'tanggal_booking' => 'required|date|after_or_equal:today',
            'jam_mulai'       => 'required',
            'jam_selesai'     => 'required',
        ]);


        $lapangan = Lapangan::findOrFail($request->lapangan_id);

        $tanggal_booking = $request->tanggal_booking;

        $start = Carbon::createFromFormat('Y-m-d H:i', $tanggal_booking . ' ' . $request->jam_mulai);
        $end   = Carbon::createFromFormat('Y-m-d H:i', $tanggal_booking . ' ' . $request->jam_selesai);

        if ($end->lessThanOrEqualTo($start)) {
            $end->addDay();
        }

        $durasi = $end->diffInHours($start);
        
        if ($durasi < 1) {
            return back()->withErrors(['jam_selesai' => 'Durasi minimal 1 jam.'])->withInput();
        }
        $totalHarga = $durasi * $lapangan->biaya_per_jam;

        $reservasi = Reservasi::create([
            'user_id'         => Auth::id(),
            'lapangan_id'     => $lapangan->id,
            'tanggal_booking' => $request->tanggal_booking,
            'jam_mulai'       => $request->jam_mulai,
            'jam_selesai'     => $request->jam_selesai,
            'total_price'     => $totalHarga,
            'status'          => 'pending',
        ]);

        // INTEGRASI API FONTE WHATSAPP
        $message = "Halo Admin, ada booking baru dari *".Auth::user()->name."*.\n\nLapangan: *".$lapangan->nama."*\nTanggal: *".\Carbon\Carbon::parse($reservasi->tanggal_booking)->format('d F Y')."*\nJam: *".$reservasi->jam_mulai." - ".$reservasi->jam_selesai."*\nTotal Harga: *Rp ".number_format($totalHarga, 0, ',', '.')."*\n\nMohon segera dikonfirmasi.";
        
        $adminNumber = env('WHATSAPP_ADMIN_NUMBER');
        
        $this->whatsappService->sendMessage($adminNumber, $message);
        
        return redirect()->route('reservasi.index')->with('success', 'Booking berhasil dibuat! Menunggu konfirmasi admin. Notifikasi ke Admin via WA telah dikirim.');
    }
}
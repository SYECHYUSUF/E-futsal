<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use App\Services\WhatsAppService; // Import Service
use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    protected $waService;

    public function __construct(WhatsAppService $waService)
    {
        $this->waService = $waService;
    }

    public function index()
    {
        $reservations = Reservasi::with(['user', 'lapangan'])->latest()->get();
        return view('admin.reservasi.index', compact('reservations'));
    }

    // APPROVE
    public function approve(Reservasi $reservasi)
    {
        // Cek Bentrok (Copy logic sebelumnya)
        $isBooked = Reservasi::where('lapangan_id', $reservasi->lapangan_id)
            ->where('status', 'confirmed')
            ->where('id', '!=', $reservasi->id)
            ->where(function ($query) use ($reservasi) {
                $query->where('start_time', '<', $reservasi->end_time)
                      ->where('end_time', '>', $reservasi->start_time);
            })->exists();

        if ($isBooked) {
            return back()->with('error', 'Gagal! Jadwal bentrok dengan booking lain yang sudah confirm.');
        }

        $reservasi->update(['status' => 'confirmed']);

        // KIRIM WA NOTIFIKASI
        if ($reservasi->user->phone) {
            $msg = "*Halo {$reservasi->user->name}* 👋\n\n";
            $msg .= "Booking lapangan kamu sudah kami *TERIMA* (Approved) ✅.\n";
            $msg .= "🏟 Lapangan: {$reservasi->lapangan->nama}\n";
            $msg .= "📅 Tanggal: {$reservasi->date->format('d M Y')}\n";
            $msg .= "⏰ Jam: {$reservasi->start_time->format('H:i')} - {$reservasi->end_time->format('H:i')}\n";
            $msg .= "\nSilakan datang tepat waktu ya!";
            
            $this->waService->sendMessage($reservasi->user->phone, $msg);
        }

        return back()->with('success', 'Reservasi diterima & Notif WA dikirim.');
    }

    // REJECT
    public function reject(Request $request, Reservasi $reservasi)
    {
        $request->validate(['reason' => 'required|string']);

        $reservasi->update([
            'status' => 'cancelled',
            'note' => $request->reason
        ]);

        // KIRIM WA NOTIFIKASI
        if ($reservasi->user->phone) {
            $msg = "*Halo {$reservasi->user->name}* 👋\n\n";
            $msg .= "Mohon maaf, booking lapangan kamu kami *TOLAK* ❌.\n";
            $msg .= "Alasan: _{$request->reason}_\n\n";
            $msg .= "Silakan booking di jam/hari lain.";
            
            $this->waService->sendMessage($reservasi->user->phone, $msg);
        }

        return back()->with('success', 'Reservasi ditolak & Notif WA dikirim.');
    }
    public function review(Request $request, Reservasi $reservasi)
    {
        // Ambil parameter 'action' dari URL (approve / reject)
        $action = $request->query('action', 'detail');

        return view('admin.reservasi.review', compact('reservasi', 'action'));
    }
}
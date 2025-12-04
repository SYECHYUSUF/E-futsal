<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lapangan;
use App\Models\Reservasi;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik Sederhana
        $totalPendapatan = Reservasi::where('status', 'paid')->orWhere('status', 'confirmed')->sum('total_price');
        $totalBooking = Reservasi::count();
        $bookingPending = Reservasi::where('status', 'pending')->count();
        $totalUser = User::where('is_admin', false)->count();

        // 5 Booking Terakhir
        $latestBookings = Reservasi::with(['user', 'lapangan'])->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalPendapatan', 
            'totalBooking', 
            'bookingPending', 
            'totalUser',
            'latestBookings'
        ));
    }
}
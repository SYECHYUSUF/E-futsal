<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Field;       // Sebelumnya: Lapangan
use App\Models\Reservation; // Sebelumnya: Reservasi
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = Reservation::where('status', 'paid')
            ->orWhere('status', 'confirmed')
            ->sum('total_price');

        $totalBookings = Reservation::count();

        $pendingBookings = Reservation::where('status', 'pending')->count();

        $totalUsers = User::where('is_admin', false)->count();

        $latestBookings = Reservation::with(['user', 'field'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalBookings',
            'pendingBookings',
            'totalUsers',
            'latestBookings'
        ));
    }
}

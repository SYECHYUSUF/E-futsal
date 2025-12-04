<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Lapangan;
use Illuminate\Http\Request;

class LapanganController extends Controller
{
    public function index()
    {
        $lapangans = Lapangan::all(); // Atau paginate(9) jika banyak
        return view('customer.lapangan.index', compact('lapangans'));
    }
}
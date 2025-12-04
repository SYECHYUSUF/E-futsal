<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;
use Illuminate\Http\Request;

class LapanganController extends Controller
{
    /**
     * Menampilkan daftar semua lapangan untuk customer.
     */
    public function index()
    {
        // Pengecekan 1: Memastikan semua data lapangan diambil
        $lapangans = Lapangan::all(); //

        // Pengecekan 2: Memastikan view dan variabel dikirim
        return view('customer.lapangan.index', compact('lapangans')); //
    }
}
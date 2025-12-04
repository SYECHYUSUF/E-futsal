<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Ganti 'Booking' dengan nama Model Anda jika berbeda
use App\Models\Booking; 

class BookingController extends Controller
{
    // Menampilkan halaman form
    public function create()
    {
        // Kita hanya me-return view, tanpa query berat agar loading cepat
        return view('booking-form');
    }

    // Menyimpan data
    public function store(Request $request)
    {
        // 1. Validasi Input (Penting agar data aman)
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'waktu' => 'required',
        ]);

        // 2. Simpan ke Database
        // Pastikan Anda sudah punya Model Booking. 
        // Jika belum, kabari saya, nanti kita buatkan migration-nya.
        // Booking::create($validated); 
        
        // Contoh respon sukses sederhana (agar web tidak hang)
        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lapangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LapanganController extends Controller
{
    public function index()
    {
        $lapangans = Lapangan::all();
        return view('admin.lapangan.index', compact('lapangans'));
    }

    public function create()
    {
        return view('admin.lapangan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'kapasitas' => 'required|integer',
            'biaya_per_jam' => 'required|integer',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('lapangan_images', 'public');
        }

        Lapangan::create([
            'nama' => $request->nama,
            'kapasitas' => $request->kapasitas,
            'biaya_per_jam' => $request->biaya_per_jam,
            'gambar' => $path,
        ]);

        return redirect()->route('admin.lapangan.index')->with('success', 'Lapangan berhasil ditambahkan');
    }

    public function edit(Lapangan $lapangan)
    {
        return view('admin.lapangan.edit', compact('lapangan'));
    }

    public function update(Request $request, Lapangan $lapangan)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'kapasitas' => 'required|integer',
            'biaya_per_jam' => 'required|integer',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($lapangan->gambar) {
                Storage::disk('public')->delete($lapangan->gambar);
            }
            $lapangan->gambar = $request->file('gambar')->store('lapangan_images', 'public');
        }

        $lapangan->update([
            'nama' => $request->nama,
            'kapasitas' => $request->kapasitas,
            'biaya_per_jam' => $request->biaya_per_jam,
        ]);

        return redirect()->route('admin.lapangan.index')->with('success', 'Lapangan berhasil diupdate');
    }

    public function destroy(Lapangan $lapangan)
    {
        if ($lapangan->gambar) {
            Storage::disk('public')->delete($lapangan->gambar);
        }
        $lapangan->delete();
        return redirect()->route('admin.lapangan.index')->with('success', 'Lapangan dihapus');
    }
}
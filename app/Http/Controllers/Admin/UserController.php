<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Ambil semua user kecuali admin sendiri
        $users = User::where('is_admin', false)->latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function approve(User $user)
    {
        $user->is_active = true;
        $user->save();
        // Opsional: Kirim WA notifikasi akun aktif

        return back()->with('success', 'Akun berhasil disetujui/diaktifkan.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }
}

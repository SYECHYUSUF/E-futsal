<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Menampilkan halaman Tentang Kami (About).
     * Menggunakan view: resources/views/pages/about.blade.php
     */
    public function about()
    {
        return view('pages.about');
    }
    
    /**
     * Menampilkan halaman Kontak (Contact).
     * Menggunakan view: resources/views/pages/contact.blade.php
     */
    public function contact()
    {
        return view('pages.contact');
    }
}
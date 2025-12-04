<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lapangan extends Model
{
    use HasFactory;

    // Tambahkan baris ini
    protected $table = 'lapangan';

    protected $fillable = [
        'nama', 
        'kapasitas', 
        'biaya_per_jam', 
        'gambar'
    ];
}
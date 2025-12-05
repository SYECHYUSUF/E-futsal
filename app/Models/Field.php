<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'capacity',
        'hourly_rate',
        'image'
    ];

    // Relasi ke Reservasi
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    // Relasi ke Galeri
    public function galleries()
    {
        return $this->hasMany(FieldGallery::class);
    }

    // Relasi ke Fasilitas
    public function facilities()
    {
        return $this->hasMany(FieldFacility::class);
    }
}

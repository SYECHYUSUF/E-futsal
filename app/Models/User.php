<?php

namespace App\Models;

// WAJIB: Import kelas untuk relasi
use Illuminate\Database\Eloquent\Relations\HasMany; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Reservasi; // Wajib di-import

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number', // Tambahkan jika ada di migrasi
        'is_admin',     // Tambahkan jika ada di migrasi
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean', // Pastikan ini ada
        ];
    }

    /**
     * Dapatkan semua reservasi untuk user.
     */
    public function reservasis(): HasMany
    {
        // Menggunakan FQCN untuk menghindari masalah cache/autoloading
        return $this->hasMany(Reservasi::class);
    }
}
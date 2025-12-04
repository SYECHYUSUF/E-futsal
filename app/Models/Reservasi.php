<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservasi extends Model
{
    protected $table = 'reservasi';

    protected $fillable = [
        'user_id', 
        'lapangan_id', 
        'tanggal_booking',
        'jam_mulai',
        'jam_selesai',
        'total_price', 
        'status',
    ];

    /**
     * Hubungan: Reservasi dimiliki oleh satu Lapangan (BelongsTo).
     */
    public function lapangan(): BelongsTo
    {
        return $this->belongsTo(Lapangan::class);
    }
    
    /**
     * Hubungan: Reservasi dimiliki oleh satu User (BelongsTo).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
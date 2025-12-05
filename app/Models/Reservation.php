<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{

    protected $fillable = [
        'user_id',
        'field_id',
        'booking_date',
        'start_time',
        'end_time',
        'total_price',
        'status',
        'payment_proof',
        'rejection_reason',
    ];

    /**
     * Hubungan: Reservasi dimiliki oleh satu Field (BelongsTo).
     */
    public function field(): BelongsTo
    {
        return $this->belongsTo(Field::class);
    }

    /**
     * Hubungan: Reservasi dimiliki oleh satu User (BelongsTo).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

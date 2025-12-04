<?php 

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Lapangan extends Model
{
    protected $table = 'lapangan';
    protected $guarded = ['id'];

    public function reservasi() {
        return $this->hasMany(Reservasi::class);
    }
}

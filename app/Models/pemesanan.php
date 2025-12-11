<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pemesanan;
use App\Models\Notifikasi;
use App\Models\Kost;
use Illuminate\Support\Facades\Auth;

class Pemesanan extends Model
{
    use HasFactory;

    protected $table = 'pemesanan';

    protected $fillable = [
    'user_id',
    'pemilik_id',
    'kost_id',
    'tanggal_mulai',
    'tanggal_selesai',
    'status',
];

   public function kost()
{
    return $this->belongsTo(Kost::class, 'kost_id');
}

public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function notifikasi()
{
    return $this->hasMany(Notifikasi::class);
}


}

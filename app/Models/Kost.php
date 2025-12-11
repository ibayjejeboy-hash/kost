<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kost extends Model
{
    use HasFactory;

    protected $fillable = [
        'pemilik_id',
        'nama',
        'alamat',
        'kota',
        'harga',
        'jumlah_kamar',
        'deskripsi',
        'gambar',
    ];

    public function sewaKamars()
{
    return $this->hasMany(SewaKamar::class);
}
     public function pemilik()
    {
        return $this->belongsTo(User::class, 'pemilik_id');
    }

    public function pemesanan()
{
    return $this->hasMany(Pemesanan::class, 'kost_id');
}

public function user()
{
    return $this->belongsTo(User::class, 'pemilik_id');
}

public function testimonis()
{
    return $this->hasMany(Testimoni::class);
}

}

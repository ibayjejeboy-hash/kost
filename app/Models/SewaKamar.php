<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SewaKamar extends Model
{
    use HasFactory;

    protected $fillable = [
        'kost_id',
        'penyewa_id',
        'nama_penyewa',
        'no_kamar',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    public function kost()
    {
        return $this->belongsTo(Kost::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimoni extends Model
{
    use HasFactory;

    protected $table = 'testimonis';

    protected $fillable = [
        'user_id',
        'kost_id',
        'rating',
        'komentar'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function kost() {
        return $this->belongsTo(Kost::class);
    }
}

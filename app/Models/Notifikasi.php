<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{

    public function up()
{
    Schema::create('notifikasis', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->string('pesan');
        $table->enum('status', ['read', 'unread'])->default('unread');
        $table->timestamps();
    });
}

   protected $fillable = [
    'pemesanan_id',
    'user_id',
    'pesan',
    'status'
];

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class);
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
   Schema::create('kosts', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('pemilik_id'); // 🔹 tambahkan ini

    $table->string('nama');
    $table->text('alamat');
    $table->string('kota');
    $table->decimal('harga', 12, 2);
    $table->integer('jumlah_kamar')->nullable();
    $table->text('deskripsi')->nullable();
    $table->string('gambar')->nullable();
    
    // 🔹 foreign key diletakkan setelah kolom dibuat
    $table->foreign('pemilik_id')->references('id')->on('users')->onDelete('cascade');

    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('kosts');
    }
};

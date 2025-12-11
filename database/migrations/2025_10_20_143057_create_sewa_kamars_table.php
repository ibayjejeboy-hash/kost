<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sewa_kamars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kost_id');
            $table->unsignedBigInteger('penyewa_id');
            $table->string('nama_penyewa');
            $table->string('no_kamar');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->timestamps();

            $table->foreign('kost_id')->references('id')->on('kosts')->onDelete('cascade');
            $table->foreign('penyewa_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sewa_kamars');
    }
};

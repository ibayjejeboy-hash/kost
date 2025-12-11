<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kost;

class KostSeeder extends Seeder
{
    public function run(): void
    {
        Kost::create([
            'nama' => 'Kost Putri Mawar Indah',
            'alamat' => 'Jl. Melati No. 12, Bandung',
            'deskripsi' => 'Kost nyaman khusus putri, dekat kampus dan fasilitas umum.',
            'harga' => 850000,
            'foto' => 'img/ppx.jpg',
            'tipe' => 'Putri',
            'fasilitas' => 'WiFi, Dapur, Parkir, Kamar mandi dalam'
        ]);

        Kost::create([
            'nama' => 'Kost Putra Sakura',
            'alamat' => 'Jl. Mawar No. 5, Jakarta',
            'deskripsi' => 'Kost eksklusif untuk putra, dekat halte dan mall.',
            'harga' => 1000000,
            'foto' => 'img/x.jpg',
            'tipe' => 'Putra',
            'fasilitas' => 'WiFi, Parkir, AC, Laundry'
        ]);

        Kost::create([
            'nama' => 'Kost Eksklusif Anggrek',
            'alamat' => 'Jl. Cempaka No. 21, Surabaya',
            'deskripsi' => 'Kost campur dengan fasilitas premium dan lingkungan aman.',
            'harga' => 1500000,
            'foto' => 'img/aa.jpg',
            'tipe' => 'Campur',
            'fasilitas' => 'WiFi, AC, TV, Dapur, Kamar mandi dalam'
        ]);
    }
}

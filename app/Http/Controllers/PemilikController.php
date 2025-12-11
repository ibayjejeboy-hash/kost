<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat; // pastikan model Chat sudah ada
use App\Models\Kost;
use App\Models\SewaKamar;
use App\Models\Pemesanan;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;

class PemilikController extends Controller
{
    public function index()
{
    // sementara bikin data dummy supaya gak error
    $chats = [
        [
            'sender_name' => 'Rizky',
            'message' => 'Apakah kamar masih tersedia?',
            'time' => '2 menit lalu',
            'sender_id' => 1
        ],
        [
            'sender_name' => 'Budi',
            'message' => 'Bisa lihat foto kamar?',
            'time' => '10 menit lalu',
            'sender_id' => 2
        ]
    ];
    
     $pemilikId = Auth::id();

        // 🔹 Data statistik
        $totalKost = Kost::where('pemilik_id', $pemilikId)->count();
        $kamarDisewa = SewaKamar::whereHas('kost', function($query) use ($pemilikId) {
            $query->where('pemilik_id', $pemilikId);
        })->where('status', 'aktif')->count();
        $pesanMasuk = 5;

        // 🔹 Ambil daftar kamar yang disewa
        $sewaKamars = SewaKamar::with('kost')
            ->whereHas('kost', function($query) use ($pemilikId) {
                $query->where('pemilik_id', $pemilikId);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // 🔹 Kirim semua data ke view
        return view('pemilik.dashboard', compact(
            'totalKost',
            'kamarDisewa',
            'pesanMasuk',
            'sewaKamars'
        ));

         $pemesanan = Pemesanan::where('pemilik_id', Auth::id())->get();

    $notifikasi = Notifikasi::where('user_id', Auth::id())
                            ->orderBy('created_at', 'desc')
                            ->get();

                            $pemesanan = Pemesanan::where('pemilik_id', Auth::id())->get();
        $notifikasi = Notifikasi::where('user_id', Auth::id())->get();

        return view('pemilik.dashboard', compact(
            'totalKost',
            'kamarDisewa',
            'pesanMasuk',
            'sewaKamars'
        ));

    return view('dashboard-pemilik', compact('pemesanan', 'notifikasi'));


    return view('dashboard.pemilik', compact('chats'));
}

public function konfirmasiPembayaran($id)
    {
        // Cari pemesanan berdasarkan ID
        $pemesanan = Pemesanan::findOrFail($id);

        // Update status pemesanan
        $pemesanan->update([
            'status' => 'pembayaran_terkonfirmasi'
        ]);

        return redirect()->back()->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }

}

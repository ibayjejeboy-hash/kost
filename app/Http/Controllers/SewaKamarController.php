<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Support\Facades\Auth;

class SewaKamarController extends Controller
{
    public function index()
    {
        $pemilikId = Auth::id();

        // Ambil semua pemesanan yang berkaitan dengan kost milik pemilik ini
        $pemesanan = Pemesanan::with(['kost', 'user'])
            ->whereHas('kost', function ($query) use ($pemilikId) {
                $query->where('pemilik_id', $pemilikId);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Hitung jumlah kamar yang disewa (status = disewa / aktif)
        $kamarDisewa = $pemesanan->where('status', 'disewa')->count();

        return view('pemilik.sewa-kamar', compact('pemesanan', 'kamarDisewa'));
    }
     public function konfirmasi($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);
        $pemesanan->status = 'Lunas';
        $pemesanan->save();

        // Tambah lagi 1 kamar yang kosong
        $pemesanan->kost->increment('jumlah_kamar');

        return redirect()->route('pemilik.sewa-kamar')->with('success', 'Pembayaran telah diselesaikan.');
    }

    public function setujui($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);
        $pemesanan->status = 'disewa';
        $pemesanan->save();

        return redirect()->route('pemilik.sewa-kamar')->with('success', 'Pemesanan telah disetujui!');
    }

    public function tolak($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);
        $pemesanan->status = 'ditolak';
        $pemesanan->save();

        return redirect()->route('pemilik.sewa-kamar')->with('error', 'Pemesanan telah ditolak.');
    }

     public function selesai($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);
        $pemesanan->status = 'selesai';
        $pemesanan->save();

        // Tambah lagi 1 kamar yang kosong
        $pemesanan->kost->increment('jumlah_kamar');

        return redirect()->route('pemilik.sewa-kamar')->with('success', 'Penyewaan telah diselesaikan.');
    }

    public function hapus($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);
        $pemesanan->delete();

        return redirect()->route('pemilik.sewa-kamar')->with('success', 'Data pemesanan berhasil dihapus.');
    }

   
}

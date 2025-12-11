<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\Kost;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PemesananController extends Controller
{
    public function store(Request $request, $kost_id)
    {
        $kost = Kost::findOrFail($kost_id);

    $pemesanan = Pemesanan::create([
        'user_id' => Auth::id(),
        'pemilik_id' => $kost->user_id,  // WAJIB TAMBAH!
        'kost_id' => $kost->id,
        'tanggal_mulai' => $request->tanggal_mulai,
        'tanggal_selesai' => $request->tanggal_selesai,
        'status' => 'pending',
    ]);

         $user = Auth::user();
    $kost = \App\Models\Kost::findOrFail($kost_id);

    // ✅ Cek apakah user sudah pernah memesan kost ini
    $existing = \App\Models\Pemesanan::where('user_id', $user->id)
        ->where('kost_id', $kost_id)
        ->whereIn('status', ['menunggu', 'disewa', 'pending'])
        ->first();


    // Hitung total harga berdasarkan durasi sewa
    $tanggalMulai = new \DateTime($request->tanggal_mulai);
    $tanggalSelesai = new \DateTime($request->tanggal_selesai);
    $interval = $tanggalMulai->diff($tanggalSelesai);
    $jumlahBulan = ($interval->y * 12) + $interval->m + ($interval->d > 0 ? 1 : 0); // Bulatkan ke atas
    $totalHarga = $jumlahBulan * $kost->harga;     
    // Upload bukti pembayaran
    $filePath = null;
    if ($request->hasFile('bukti_pembayaran')) {
        $filePath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
    }

    if ($existing) {
        // Jika sudah pernah pesan, kembalikan ke dashboard dengan pesan peringatan
        return redirect()->route('dashboard.user')->with('warning', 'Kamu sudah memesan kost ini sebelumnya! Silakan tunggu konfirmasi dari pemilik.');
    }
       Pemesanan::create([
        'user_id' => auth()->id(),
        'pemilik_id' => $kost->user_id,
        'kost_id' => $kost->id,
        'metode_pembayaran' => $request->metode_pembayaran,
        'tanggal_mulai' => $request->tanggal_mulai,
        'tanggal_selesai' => $request->tanggal_selesai,
        'bukti_pembayaran' => $filePath,
        'total_harga' => $totalHarga,
        'status' => 'pending',
    ]);

    Notifikasi::create([
        'user_id' => $kost->user_id,
        'pemesanan_id' => $pemesanan->id,
        'pesan' => 'Pemesanan baru untuk ' . $kost->nama,
        'status' => 'unread',
    ]);


        return redirect()->route('dashboard.user')->with('success', 'Pemesanan berhasil dikirim! Tunggu konfirmasi pemilik.');
    }

     public function status()
    {
        $user = Auth::user();

        // Ambil semua pemesanan milik user yang login
        $pemesanan = Pemesanan::with('kost')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.status_pemesanan', compact('pemesanan'));
    }

    public function detail($id)
{
    
     $pemesanan = Pemesanan::with('kost', 'user')->findOrFail($id);
    return view('pemesanan.detail', compact('pemesanan'));
}

public function showForm($kostId)
    {
        $kost = Kost::findOrFail($kostId);
        $user = Auth::user();

        return view('pemesanan.form', compact('kost', 'user'));
    }

    public function selesai($id)
{
    $pemesanan = \App\Models\Pemesanan::findOrFail($id);
    
    // Ubah status jadi selesai
    $pemesanan->status = 'selesai';
    $pemesanan->save();

    // (Opsional) ubah status kost jadi tersedia
    if ($pemesanan->kost) {
        $pemesanan->kost->update(['status' => 'tersedia']);
    }

    return redirect()->back()->with('success', 'Pemesanan telah diselesaikan.');
}

    public function pembayaran($id)
{
    $pemesanan = Pemesanan::with('kost', 'user')->findOrFail($id);

    if ($pemesanan->status != 'disewa') {
        return redirect()->back()->with('error', 'Pembayaran hanya dapat dilakukan setelah disetujui pemilik!');
    }

    return view('pembayaran.index', compact('pemesanan'));
}

public function prosesPembayaran($id)
{
    $pemesanan = Pemesanan::findOrFail($id);

    // Update status
    $pemesanan->status = 'Menunggu Konfirmasi Pembayaran';
    $pemesanan->save();

    // Kirim notifikasi ke pemilik kost
    Notifikasi::create([
    'pemesanan_id' => $pemesanan->id,     // 💥 WAJIB ADA INI
    'user_id' => $pemesanan->user_id,
    'pesan' => "Ada pembayaran baru dari {$pemesanan->user->name} untuk kost {$pemesanan->kost->nama}",
    'status' => 'unread'
]);


    return redirect()->back()->with('success', 'Pembayaran berhasil! Menunggu konfirmasi pemilik.');
}



public function tolak($id)
{
    $pemesanan = Pemesanan::findOrFail($id);
    $pemesanan->status = 'ditolak';
    $pemesanan->save();

    Notifikasi::create([
    'pemesanan_id' => $pesan->id, // tambahkan ini
    'user_id' => $pesan->user_id,
    'pesan' => "Ada pembayaran baru dari {$pesan->user->name} untuk kost {$pesan->kost->nama}",
    'status' => 'unread'
]);


    return back()->with('error', 'Pembayaran ditolak.');
}


}

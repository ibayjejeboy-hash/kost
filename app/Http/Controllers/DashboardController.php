<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Chat; // ⬅️ tambahkan ini!
use App\Models\Kost;
use App\Models\Pemesanan;
use App\Models\Testimoni;
use App\Models\Notifikasi;


class DashboardController extends Controller
{
    public function admin()
    {
         $kosts = Kost::with('user')->get(); // relasi pemilik
    
    return view('dashboard.admin', compact('kosts'));
        return view('dashboard.admin');
    }

    public function pemilik()
    {
        $user = Auth::user();

        // Hitung total chat masuk (yang dikirim ke user login)
        $pesanMasuk = Chat::where('receiver_id', $user->id)->count();

        return view('dashboard.pemilik', compact('pesanMasuk'));
        
         $user = Auth::user();

    // Hitung pesan masuk
    $pesanMasuk = \App\Models\Chat::where('receiver_id', $user->id)->count();

    // Hitung kamar disewa (pemesanan dengan status disewa untuk kost milik pemilik ini)
    $kamarDisewa = Pemesanan::whereHas('kost', function ($q) use ($user) {
        $q->where('pemilik_id', $user->id);
    })->where('status', 'disewa')->count();

    $kosts = Kost::where('pemilik_id', auth()->id())->get();
    
    return view('dashboard.pemilik', compact('kosts'));

    return view('dashboard.pemilik', compact('pesanMasuk', 'kamarDisewa'));
    }

    public function user(Request $request)
    {

        $user = Auth::user();

    // Ambil keyword pencarian
    $search = $request->input('search');

    // Query kost
    $kosts = \App\Models\Kost::query();

    // Jika ada pencarian, filter hasilnya
    if (!empty($search)) {
        $kosts->where('nama_kost', 'like', '%' . $search . '%')
              ->orWhere('alamat', 'like', '%' . $search . '%')
              ->orWhere('deskripsi', 'like', '%' . $search . '%');
    }
        $user = Auth::user();

    $kosts = \App\Models\Kost::latest()->take(6)->get();

    $pemesanan = \App\Models\Pemesanan::with('kost')
        ->where('user_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->get();

     $user = Auth::user();

    $pemesanan = Pemesanan::where('user_id', $user->id)->get();

    // Ambil notifikasi user
    $notifikasi = Notifikasi::where('user_id', $user->id)
                            ->orderBy('created_at', 'desc')
                            ->get();
    
     $user = Auth::user();

        // Ambil semua kost untuk rekomendasi
        $kosts = Kost::all();

        // Ambil semua pemesanan milik user
        $pemesanan = Pemesanan::where('user_id', $user->id)
                              ->with('kost') // supaya relasi kost bisa dipakai di Blade
                              ->get();

        // Ambil semua notifikasi user
        $notifikasi = Notifikasi::where('user_id', $user->id)
                                ->orderBy('created_at', 'desc')
                                ->get();

        // Kirim semua data ke view
    return view('dashboard.user', compact('kosts', 'pemesanan', 'notifikasi'));
    

    return view('dashboard.user', compact('pemesanan', 'notifikasi'));
    return view('dashboard.user', compact('kosts', 'pemesanan'));
    return view('dashboard.user', compact('kosts', 'pemesanan', 'jumlahDipesan'));
    }

    public function statusPemesanan()
{
    $user = Auth::user();

    // Ambil semua pemesanan milik user login
    $pemesanan = Pemesanan::with('kost')
        ->where('user_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->get();

    return view('user.status-pemesanan', compact('pemesanan'));
}

 public function index()
    {
        // Hitung jumlah kost
        $totalKost = Kost::count();

        // Kirim ke view dashboard
        return view('dashboard.index', compact('totalKost'));
    }

    public function testimoni()
{
    $testimoni = Testimoni::with(['user', 'kost'])->latest()->get();

    return view('admin.testimoni', compact('testimoni'));
}

public function destroyTestimoni($id)
{
    $testimoni = Testimoni::findOrFail($id);
    $testimoni->delete();

    return back()->with('success', 'Testimoni berhasil dihapus!');
}

public function setujui($id)
{
    $pemesanan = Pemesanan::findOrFail($id);
    $pemesanan->status = 'disewa';
    $pemesanan->save();

    // Buat notifikasi untuk user
    Notifikasi::create([
        'user_id' => $pemesanan->user_id,
        'pemesanan_id' => $pemesanan->id,
        'pesan' => "Pesananmu untuk '{$pemesanan->kost->nama}' telah disetujui!",
        'status' => 'unread',
    ]);

    return redirect()->back()->with('success', 'Pesanan telah disetujui!');
}



}

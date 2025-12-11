<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PemilikController;
use App\Http\Controllers\KostController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\SewaKamarController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\TestimoniController;
use App\Http\Controllers\PembayaranController;



Route::get('/', function () {
    return view('landing');
})->name('landing');


// ---------- DASHBOARD ----------
Route::middleware('auth')->group(function () {
    Route::get('/dashboard/user', [DashboardController::class, 'user'])->name('dashboard.user');
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
    Route::get('/dashboard/pemilik', [DashboardController::class, 'pemilik'])->name('dashboard.pemilik');
    Route::get('/dashboard/pemilik', [KostController::class, 'myKosts'])->name('dashboard.pemilik');
    Route::get('/dashboard', [DashboardController::class, 'pemilik'])->name('dashboard.pemilik');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('kost', App\Http\Controllers\KostController::class);
   Route::get('/admin/testimoni', [DashboardController::class, 'testimoni'])->name('admin.testimoni');
Route::delete('/admin/testimoni/{id}', [TestimoniController::class, 'destroy'])->name('testimoni.destroy');
 Route::post('/testimoni/store/{pemesanan}', [TestimoniController::class, 'store'])->name('testimoni.store');



});

// ---------- AUTH ----------
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'registerpost'])->name('register.post');   

// ---------- CHAT ----------
Route::middleware(['auth'])->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{receiver_id}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{receiver_id}', [ChatController::class, 'store'])->name('chat.store');
});

// ---------- PEMILIK ----------
Route::middleware(['auth'])->group(function () {
    Route::get('/pemilik/dashboard', [PemilikController::class, 'dashboard'])->name('pemilik.dashboard');
    Route::get('/pemilik/kost/create', [KostController::class, 'create'])->name('kost.create');
    Route::post('/pemilik/kost', [KostController::class, 'store'])->name('kost.store');
    Route::get('/pemilik/sewa-kamar', [SewaKamarController::class, 'index'])->name('pemilik.sewa-kamar');
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');
    Route::get('/notifikasi/mark-read', [NotifikasiController::class, 'markRead'])->name('notifikasi.markRead');
    Route::get('/notifikasi/{id}/read', [NotifikasiController::class, 'read'])
    ->name('notifikasi.read');

});

// ---------- PEMESANAN ----------
Route::middleware(['auth'])->group(function () {
    Route::post('/pemesanan/{kost_id}', [PemesananController::class, 'store'])->name('pemesanan.store');
    Route::get('/user/status-pemesanan', [PemesananController::class, 'status'])
    ->name('user.status-pemesanan');
    Route::get('/user/pemesanan/{id}', [PemesananController::class, 'detail'])
    ->name('user.detail-pemesanan');
     Route::get('/status-pemesanan', [DashboardController::class, 'statusPemesanan'])->name('status.pemesanan');
    Route::post('/pemesanan/{kost}', [PemesananController::class, 'store'])->name('pemesanan.store');
    Route::get('/pemesanan/{kost}', [PemesananController::class, 'showForm'])->name('pemesanan.form');
    Route::put('/pemesanan/{id}/selesai', [PemesananController::class, 'selesai'])
    ->name('pemesanan.selesai');
    Route::get('/pemesanan/{id}/detail', [PemesananController::class, 'detail'])->name('pemesanan.detail');
    Route::post('/pemesanan/{id}', [PemesananController::class, 'store'])->name('pemesanan.store');
    Route::get('/pembayaran/{id}', [PemesananController::class, 'pembayaran'])->name('pembayaran.show');
    Route::post('/pembayaran/{id}/proses', [PemesananController::class, 'prosesPembayaran'])->name('pembayaran.proses');
    Route::post('/pembayaran/{id}/konfirmasi', [PembayaranController::class, 'konfirmasi'])->name('pembayaran.konfirmasi');
    Route::post('/pembayaran/{id}/tolak', [PembayaranController::class, 'tolak'])->name('pembayaran.tolak');
   Route::post('/pemilik/pemesanan/{id}/konfirmasi-pembayaran', 
    [App\Http\Controllers\PemilikController::class, 'konfirmasiPembayaran']
)->name('pemilik.konfirmasiPembayaran');
    Route::get('/dashboard/pemilik/kamar-disewa', [PemilikController::class, 'kamarDisewa'])
    ->name('pemilik.kamarDisewa');


});

Route::get('/kost', [KostController::class, 'index'])->name('kost.index');
Route::get('/kost/{id}', [KostController::class, 'show'])->name('kost.show');
Route::get('/kost/{id}/edit', [KostController::class, 'edit'])->name('kost.edit');
Route::put('/kost/{id}', [KostController::class, 'update'])->name('kost.update');
Route::get('/cari-kost', [KostController::class, 'search'])->name('kost.search');


Route::middleware('auth')->group(function () {
    Route::get('/pemilik/sewa-kamar', [SewaKamarController::class, 'index'])->name('pemilik.sewa-kamar');
    Route::post('/pemilik/sewa-kamar/{id}/setujui', [SewaKamarController::class, 'setujui'])->name('pemilik.setujui');
    Route::post('/pemilik/sewa-kamar/{id}/tolak', [SewaKamarController::class, 'tolak'])->name('pemilik.tolak');
     Route::post('/pemilik/sewa-kamar/{id}/selesai', [SewaKamarController::class, 'selesai'])->name('pemilik.selesai');
    Route::delete('/pemilik/sewa-kamar/{id}/hapus', [SewaKamarController::class, 'hapus'])->name('pemilik.hapus');
});
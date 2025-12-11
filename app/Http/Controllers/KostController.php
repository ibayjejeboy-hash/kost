<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kost;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Auth;

class KostController extends Controller
{
    
     public function show($id)
    {
        $kost = Kost::find($id);

        if (!$kost) {
            abort(404, 'Kost tidak ditemukan');
        }

        return view('kost.show', compact('kost'));

        $kost = Kost::find($id);

        if (!$kost) {
            return redirect()->back()->with('error', 'Kost tidak ditemukan');
        }

        $kost = Kost::with('testimonis.user')->findOrFail($id); // ambil kost + testimoni beserta user

    $userId = auth()->id();

    // ambil semua pemesanan user untuk kost ini
    $pemesanan = Pemesanan::where('kost_id', $id)
                           ->where('user_id', $userId)
                           ->whereIn('status', ['disewa', 'selesai'])
                           ->get();

    return view('kost.show', compact('kost', 'pemesanan'));
        
    }

    
    public function create()
    {
        return view('pemilik.tambah-kost');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kota' => 'required|string',
            'harga' => 'required|integer',
            'jumlah_kamar' => 'required|integer',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|max:2048',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('kost_images', 'public');
        }

        Kost::create([
            'pemilik_id' => Auth::id(),
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'kota' => $request->kota,
            'harga' => $request->harga,
            'jumlah_kamar' => $request->jumlah_kamar,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambarPath,
        ]);

        return redirect()->route('dashboard.pemilik')->with('success', 'Kost berhasil ditambahkan!');
    }
    
    public function index()
    {
       $kosts = \App\Models\Kost::with('pemilik')->get();
    return view('dashboard.user', compact('kosts'));
    }

    public function myKosts()
{
    $pemilikId = Auth::id();
    $kosts = Kost::where('pemilik_id', $pemilikId)->get();

    return view('dashboard-pemilik', compact('kosts'));
}

public function edit($id)
{
    $kost = Kost::findOrFail($id);

    // Hanya pemilik kost yang bisa mengedit kost miliknya
    if (Auth::user()->role != 'pemilik' || $kost->pemilik_id != Auth::id()) {
        abort(403, 'Anda tidak berhak mengedit kost ini.');
    }

    return view('kost.edit', compact('kost'));
}

public function update(Request $request, $id)
{
    $kost = Kost::findOrFail($id);

    if (Auth::user()->role != 'pemilik' || $kost->pemilik_id != Auth::id()) {
        abort(403, 'Anda tidak berhak mengedit kost ini.');
    }

    $request->validate([
        'nama' => 'required|string|max:255',
        'alamat' => 'required|string',
        'kota' => 'required|string',
        'harga' => 'required|numeric|min:0',
        'jumlah_kamar' => 'required|integer|min:1',
        'deskripsi' => 'nullable|string',
        'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $data = $request->only(['nama', 'alamat', 'kota', 'harga', 'jumlah_kamar', 'deskripsi']);

    if ($request->hasFile('gambar')) {
        $path = $request->file('gambar')->store('kost', 'public');
        $data['gambar'] = $path;
    }

    $kost->update($data);

    return redirect()->route('kost.show', $kost->id)
                     ->with('success', 'Data kost berhasil diperbarui!');
}

public function search(Request $request)
{
    $search = $request->input('search');

    $kosts = Kost::query();

    if (!empty($search)) {
        $kosts->where('nama', 'like', '%' . $search . '%')
              ->orWhere('kota', 'LIKE', "%{$search}%")
              ->orWhere('alamat', 'like', '%' . $search . '%')
              ->orWhere('deskripsi', 'like', '%' . $search . '%');
    }

    $kosts = $kosts->latest()->get();

    return view('kost.search', compact('kosts', 'search'));
}

public function destroy($id)
{
    $kost = Kost::findOrFail($id);
    $kost->delete();

    return redirect()->back()->with('success', 'Kost berhasil dihapus!');
}

}

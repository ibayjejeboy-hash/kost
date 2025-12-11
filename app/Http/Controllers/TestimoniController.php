<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimoni;
use App\Models\Kost;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Auth;

class TestimoniController extends Controller
{
     public function store(Request $request, Pemesanan $pemesanan)
{
    $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'komentar' => 'required|string|max:500',
    ]);

    Testimoni::create([
        'kost_id' => $pemesanan->kost_id,
        'user_id' => Auth::id(),
        'rating' => $request->rating,
        'komentar' => $request->komentar, // FIX
    ]);

    return redirect()->back()->with('success', 'Testimoni berhasil dikirim!');
}

}

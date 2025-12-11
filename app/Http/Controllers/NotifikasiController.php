<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifikasi = Notifikasi::where('user_id', Auth::id())
                                  ->orderBy('created_at', 'desc')
                                  ->get();

        return view('pemilik.notifikasi', compact('notifikasi'));
    }

    public function markRead()
{
    $user = Auth::user();
    Notifikasi::where('user_id', $user->id)->where('status','unread')->update(['status'=>'read']);
    return redirect()->back();
}

}

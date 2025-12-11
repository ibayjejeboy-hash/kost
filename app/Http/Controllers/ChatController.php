<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // Lihat semua chat masuk ke pemilik
    public function index()
    {
        $user = Auth::user();

        // Ambil semua pengirim unik yang mengirim pesan ke pemilik
        $senders = Chat::where('receiver_id', $user->id)
            ->with('sender')
            ->latest()
            ->get()
            ->groupBy('sender_id');

        return view('chat.index', compact('senders'));
    }

    // Buka percakapan dengan 1 pencari kost
     public function show($receiver_id)
    {
        $receiver = User::findOrFail($receiver_id);
        $sender_id = Auth::id();

        // Ambil semua chat dua arah
        $chats = Chat::where(function ($query) use ($sender_id, $receiver_id) {
                $query->where('sender_id', $sender_id)
                      ->where('receiver_id', $receiver_id);
            })
            ->orWhere(function ($query) use ($sender_id, $receiver_id) {
                $query->where('sender_id', $receiver_id)
                      ->where('receiver_id', $sender_id);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return view('chat.show', compact('chats', 'receiver', 'receiver_id'));
    }

    // Menyimpan pesan baru
    public function store(Request $request, $receiver_id)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        Chat::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $receiver_id,
            'message' => $request->message,
        ]);

        return redirect()->route('chat.show', $receiver_id);
    }
}
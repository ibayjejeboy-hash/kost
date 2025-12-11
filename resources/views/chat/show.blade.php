<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Chat | GoKost</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 font-sans min-h-screen flex flex-col">

  <!-- Header -->
  <header class="bg-purple-600 text-white px-8 py-4 flex justify-between items-center shadow-md">
    <h1 class="text-2xl font-bold">GoKost</h1>

    <a 
      href="
        @if(Auth::user()->role == 'pemilik')
            {{ route('dashboard.pemilik') }}
        @elseif(Auth::user()->role == 'admin')
            {{ route('dashboard.admin') }}
        @else
            {{ route('dashboard.user') }}
        @endif
      " 
      class="bg-white text-purple-600 px-4 py-2 rounded-lg hover:bg-purple-100 transition"
    >
    Kembali
    </a>
  </header>

  <!-- Main Chat Section -->
  <main class="flex-1 p-6 max-w-4xl mx-auto w-full overflow-y-auto space-y-4 bg-white rounded-xl shadow mt-6 mb-4">
    <h2 class="text-xl font-semibold text-gray-800 mb-4 text-center">
      Chat dengan <span class="text-purple-600">{{ $receiver->name ?? 'Pemilik Kost' }}</span>
    </h2>

    <div class="space-y-3">
      @forelse ($chats as $chat)
        <div class="flex {{ $chat->sender_id == Auth::id() ? 'justify-end' : 'justify-start' }}">
          <div class="{{ $chat->sender_id == Auth::id() ? 'bg-purple-600 text-white' : 'bg-gray-100 text-gray-800' }} shadow px-4 py-2 rounded-2xl max-w-xs break-words">
            <p class="text-xs font-semibold mb-1">
              {{ $chat->sender_id == Auth::id() ? 'Kamu' : $receiver->name }}
            </p>
            <p class="text-sm">{{ $chat->message }}</p>
            <p class="text-xs mt-1 opacity-70 text-right">{{ $chat->created_at->diffForHumans() }}</p>
          </div>
        </div>
      @empty
        <p class="text-gray-500 text-center mt-10">Belum ada pesan yang dikirim.</p>
      @endforelse
    </div>
  </main>

  <!-- Input Chat -->
  <footer class="bg-white border-t shadow p-4">
    <form action="{{ route('chat.store', $receiver_id) }}" method="POST" class="flex gap-2 max-w-4xl mx-auto">
      @csrf
      <input 
        type="text" 
        name="message" 
        placeholder="Ketik pesan kamu..." 
        required
        class="flex-1 border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400"
      >
      <button 
        type="submit" 
        class="bg-purple-600 hover:bg-purple-700 text-white px-6 rounded-xl font-semibold transition"
      >
        Kirim
      </button>
    </form>
  </footer>

  <!-- Footer -->
  <div class="text-center py-4 text-gray-500 text-sm mt-auto border-t">
    © 2025 GoKost. Semua hak dilindungi.
  </div>

</body>
</html>

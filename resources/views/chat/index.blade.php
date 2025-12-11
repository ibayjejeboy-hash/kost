<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pesan Masuk | GoKost</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 p-6">

  <div class="max-w-3xl mx-auto bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-4">📩 Pesan dari Pencari Kost</h1>

    @forelse ($senders as $sender_id => $chatList)
      @php $sender = $chatList->first()->sender; @endphp
      <div class="flex items-center justify-between border-b py-3">
        <div>
          <p class="font-semibold">{{ $sender->name }}</p>
          <p class="text-gray-500 text-sm">{{ Str::limit($chatList->last()->message, 40) }}</p>
        </div>
        <a href="{{ route('chat.show', $sender->id) }}" class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700">Buka Chat</a>
      </div>
    @empty
      <p class="text-gray-500">Belum ada pesan masuk.</p>
    @endforelse

    <div class="mt-6">
      <a href="{{ route('dashboard.pemilik') }}" class="text-purple-600 hover:underline">← Kembali ke Dashboard</a>
    </div>
  </div>

</body>
</html>

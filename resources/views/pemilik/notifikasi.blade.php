<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Notifikasi | GoKost</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen font-sans">

  <!-- HEADER -->
  <header class="bg-purple-600 text-white px-8 py-4 flex justify-between items-center shadow">
    <h1 class="text-2xl font-bold">🔔 Notifikasi Pemesanan</h1>
    <a href="{{ route('dashboard.pemilik') }}"
       class="bg-white text-purple-600 px-4 py-2 rounded-lg hover:bg-purple-100 transition">
       Kembali
    </a>
  </header>

  <main class="max-w-3xl mx-auto mt-8 p-6 space-y-4">

    @forelse ($notifikasi as $n)
      <div class="bg-white shadow-md rounded-xl p-5 border border-gray-200 hover:shadow-lg transition">

        <h3 class="text-lg font-semibold text-gray-800 mb-1">
          📢 Pemesanan Baru
        </h3>

        <p class="text-gray-700 mb-1">
          Ada pemesanan baru untuk <strong>{{ $n->pemesanan->kost->nama }}</strong>
          oleh <strong>{{ $n->pemesanan->user->name }}</strong>
        </p>

        <p class="text-gray-600 text-sm">
          Tanggal: {{ $n->created_at->format('d M Y - H:i') }}
        </p>

        <span class="inline-block mt-3 bg-purple-100 text-purple-700 text-xs font-bold px-3 py-1 rounded-full">
          {{ $n->pemesanan->status }}
        </span>
      </div>

    @empty
      <p class="text-center text-gray-500 mt-10">Belum ada notifikasi terbaru.</p>
    @endforelse

  </main>

</body>
</html>

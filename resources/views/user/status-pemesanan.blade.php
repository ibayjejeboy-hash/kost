<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Status Pemesanan | GoKost</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen font-sans">
  <header class="bg-purple-600 text-white px-8 py-4 flex justify-between items-center shadow-md">
    <h1 class="text-2xl font-bold">🏠 GoKost | Status Pemesanan</h1>
    <a href="{{ route('dashboard.user') }}" 
       class="bg-white text-purple-600 px-3 py-1 rounded-md hover:bg-purple-100 transition">
       ⬅️ Kembali
    </a>
  </header>

  <main class="max-w-5xl mx-auto p-8">
    <section class="bg-white p-6 rounded-xl shadow-md">
      <h3 class="text-xl font-semibold text-gray-700 mb-4">Status Pemesanan</h3>

      @if($pemesanan->isEmpty())
        <p class="text-gray-500 text-center py-6">Belum ada pemesanan kost yang kamu buat.</p>
      @else
        <table class="w-full border-collapse">
          <thead>
            <tr class="bg-purple-100 text-gray-700">
              <th class="p-3 text-left">Nama Kost</th>
              <th class="p-3 text-left">Tanggal Pesan</th>
              <th class="p-3 text-left">Status</th>
              <th class="p-3 text-left">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($pemesanan as $pesan)
              <tr class="border-b hover:bg-gray-50 transition">
                <td class="p-3">{{ $pesan->kost->nama ?? '-' }}</td>
                <td class="p-3">{{ $pesan->created_at->format('d F Y') }}</td>
                <td class="p-3">
                  @php
                    $warna = match($pesan->status) {
                      'disewa' => 'bg-green-100 text-green-700',
                      'pending' => 'bg-yellow-100 text-yellow-700',
                      'ditolak' => 'bg-red-100 text-red-700',
                      'selesai' => 'bg-blue-100 text-blue-700',
                      default => 'bg-gray-100 text-gray-600',
                    };
                  @endphp
                  <span class="px-3 py-1 rounded-full text-sm {{ $warna }}">
                    {{ ucfirst($pesan->status) }}
                  </span>
                </td>
                <td class="p-3">
                  <a href="#" class="text-blue-600 hover:underline">Lihat Detail</a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </section>
  </main>

  <footer class="text-center py-6 text-gray-500 text-sm mt-10 border-t">
    © 2025 GoKost. Semua hak dilindungi.
  </footer>
</body>
</html>

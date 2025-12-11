<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kamar Disewa | GoKost</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: { primary: "#7C3AED", accent: "#A78BFA" }
        }
      }
    }
  </script>
</head>

<body class="bg-gray-50 font-sans min-h-screen">

<header class="bg-primary text-white px-8 py-4 flex justify-between items-center shadow-md">
  <h1 class="text-2xl font-bold">🏠 GoKost | Kamar Disewa</h1>
  <a href="{{ route('dashboard.pemilik') }}" 
     class="bg-white text-primary px-4 py-2 rounded-lg hover:bg-purple-100 transition">
     ⬅️ Kembali
  </a>
</header>

<main class="max-w-5xl mx-auto mt-10">
  <h2 class="text-2xl font-bold text-gray-800 mb-6">Data Hasil Sewa</h2>

  @if(session('success'))
    <div class="bg-green-100 border border-green-300 text-green-800 p-3 mb-6 rounded-lg">
      {{ session('success') }}
    </div>
  @endif

  @if(session('error'))
    <div class="bg-red-100 border border-red-300 text-red-800 p-3 mb-6 rounded-lg">
      {{ session('error') }}
    </div>
  @endif

  @if($pemesanan->isEmpty())
    <div class="bg-white p-8 rounded-xl shadow-md text-center text-gray-500">
      Belum ada kamar yang disewa.
    </div>
  @else
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
      @foreach($pemesanan as $pesan)
      <div class="bg-white p-6 rounded-2xl shadow-lg border hover:shadow-xl transition">
        
        <!-- Kost & Foto -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <img src="{{ asset('storage/' . $pesan->kost->gambar) }}" 
               class="rounded-xl shadow-md w-full h-40 object-cover">

          <div>
            <h3 class="text-xl font-bold text-primary mb-2">{{ $pesan->kost->nama }}</h3>
            <p class="text-gray-600"><strong>Alamat:</strong> {{ $pesan->kost->alamat }}</p>
            <p class="text-gray-600"><strong>Harga:</strong> Rp {{ number_format($pesan->kost->harga, 0, ',', '.') }} / bulan</p>
          </div>
        </div>

        <hr class="my-4">

        <!-- Data Penyewa -->
        <h4 class="text-lg font-semibold text-gray-700 mb-2">👤 Data Penyewa</h4>
        <p><strong>Nama:</strong> {{ $pesan->user->name }}</p>
        <p><strong>Email:</strong> {{ $pesan->user->email }}</p>
        <p><strong>Mulai:</strong> {{ $pesan->tanggal_mulai }}</p>
        <p><strong>Selesai:</strong> {{ $pesan->tanggal_selesai ?? '-' }}</p>

        <hr class="my-4">




        <!-- Status -->
        <p class="mt-3">
          <strong>Status:</strong>
          <span class="font-bold 
            @if($pesan->status == 'Menunggu Konfirmasi Pembayaran' && $pesan->bukti_pembayaran)
              text-blue-600
            @elseif($pesan->status == 'disewa') text-green-600    
            @elseif($pesan->status == 'pending') text-yellow-600
            @elseif($pesan->status == 'ditolak') text-red-600
            @else text-gray-600 @endif">
            {{ ucfirst($pesan->status) }}
          </span>
        </p>

  <!-- Tombol aksi -->
<div class="mt-5 flex flex-wrap gap-3 justify-end">

  @if($pesan->status == 'pending')
    <form action="{{ route('pemilik.setujui', $pesan->id) }}" method="POST">
      @csrf
      <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
        ✅ Setujui
      </button>
    </form>

    <form action="{{ route('pemilik.tolak', $pesan->id) }}" method="POST">
      @csrf
      <button class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
        ❌ Tolak
      </button>
    </form>
  @endif

 @if($pesan->status == 'Menunggu Konfirmasi Pembayaran')
<form action="{{ route('pemilik.konfirmasiPembayaran', $pesan->id) }}" method="POST">
    @csrf
    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
        💳 Konfirmasi Pembayaran
    </button>
</form>
@endif




  @if(in_array($pesan->status, ['ditolak', 'selesai']))
    <form action="{{ route('pemilik.hapus', $pesan->id) }}" method="POST">
      @csrf @method('DELETE')
      <button class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
        🗑️ Hapus
      </button>
    </form>
  @endif

</div>



          

      </div>
      @endforeach
    </div>
  @endif

</main>

<footer class="text-center py-6 text-gray-500 text-sm mt-10 border-t">
  © 2025 GoKost. Semua hak dilindungi.
</footer>

</body>
</html>

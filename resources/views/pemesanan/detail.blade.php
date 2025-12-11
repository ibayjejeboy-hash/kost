<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Detail Pemesanan | GoKost</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex justify-center py-10">

  <div class="bg-white w-full max-w-3xl shadow-xl rounded-2xl p-8">
    <a href="{{ route('dashboard.user') }}" class="text-sm text-gray-600 hover:underline">← Kembali</a>

    <h2 class="text-2xl font-bold text-gray-800 mt-3 mb-6">Detail Transaksi Pemesanan</h2>

    <!-- Info Kost -->
    <div class="bg-gray-50 p-5 rounded-xl shadow-sm border mb-6">
      <h3 class="text-xl font-bold text-primary mb-2">{{ $pemesanan->kost->nama }}</h3>
      <p class="text-gray-600">{{ $pemesanan->kost->alamat }}</p>
      <p class="font-semibold text-primary mt-2">Rp {{ number_format($pemesanan->kost->harga, 0, ',', '.') }} / bulan</p>
    </div>

    <!-- Detail Pemesanan -->
    <div class="bg-gray-50 p-5 rounded-xl shadow-sm border mb-6">
      <h3 class="font-bold text-lg text-gray-800 mb-3">Detail Pemesanan</h3>
      <p><span class="font-semibold">Tanggal Pesan:</span> {{ $pemesanan->created_at->format('d F Y') }}</p>
      <p><span class="font-semibold">Pemilik Kost:</span> {{ $pemesanan->kost->pemilik->name }}</p>

      @php
        $warna = match($pemesanan->status) {
          'menunggu' => 'bg-yellow-100 text-yellow-800',
          'disewa' => 'bg-green-100 text-green-700',
          'ditolak' => 'bg-red-100 text-red-700',
          'selesai' => 'bg-blue-100 text-blue-700',
          default => 'bg-gray-100 text-gray-600',
        };
      @endphp

      <p class="mt-3 font-semibold">Status:</p>
      <span class="px-4 py-2 rounded-full text-sm font-bold {{ $warna }}">
        {{ strtoupper($pemesanan->status) }}
      </span>
    </div>

    <!-- Aksi -->
   <div class="flex justify-between items-center mt-6">

  <a href="{{ route('chat.show', $pemesanan->kost->pemilik_id) }}" 
     class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm">
    💬 Chat Pemilik
  </a>

  @if($pemesanan->status == 'disewa')
    <a href="{{ route('pembayaran.show', $pemesanan->id) }}"
       class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 text-sm">
       💰 Lakukan Pembayaran
    </a>
  @endif

  @if($pemesanan->status == 'disewa')
    <form action="{{ route('pemesanan.selesai', $pemesanan->id) }}" method="POST"
          onsubmit="return confirm('Selesaikan sewa kost ini?');">
      @csrf
      @method('PUT')
      <button type="submit"
              class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 text-sm">
        ✔️ Selesaikan Sewa
      </button>
    </form>
  @endif

</div>
@if($pemesanan->status == 'selesai')
<form action="{{ route('testimoni.store', $pemesanan->id) }}" method="POST" class="mt-6 bg-gray-50 p-5 rounded-xl shadow-sm border">
    @csrf

     <label class="block text-sm font-medium">Rating</label>
    <select name="rating" class="w-full border p-2 rounded-lg">
      <option value="5">⭐⭐⭐⭐⭐ - Sangat Bagus</option>
      <option value="4">⭐⭐⭐⭐ - Bagus</option>
      <option value="3">⭐⭐⭐ - Cukup</option>
      <option value="2">⭐⭐ - Kurang</option>
      <option value="1">⭐ - Sangat Buruk</option>
    </select>
    
    <label class="block font-semibold text-gray-700 mb-2">Komentar</label>
    <textarea name="komentar" class="w-full border rounded-lg p-2 mb-4" placeholder="Tulis pengalaman Anda..." required></textarea>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
        Kirim Testimoni
    </button>
</form>
@endif



  </div>
</body>
</html>

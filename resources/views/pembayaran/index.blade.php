<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pembayaran Kost | GoKost</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex justify-center py-10">

  <div class="bg-white w-full max-w-3xl shadow-xl rounded-2xl p-8">
    <a href="{{ route('dashboard.user') }}" class="text-sm text-gray-600 hover:underline">← Kembali</a>

    <h2 class="text-2xl font-bold text-gray-800 mt-3 mb-6">Pembayaran Kost</h2>

    <!-- Info Kost -->
    <div class="bg-gray-50 p-5 rounded-xl shadow-sm border mb-6">
      <h3 class="text-xl font-bold text-primary mb-2">{{ $pemesanan->kost->nama }}</h3>
      <p class="text-gray-600">{{ $pemesanan->kost->alamat }}</p>
      <p class="font-semibold text-primary mt-2">
        Rp {{ number_format($pemesanan->kost->harga, 0, ',', '.') }} / bulan
      </p>
    </div>

    <!-- Info Pembayaran -->
    <div class="bg-gray-50 p-5 rounded-xl shadow-sm border mb-6">
      <h3 class="font-bold text-lg text-gray-800 mb-3">Detail Pembayaran</h3>
      <p><span class="font-semibold">Tanggal Transaksi:</span> {{ now()->format('d F Y') }}</p>

      <p class="mt-2 font-semibold">Total Pembayaran:</p>
        Rp {{ number_format($pemesanan->kost->harga, 0, ',', '.') }}
      </span>
    </div>

    <!-- Metode Pembayaran -->
    <div class="bg-gray-50 p-5 rounded-xl shadow-sm border mb-6">
      <h3 class="font-bold text-lg text-gray-800 mb-4">Pilih Metode Pembayaran</h3>

      <form method="POST" action="{{ route('pembayaran.proses', $pemesanan->id) }}">
        @csrf

        <label class="flex items-center gap-3 mb-3 cursor-pointer">
          <input type="radio" name="metode" value="transfer" required>
          <span class="font-medium">🏦 Transfer Bank (BCA, BRI, Mandiri, BNI)</span>
        </label>

        <label class="flex items-center gap-3 mb-3 cursor-pointer">
          <input type="radio" name="metode" value="qris">
          <span class="font-medium">📱 QRIS (Dana, OVO, Gopay, Shopeepay)</span>
        </label>

        <label class="flex items-center gap-3 cursor-pointer">
          <input type="radio" name="metode" value="cash">
          <span class="font-medium">💵 Bayar Cash ke Pemilik</span>
        </label>

        <form method="POST" action="{{ route('pembayaran.proses', $pemesanan->id) }}">
    @csrf
    <button type="submit"
        class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
        Bayar Sekarang
    </button>
</form>

      </form>
    </div>

  </div>
</body>
</html>

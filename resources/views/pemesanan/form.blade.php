<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Konfirmasi Pemesanan Kost | GoKost</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#7C3AED',
            accent: '#A78BFA',
          }
        }
      }
    }
  </script>
</head>
<body class="bg-gray-50 font-sans">

  <div class="max-w-3xl mx-auto mt-10 bg-white p-8 rounded-2xl shadow-md">
    <h1 class="text-2xl font-bold text-primary mb-6">Pemesanan Kost</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
      <div>
        <img src="{{ asset('storage/' . $kost->gambar) }}" alt="{{ $kost->nama }}" class="rounded-xl shadow-md">
      </div>

      <div>
        <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $kost->nama }}</h2>
        <p class="text-gray-600 mb-1"><strong>Alamat:</strong> {{ $kost->alamat }}</p>
        <p class="text-gray-600 mb-1"><strong>Harga:</strong> Rp {{ number_format($kost->harga, 0, ',', '.') }} / bulan</p>
        <p class="text-gray-600 mb-1"><strong>Fasilitas:</strong> {{ $kost->fasilitas ?? '-' }}</p>
      </div>
    </div>

    <div class="border-t pt-4 mb-6">
      <h3 class="text-lg font-semibold text-gray-700 mb-3">Data Pemesan</h3>
      <p><strong>Nama:</strong> {{ $user->name }}</p>
      <p><strong>Email:</strong> {{ $user->email }}</p>
    </div>
    <form action="{{ route('pemesanan.store', $kost->id) }}" method="POST" enctype="multipart/form-data">
  @csrf

    <!-- Tanggal Mulai dan Selesai -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <div>
      <label class="block font-semibold text-gray-700 mb-2">Tanggal Mulai Kost</label>
      <input type="date" name="tanggal_mulai" required
             class="w-full p-3 border rounded-lg focus:ring-primary focus:border-primary">
    </div>

    <div>
      <label class="block font-semibold text-gray-700 mb-2">Tanggal Selesai Kost</label>
      <input type="date" name="tanggal_selesai" required
             class="w-full p-3 border rounded-lg focus:ring-primary focus:border-primary">
    </div>
  </div>



  <div class="flex justify-end gap-4">
    <a href="{{ url()->previous() }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
      Batal
    </a>
    <form action="{{ route('pemesanan.store', $kost->id) }}" method="POST">
    @csrf
    <button type="submit" 
            class="bg-primary text-white px-5 py-2 rounded-lg hover:bg-purple-700 transition">
      Konfirmasi
    </button>
    </form>
  </div>

</form>

<script>
function showPaymentInfo() {
  let metode = document.getElementById('metode').value;
  let infoBox = document.getElementById('rekening-info');
  let text = document.getElementById('rekening-text');
  let upload = document.getElementById('upload-bukti');

  upload.classList.remove("hidden");

  switch (metode) {
    case 'Transfer Bank':
      infoBox.classList.remove("hidden");
      text.innerHTML = "🏦 BCA - 123456789 a.n GoKost";
      break;
    case 'Dana':
      infoBox.classList.remove("hidden");
      text.innerHTML = "📱 Dana - 089999999999 a.n GoKost";
      break;
    case 'OVO':
      infoBox.classList.remove("hidden");
      text.innerHTML = "📱 OVO - 088888888888 a.n GoKost";
      break;
    case 'Gopay':
      infoBox.classList.remove("hidden");
      text.innerHTML = "📱 Gopay - 087777777777 a.n GoKost";
      break;
    default:
      infoBox.classList.add("hidden");
      upload.classList.add("hidden");
  }
}
</script>
  </div>

</body>
</html>

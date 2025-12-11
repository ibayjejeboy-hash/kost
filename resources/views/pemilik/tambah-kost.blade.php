<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Kost | GoKost</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#7C3AED',
            secondary: '#F3F0FF',
            success: '#10B981',
            danger: '#EF4444',
            dark: '#1F1B2E',
          }
        }
      }
    }
  </script>

  <!-- Leaflet (peta OpenStreetMap) -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
</head>

<body class="bg-gradient-to-br from-gray-50 to-purple-100 min-h-screen font-sans flex flex-col">

  <!-- HEADER -->
  <header class="bg-primary text-white px-8 py-4 flex justify-between items-center shadow-lg">
    <h1 class="text-2xl font-bold tracking-wide flex items-center gap-2">
      🏠 <span>GoKost</span> <span class="text-accent text-sm font-medium ml-2">| Tambah Kost</span>
    </h1>
    <a href="{{ route('dashboard.pemilik') }}"
       class="bg-white text-primary px-4 py-2 rounded-lg font-semibold hover:bg-purple-100 transition-all duration-300 shadow-md">
      ⬅ Kembali ke Dashboard
    </a>
  </header>

  <!-- MAIN CONTENT -->
  <main class="flex-1 flex justify-center items-center px-6 py-10">
    <div class="bg-white shadow-2xl rounded-2xl p-10 w-full max-w-3xl border border-purple-100 transition-all duration-500 hover:shadow-purple-300">
      <h2 class="text-3xl font-extrabold text-center text-primary mb-8 tracking-tight">✨ Tambah Kost Baru ✨</h2>

      <!-- Notifikasi sukses -->
      @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md shadow-sm animate-fade-in">
          ✅ {{ session('success') }}
        </div>
      @endif

      <form action="{{ route('kost.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Nama Kost -->
        <div>
          <label for="nama" class="block text-gray-700 font-semibold">🏡 Nama Kost</label>
          <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required
                 class="mt-2 w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary p-3 transition">
        </div>

        <!-- Deskripsi -->
        <div>
          <label for="deskripsi" class="block text-gray-700 font-semibold">📝 Deskripsi</label>
          <textarea id="deskripsi" name="deskripsi" rows="3"
                    class="mt-2 w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary p-3 transition">{{ old('deskripsi') }}</textarea>
        </div>

        <!-- Alamat Manual -->
        <div>
          <label for="alamat" class="block text-gray-700 font-semibold">📍 Alamat Kost</label>
          <input type="text" id="alamat" name="alamat" placeholder="Masukkan alamat kost..."
                 class="mt-2 w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary p-3 transition">
        </div>

        <!-- Kota Otomatis -->
        <div>
          <label for="kota" class="block text-gray-700 font-semibold">🏙️ Kota (otomatis)</label>
          <input type="text" id="kota" name="kota" readonly
                 class="mt-2 w-full border-gray-300 bg-gray-100 rounded-lg shadow-sm p-3 text-gray-600">
        </div>

        <!-- Latitude & Longitude -->
        <div class="grid grid-cols-2 gap-6">
          <div>
            <label for="latitude" class="block text-gray-700 font-semibold">🌍 Latitude</label>
            <input type="text" id="latitude" name="latitude" readonly
                   class="mt-2 w-full border-gray-300 bg-gray-100 rounded-lg shadow-sm p-3 text-gray-600">
          </div>
          <div>
            <label for="longitude" class="block text-gray-700 font-semibold">🌍 Longitude</label>
            <input type="text" id="longitude" name="longitude" readonly
                   class="mt-2 w-full border-gray-300 bg-gray-100 rounded-lg shadow-sm p-3 text-gray-600">
          </div>
        </div>

        <!-- Peta -->
        <div id="map" class="w-full h-64 mt-4 rounded-lg shadow-md border border-purple-200"></div>

        <!-- Harga dan Jumlah Kamar -->
        <div class="grid grid-cols-2 gap-6 mt-6">
          <div>
            <label for="harga" class="block text-gray-700 font-semibold">💰 Harga (Rp)</label>
            <input type="number" id="harga" name="harga" value="{{ old('harga') }}" required
                   class="mt-2 w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary p-3 transition">
          </div>

          <div>
            <label for="jumlah_kamar" class="block text-gray-700 font-semibold">🚪 Jumlah Kamar</label>
            <input type="number" id="jumlah_kamar" name="jumlah_kamar" value="{{ old('jumlah_kamar') }}" required
                   class="mt-2 w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary p-3 transition">
          </div>
        </div>

        <!-- Upload Gambar -->
        <div>
          <label for="gambar" class="block text-gray-700 font-semibold">📸 Upload Gambar Kost</label>
          <input type="file" id="gambar" name="gambar"
                 class="mt-2 w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary p-3 transition bg-purple-50">
        </div>

        <!-- Tombol Simpan -->
        <div class="flex justify-center pt-4">
          <button type="submit"
                  class="bg-primary hover:bg-purple-700 text-white px-10 py-3 rounded-xl font-bold text-lg shadow-lg hover:shadow-purple-400 transition-all duration-300 transform hover:-translate-y-1">
            💾 Simpan Kost
          </button>
        </div>
      </form>
    </div>
  </main>

  <footer class="text-center py-6 text-gray-500 text-sm mt-auto border-t bg-white/80 backdrop-blur">
    © 2025 <span class="text-primary font-semibold">GoKost</span> — Semua hak dilindungi.
  </footer>

  <style>
    @keyframes fade-in {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in { animation: fade-in 0.6s ease-in-out; }
  </style>

  <script>
    // Inisialisasi peta
    const map = L.map('map').setView([-6.914744, 107.60981], 13); // Default Bandung
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
    }).addTo(map);
    let marker;

    const alamatInput = document.getElementById("alamat");
    const kotaInput = document.getElementById("kota");
    const latInput = document.getElementById("latitude");
    const lonInput = document.getElementById("longitude");

    // Fungsi cari lokasi dari alamat
    async function updateMap(address) {
      if (!address) return;
      try {
        const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}`);
        const data = await res.json();
        if (data.length > 0) {
          const lat = parseFloat(data[0].lat);
          const lon = parseFloat(data[0].lon);
          const city = data[0].display_name.split(",")[2] || "Tidak diketahui";

          latInput.value = lat;
          lonInput.value = lon;
          kotaInput.value = city.trim();

          map.setView([lat, lon], 15);
          if (marker) marker.setLatLng([lat, lon]);
          else marker = L.marker([lat, lon]).addTo(map);
        }
      } catch (err) {
        console.error("Gagal cari lokasi:", err);
      }
    }

    // Update otomatis ketika user ketik alamat
    let timeout = null;
    alamatInput.addEventListener("input", () => {
      clearTimeout(timeout);
      timeout = setTimeout(() => {
        updateMap(alamatInput.value);
      }, 700);
    });
  </script>

</body>
</html>

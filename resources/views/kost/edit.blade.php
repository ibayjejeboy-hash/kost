<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Kost | GoKost</title>
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

<body class="bg-gradient-to-br from-gray-50 to-purple-100 font-sans min-h-screen flex flex-col">

  <!-- HEADER -->
  <header class="bg-primary text-white px-8 py-4 flex justify-between items-center shadow-lg">
    <h1 class="text-2xl font-bold tracking-wide flex items-center gap-2">
      ✏️ <span>Edit Kost</span>
    </h1>
    <a href="{{ route('dashboard.pemilik') }}" 
       class="bg-white text-primary px-4 py-2 rounded-lg font-semibold hover:bg-purple-100 transition-all duration-300 shadow-md">
      ⬅ Kembali ke Dashboard
    </a>
  </header>

  <!-- MAIN -->
  <main class="flex-1 p-8 flex justify-center items-center">
    <div class="bg-white rounded-2xl shadow-2xl p-10 w-full max-w-3xl border border-purple-100 transition-all duration-300 hover:shadow-purple-300">
      <h2 class="text-3xl font-extrabold text-center text-primary mb-8 tracking-tight">🛠️ Perbarui Data Kost</h2>

      <!-- Notifikasi -->
      @if (session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md shadow-sm animate-fade-in">
          ✅ {{ session('success') }}
        </div>
      @endif

      <!-- FORM -->
      <form action="{{ route('kost.update', $kost->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Nama Kost -->
        <div>
          <label class="block text-gray-700 font-semibold">🏡 Nama Kost</label>
          <input type="text" name="nama" value="{{ old('nama', $kost->nama) }}" required
                 class="mt-2 w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary p-3 transition">
        </div>

        <!-- Deskripsi -->
        <div>
          <label class="block text-gray-700 font-semibold">📝 Deskripsi</label>
          <textarea name="deskripsi" rows="4"
                    class="mt-2 w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary p-3 transition">{{ old('deskripsi', $kost->deskripsi) }}</textarea>
        </div>

        <!-- Alamat -->
        <div>
          <label class="block text-gray-700 font-semibold">📍 Alamat Kost</label>
          <input type="text" id="alamat" name="alamat" value="{{ old('alamat', $kost->alamat) }}"
                 class="mt-2 w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary p-3 transition">
        </div>

        <!-- Kota -->
        <div>
          <label class="block text-gray-700 font-semibold">🏙️ Kota (otomatis)</label>
          <input type="text" id="kota" name="kota" value="{{ old('kota', $kost->kota) }}" readonly
                 class="mt-2 w-full border-gray-300 bg-gray-100 rounded-lg shadow-sm p-3 text-gray-600">
        </div>

        <!-- Latitude & Longitude -->
        <div class="grid grid-cols-2 gap-6">
          <div>
            <label class="block text-gray-700 font-semibold">🌍 Latitude</label>
            <input type="text" id="latitude" name="latitude" value="{{ old('latitude', $kost->latitude) }}" readonly
                   class="mt-2 w-full border-gray-300 bg-gray-100 rounded-lg shadow-sm p-3 text-gray-600">
          </div>
          <div>
            <label class="block text-gray-700 font-semibold">🌍 Longitude</label>
            <input type="text" id="longitude" name="longitude" value="{{ old('longitude', $kost->longitude) }}" readonly
                   class="mt-2 w-full border-gray-300 bg-gray-100 rounded-lg shadow-sm p-3 text-gray-600">
          </div>
        </div>

        <!-- Peta -->
        <div id="map" class="w-full h-64 mt-4 rounded-lg shadow-md border border-purple-200"></div>

        <!-- Harga & Jumlah Kamar -->
        <div class="grid grid-cols-2 gap-6 mt-6">
          <div>
            <label class="block text-gray-700 font-semibold">💰 Harga / Bulan (Rp)</label>
            <input type="number" name="harga" value="{{ old('harga', $kost->harga) }}" required
                   class="mt-2 w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary p-3 transition">
          </div>

          <div>
            <label class="block text-gray-700 font-semibold">🚪 Jumlah Kamar</label>
            <input type="number" name="jumlah_kamar" value="{{ old('jumlah_kamar', $kost->jumlah_kamar) }}" required
                   class="mt-2 w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary p-3 transition">
          </div>
        </div>

        <!-- Upload Gambar -->
        <div>
          <label class="block text-gray-700 font-semibold">📸 Gambar Kost</label>
          <input type="file" name="gambar" accept="image/*"
                 class="mt-2 w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary p-3 transition bg-purple-50">
          @if($kost->gambar)
            <div class="mt-3">
              <p class="text-sm text-gray-600 mb-2">Gambar saat ini:</p>
              <img src="{{ asset('storage/' . $kost->gambar) }}" alt="Gambar Kost" class="w-48 rounded-lg shadow-md border">
            </div>
          @endif
        </div>

        <!-- Tombol Simpan -->
        <div class="flex justify-center pt-4">
          <button type="submit" 
                  class="bg-primary hover:bg-purple-700 text-white px-10 py-3 rounded-xl font-bold text-lg shadow-lg hover:shadow-purple-400 transition-all duration-300 transform hover:-translate-y-1">
            💾 Simpan Perubahan
          </button>
        </div>
      </form>
    </div>
  </main>

  <!-- FOOTER -->
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
    const latInput = document.getElementById("latitude");
    const lonInput = document.getElementById("longitude");
    const alamatInput = document.getElementById("alamat");
    const kotaInput = document.getElementById("kota");

    const defaultLat = latInput.value ? parseFloat(latInput.value) : -6.914744;
    const defaultLon = lonInput.value ? parseFloat(lonInput.value) : 107.60981;

    const map = L.map('map').setView([defaultLat, defaultLon], 14);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(map);
    let marker = L.marker([defaultLat, defaultLon]).addTo(map);

    // Update marker dari input alamat
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
          marker.setLatLng([lat, lon]);
        }
      } catch (err) {
        console.error("Gagal memperbarui peta:", err);
      }
    }

    let timeout = null;
    alamatInput.addEventListener("input", () => {
      clearTimeout(timeout);
      timeout = setTimeout(() => updateMap(alamatInput.value), 700);
    });
  </script>
</body>
</html>

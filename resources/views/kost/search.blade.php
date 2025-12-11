<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hasil Pencarian Kost | GoKost</title>
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
<body class="bg-gray-50 font-sans min-h-screen flex flex-col">

  <!-- Header -->
  <header class="bg-primary text-white py-4 shadow-md">
    <div class="max-w-6xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-3">
      <!-- Tombol kembali -->
      <a href="{{ route('dashboard.user') }}" 
         class="flex items-center gap-2 text-sm md:text-base hover:text-accent transition">
        ← <span class="font-semibold">Kembali ke Dashboard</span>
      </a>

      <!-- Judul -->
      <h1 class="text-lg md:text-2xl font-bold tracking-wide text-center">
        🔍 Hasil Pencarian Kost
      </h1>
    </div>
  </header>

  <!-- Main Content -->
  <main class="flex-grow max-w-6xl mx-auto px-6 py-10">

    <!-- Pencarian -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-5 mb-10">
      <!-- Hasil kata kunci -->
      <div>
        @if(!empty($search))
          <h2 class="text-gray-700 text-base md:text-lg">
            Menampilkan hasil untuk:
            <span class="font-semibold text-primary">"{{ $search }}"</span>
          </h2>
        @else
          <h2 class="text-gray-600 text-base md:text-lg italic">Masukkan kata kunci untuk mencari kost</h2>
        @endif
      </div>

      <!-- Form -->
      <form action="{{ route('kost.search') }}" method="GET"
            class="flex items-center bg-white rounded-full overflow-hidden w-full md:w-96 shadow-md border border-gray-200">
        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Cari kost di daerahmu..."
               class="flex-1 px-5 py-3 text-gray-700 focus:outline-none" />
        <button type="submit"
                class="bg-primary text-white px-5 py-3 font-medium hover:bg-purple-700 transition">
          Cari
        </button>
      </form>
    </div>

    <!-- Daftar Kost -->
    @if($kosts->count() > 0)
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($kosts as $kost)
          <div class="bg-white rounded-2xl shadow hover:shadow-lg transition duration-300 overflow-hidden">
            <img src="{{ asset('storage/' . $kost->gambar) }}" 
                 alt="{{ $kost->nama }}" 
                 class="w-full h-48 object-cover">
            <div class="p-5">
              <h3 class="text-lg font-semibold text-gray-800 mb-1">{{ $kost->nama }}</h3>
              <p class="text-gray-600 text-sm mb-3">{{ Str::limit($kost->alamat, 60) }}</p>
              <p class="text-primary font-bold mb-3">
                Rp {{ number_format($kost->harga, 0, ',', '.') }} / bulan
              </p>
              <a href="{{ route('kost.show', $kost->id) }}" 
                 class="inline-block bg-primary text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                 Lihat Detail
              </a>
            </div>
          </div>
        @endforeach
      </div>
    @else
      <div class="text-center text-gray-500 mt-16">
        ❌ Tidak ada kost yang ditemukan untuk pencarian ini.
      </div>
    @endif

  </main>

  <!-- Footer -->
  <footer class="text-center text-gray-500 text-sm py-6 border-t">
    © 2025 <span class="font-semibold text-primary">GoKost</span>. Semua hak dilindungi.
  </footer>

</body>
</html>

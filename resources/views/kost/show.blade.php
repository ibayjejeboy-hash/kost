<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>GoKost</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#7C3AED',
            accent: '#A78BFA',
            soft: '#F5F3FF',
          },
          boxShadow: {
            glow: '0 0 15px rgba(124,58,237,0.4)',
          },
        },
      },
    };
  </script>

  <style>
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(15px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .fade-in-up {
      animation: fadeInUp 0.6s ease-out;
    }
  </style>
</head>

<body class="bg-gradient-to-br from-soft to-purple-100 font-sans min-h-screen flex flex-col">

  <!-- HEADER -->
  <header class="bg-primary text-white px-8 py-4 flex justify-between items-center shadow-lg sticky top-0 z-50 backdrop-blur-lg bg-primary/90 fade-in-up">
    <h1 class="text-2xl font-extrabold tracking-wide flex items-center gap-2">
    <span>GoKost</span>
    </h1>

    <a href="
      @if(Auth::user()->role == 'pemilik')
          {{ route('dashboard.pemilik') }}
      @elseif(Auth::user()->role == 'admin')
          {{ route('dashboard.admin') }}
      @else
          {{ route('dashboard.user') }}
      @endif
      " 
      class="bg-white text-primary px-4 py-2 rounded-lg font-semibold hover:bg-accent hover:text-white shadow transition-all duration-300">
      Kembali
    </a>
  </header>

  <!-- MAIN -->
  <main class="flex-1 p-8 max-w-5xl mx-auto fade-in-up">
    <div class="bg-white rounded-3xl shadow-glow overflow-hidden transform transition duration-300 hover:-translate-y-1 hover:shadow-2xl">

      <!-- Gambar Kost -->
      <img src="{{ asset('storage/' . $kost->gambar) }}" alt="Gambar Kost" class="w-full h-80 object-cover">

      <div class="p-8">
        <!-- Nama dan Kota -->
        <div class="flex flex-wrap justify-between items-center mb-4">
          <h2 class="text-3xl font-extrabold text-gray-800">{{ $kost->nama }}</h2>
          <span class="text-lg text-primary font-semibold bg-soft px-3 py-1 rounded-full">
               {{ ucfirst($kost->kota) }}
          </span>
        </div>

        <!-- Alamat -->
        <p class="text-gray-700 mb-4 leading-relaxed">
          <span class="font-semibold text-primary">Alamat:</span>
          <a href="https://www.google.com/maps?q={{ $kost->lat ?? 0 }},{{ $kost->lng ?? 0 }}" target="_blank" class="text-primary hover:underline ml-1">
            {{ $kost->alamat }}
          </a>
        </p>

        <!-- Info Kost -->
        <div class="flex flex-wrap items-center gap-6 mb-6 text-gray-700">
          <p class="text-xl font-semibold text-primary">
            💰 Rp {{ number_format($kost->harga, 0, ',', '.') }} / bulan
          </p>
          <p><strong>{{ $kost->jumlah_kamar }}</strong> kamar tersedia</p>
          <p>Ditambahkan: {{ $kost->created_at->format('d M Y') }}</p>
        </div>

        <!-- Deskripsi -->
        <div class="mb-8">
          <h3 class="text-lg font-bold text-gray-800 mb-2">Deskripsi Kost</h3>
          <p class="text-gray-600 leading-relaxed">
            {{ $kost->deskripsi ?? 'Belum ada deskripsi yang ditambahkan.' }}
          </p>
        </div>

        <!-- Berdasarkan Role -->
        @if(Auth::user()->role == 'pemilik')
          <div class="border-t pt-4 mt-6">
            <h3 class="text-lg font-bold text-gray-800 mb-3">📊 Informasi Tambahan</h3>
            <ul class="text-gray-700 space-y-1">
              <li>👥 Jumlah penyewa aktif: <strong>{{ $kost->penyewa_count ?? 0 }}</strong></li>
              <li>📍 Status kost: 
                <span class="{{ $kost->status == 'aktif' ? 'text-green-600' : 'text-red-600' }} font-semibold">
                  {{ ucfirst($kost->status) }}
                </span>
              </li>
            </ul>
          </div>

          <!-- Tombol Aksi -->
          <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('kost.edit', $kost->id) }}" 
              class="bg-blue-500 text-white px-5 py-2 rounded-lg hover:bg-blue-600 transition-all duration-300 shadow">
              ✏️ Edit
            </a>

            <form action="{{ route('kost.show', $kost->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kost ini?');">
              @csrf
              @method('DELETE')
              <button type="submit"
                class="bg-red-500 text-white px-5 py-2 rounded-lg hover:bg-red-600 transition-all duration-300 shadow">
                🗑️ Hapus
              </button>
            </form>
          </div>

        @elseif(Auth::user()->role == 'user')
          <!-- Tombol User -->
          <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('chat.show', $kost->pemilik_id ?? 1) }}" 
              class="bg-green-500 text-white px-5 py-2 rounded-lg hover:bg-green-600 transition-all duration-300 shadow">
              💬 Chat Pemilik
            </a>
            <a href="{{ route('pemesanan.form', $kost->id) }}"
              class="bg-primary text-white px-5 py-2 rounded-lg hover:bg-purple-800 transition-all duration-300 shadow">
              🛏️ Pesan Kost Ini
            </a>
          </div>

          <!-- Section Testimoni -->
<section class="mt-10 bg-white p-6 rounded-2xl shadow-lg">
    <h3 class="text-2xl font-bold mb-4">📝 Testimoni</h3>

    @if($kost->testimonis->isEmpty())
        <p class="text-gray-500 italic">Belum ada testimoni untuk kost ini.</p>
    @else
        <div class="space-y-4">
            @foreach($kost->testimonis as $t)
    <p>{{ $t->user->name }} - ⭐ {{ $t->rating }}</p>
    <p class="text-sm text-gray-600">{{ $t->komentar }}</p>
@endforeach
        </div>
    @endif

</section>



        @elseif(Auth::user()->role == 'admin')
          <div class="border-t pt-4 mt-6">
            <h3 class="text-lg font-bold text-gray-800 mb-2">Status Kost</h3>
            <p class="text-gray-700">
              <span class="{{ $kost->status == 'aktif' ? 'text-green-600' : 'text-red-600' }} font-semibold">
                {{ ucfirst($kost->status) }}
              </span>
            </p>
            
          </div>
        @endif
      </div>
    </div>
  </main>

  <!-- FOOTER -->
  <footer class="text-center py-6 text-gray-500 text-sm mt-10 bg-white/60 backdrop-blur border-t fade-in-up">
    © 2025 <span class="text-primary font-semibold">GoKost</span> — Semua hak dilindungi.
  </footer>
</body>
</html>

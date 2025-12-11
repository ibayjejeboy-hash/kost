<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Pencari Kost | GoKost</title>
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
        }
      }
    }
  </script>
  <style>
    /* Animasi halus untuk elemen muncul */
    @keyframes fade-in {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
      animation: fade-in 0.7s ease-out forwards;
    }

    /* Efek slide masuk dari bawah */
    @keyframes slide-up {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .animate-slide-up {
      animation: slide-up 0.6s ease-out forwards;
    }

    /* Animasi hover glowing */
    .hover-glow:hover {
      box-shadow: 0 0 20px rgba(124,58,237,0.4);
      transform: translateY(-4px);
      transition: all 0.3s ease;
    }

    /* Delay animasi untuk grid */
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }
    .delay-4 { animation-delay: 0.4s; }
  </style>
</head>

<body class="bg-gradient-to-br from-soft to-purple-100 font-sans min-h-screen flex flex-col">

  <!-- Header -->
<header class="bg-primary text-white px-8 py-4 flex justify-between items-center shadow-lg sticky top-0 z-50">
    <h1 class="text-2xl font-bold">GoKost</h1>

    <div class="flex items-center gap-5 relative">
        <!-- Tombol Notifikasi -->
        <div class="relative">
            <button id="notifBtn" class="relative bg-white text-primary px-3 py-2 rounded-full hover:bg-purple-100 transition">
                🔔
                @if($notifikasi->where('status','unread')->count() > 0)
                    <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full">
                        {{ $notifikasi->where('status','unread')->count() }}
                    </span>
                @endif
            </button>

            <!-- Dropdown -->
            <div id="notifDropdown" class="hidden absolute right-0 mt-2 w-80 bg-white text-gray-800 rounded-lg shadow-lg overflow-hidden z-50">
                <h3 class="font-bold px-4 py-2 border-b">Notifikasi</h3>
                <ul>
                    @forelse($notifikasi as $notif)
                        <li class="px-4 py-2 border-b hover:bg-purple-50">
                            <a href="{{ route('notifikasi.read', $notif->id) }}" class="flex justify-between items-center">
                                <span class="@if($notif->status == 'unread') font-bold @endif">{{ $notif->pesan }}</span>
                                <small class="text-gray-400">{{ $notif->created_at->diffForHumans() }}</small>
                            </a>
                        </li>
                    @empty
                        <li class="px-4 py-2 text-gray-500">Belum ada notifikasi.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <span class="hidden sm:block text-white/90">Halo, <b>{{ Auth::user()->name }}</b></span>
      <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" alt="Avatar" class="w-10 h-10 rounded-full border-2 border-white shadow-md" />
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="bg-white text-primary px-4 py-2 rounded-lg font-semibold hover:bg-accent hover:text-white shadow transition-all duration-300 hover-glow">
          Logout
        </button>
      </form>
    </div>
</header>

<!-- Script dropdown -->
<script>
    const btn = document.getElementById('notifBtn');
    const dropdown = document.getElementById('notifDropdown');

    btn.addEventListener('click', () => {
        dropdown.classList.toggle('hidden');
    });

    // Klik di luar dropdown -> tutup
    window.addEventListener('click', function(e) {
        if (!btn.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });
</script>


  <!-- MAIN -->
  <main class="flex-1 p-8 max-w-6xl mx-auto">

    <!-- ALERT -->
    @if (session('success'))
      <div class="mb-6 bg-green-50 border border-green-400 text-green-700 p-4 rounded-xl shadow animate-fade-in">
        ✅ {{ session('success') }}
      </div>
    @endif

    @if (session('warning'))
      <div class="mb-6 bg-yellow-50 border border-yellow-400 text-yellow-700 p-4 rounded-xl shadow animate-fade-in">
        ⚠️ {{ session('warning') }}
      </div>
    @endif

    <!-- HERO SECTION -->
    <section class="bg-gradient-to-r from-primary to-accent text-white p-8 rounded-3xl shadow-glow mb-10 flex flex-col md:flex-row items-center justify-between relative overflow-hidden animate-slide-up">
      <div class="relative z-10">
        <h2 class="text-3xl font-extrabold mb-3">Temukan Kost Terbaik untuk Kamu</h2>
        <p class="text-white/90 max-w-md">Jelajahi berbagai pilihan kost nyaman dengan fasilitas terbaik dan harga terjangkau.</p>
      </div>

      <form action="{{ route('kost.search') }}" method="GET"
            class="relative z-10 mt-6 md:mt-0 flex items-center bg-white/90 rounded-full overflow-hidden w-full md:w-96 shadow-md backdrop-blur-md hover-glow transition-all duration-300">
        <input type="text" name="search" placeholder="Cari kost di daerahmu..." 
               class="flex-1 px-5 py-3 text-gray-700 focus:outline-none bg-transparent" />
        <button class="bg-primary text-white px-6 py-3 font-semibold hover:bg-purple-800 transition-all duration-300">Cari</button>
      </form>
    </section>

    <!-- REKOMENDASI KOST -->
<section class="mb-14 animate-fade-in">
  <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">Rekomendasi Kost untuk Kamu</h3>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
    @forelse($kosts->take(3) as $index => $kost)
      <div class="bg-white rounded-2xl shadow-lg hover:shadow-glow transition transform overflow-hidden duration-300 opacity-0 animate-slide-up delay-{{ $loop->iteration }}">
        <img src="{{ asset('storage/' . $kost->gambar) }}" alt="{{ $kost->nama }}" class="w-full h-52 object-cover">
        <div class="p-5">
          <h4 class="font-extrabold text-lg text-gray-800 mb-1">{{ $kost->nama }}</h4>
          <p class="text-sm text-gray-500 mb-4 line-clamp-2">{{ $kost->alamat }}</p>

          <div class="flex justify-between items-center">
            <p class="text-primary font-semibold text-sm sm:text-base">
              💰 Rp {{ number_format($kost->harga, 0, ',', '.') }} / bulan
            </p>
            <div class="flex gap-2">
              <a href="{{ route('kost.show', $kost->id) }}" 
                 class="bg-primary text-white px-3 py-1.5 rounded-lg hover:bg-purple-800 text-sm transition">Detail</a>
              <a href="{{ route('chat.show', $kost->pemilik_id) }}" 
                 class="bg-green-500 text-white px-3 py-1.5 rounded-lg hover:bg-green-600 text-sm transition">Chat</a>
            </div>
          </div>
        </div>
      </div>
    @empty
      <p class="text-gray-500 text-center">Belum ada kost tersedia.</p>
    @endforelse
  </div>
</section>

    <!-- STATUS PEMESANAN -->
    <section class="bg-white/90 backdrop-blur-md p-8 rounded-2xl shadow-lg border border-gray-100 animate-slide-up">
      <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">📋 Status Pemesanan</h3>

      @if($pemesanan->isEmpty())
        <p class="text-gray-500 text-center py-10 italic">Belum ada pemesanan kost yang kamu buat.</p>
      @else
        <div class="overflow-x-auto">
          <table class="w-full border-collapse text-sm md:text-base text-center">
            <thead>
              <tr class="bg-primary text-white">
                <th class="p-4 rounded-tl-xl">Nama Kost</th>
                <th class="p-4">Tanggal Pesan</th>
                <th class="p-4">Status</th>
                <th class="p-4 rounded-tr-xl">Aksi</th>
              </tr>
            </thead>

            <tbody>
              @foreach($pemesanan as $pesan)
                <tr class="border-b hover:bg-purple-50 transition-all duration-300">
                  <td class="p-4 font-semibold text-gray-800">{{ $pesan->kost->nama ?? '-' }}</td>
                  <td class="p-4 text-gray-600">{{ $pesan->created_at->format('d F Y') }}</td>
                  <td class="p-4">
                    @php
                      $warna = match($pesan->status) {
                        'menunggu' => 'bg-yellow-100 text-yellow-800',
                        'disewa' => 'bg-green-100 text-green-700',
                        'ditolak' => 'bg-red-100 text-red-700',
                        'selesai' => 'bg-blue-100 text-blue-700',
                        default => 'bg-gray-100 text-gray-600',
                      };
                    @endphp
                    <span class="px-4 py-1.5 rounded-full font-medium text-sm {{ $warna }}">
                      {{ ucfirst($pesan->status) }}
                    </span>
                  </td>
                  <td class="p-4">
                    <div class="flex justify-center items-center gap-3">
                     <a href="{{ route('pemesanan.detail', $pesan->id) }}" 
                        class="text-blue-600 hover:text-blue-800 font-medium text-sm">🔍 Detail</a>

                      @if($pesan->status == 'disewa')
                        <form action="{{ route('pemesanan.selesai', $pesan->id) }}" method="POST" 
                              onsubmit="return confirm('Yakin ingin menyelesaikan sewa kost ini?');">
                          @csrf
                          @method('PUT')
                          <button type="submit" 
                                  class="bg-green-600 text-white px-3 py-1.5 rounded-lg hover:bg-green-700 transition text-sm">
                            ✅ Selesai
                          </button>
                        </form>
                      @elseif($pesan->status == 'selesai')
                        <span class="text-gray-400 italic text-sm">✔️ Selesai</span>
                      @endif
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </section>
  </main>

  <!-- FOOTER -->
  <footer class="text-center py-6 text-gray-500 text-sm border-t mt-10 bg-white/60 backdrop-blur animate-fade-in">
    © 2025 <span class="text-primary font-semibold">GoKost</span> — Semua hak dilindungi.
  </footer>
</body>
</html>

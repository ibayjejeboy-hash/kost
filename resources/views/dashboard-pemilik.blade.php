<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Pemilik Kost | GoKost</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#7C3AED',
            accent: '#A78BFA',
            success: '#10B981',
            danger: '#EF4444',
          }
        }
      }
    }
  </script>
</head>
<body class="bg-gray-50 font-sans min-h-screen flex flex-col">

  <!-- Header -->
<header class="bg-primary text-white px-8 py-4 flex justify-between items-center shadow-md">
    <h1 class="text-2xl font-bold tracking-wide">🏠 GoKost | Pemilik</h1>
    <div class="flex items-center gap-5">

        <!-- Tombol Notifikasi -->
        <div class="relative">
            <button id="notifBtn" class="relative bg-white text-primary px-3 py-2 rounded-full hover:bg-purple-100 transition">
                🔔
                @if(isset($notifikasi) && $notifikasi->where('status','unread')->count() > 0)
                    <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full">
                        {{ $notifikasi->where('status','unread')->count() }}
                    </span>
                @endif
            </button>

            <!-- Dropdown -->
            <div id="notifDropdown" class="hidden absolute right-0 mt-2 w-80 bg-white text-gray-800 rounded-lg shadow-lg overflow-hidden z-50">
                <h3 class="font-bold px-4 py-2 border-b">Notifikasi</h3>
                <ul>
                    @if(isset($notifikasi))
                        @forelse($notifikasi as $notif)
                            <li class="px-4 py-2 border-b hover:bg-purple-50">
                                <a href="{{ route('notifikasi.read', $notif->id) }}" class="flex justify-between items-center">
                                    <span class="@if($notif->status == 'unread') font-bold @endif">
                                        {{ $notif->pesan }}
                                    </span>
                                    <small class="text-gray-400">{{ $notif->created_at->diffForHumans() }}</small>
                                </a>
                            </li>
                        @empty
                            <li class="px-4 py-2 text-gray-500">Belum ada notifikasi.</li>
                        @endforelse
                    @else
                        <li class="px-4 py-2 text-gray-500">Tidak ada data notifikasi.</li>
                    @endif
                </ul>
            </div>
        </div>

        <span class="hidden sm:block text-white/80">Halo, <b>{{ Auth::user()->name }}</b></span>
        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" alt="Avatar" class="w-10 h-10 rounded-full border-2 border-white" />

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="bg-white text-primary px-4 py-2 rounded-md font-semibold hover:bg-gray-100 transition">Logout</button>
        </form>
    </div>
</header>


  <main class="flex-1 p-8 max-w-7xl mx-auto w-full">


    <!-- Section: Statistik -->
    <section class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">
      <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
        <h3 class="text-gray-500">Total Kost</h3>
        <p class="text-3xl font-bold text-primary mt-1">8</p>
      </div>
      <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
  <h3 class="text-gray-500">Kamar Disewa</h3>
  <p class="text-3xl font-bold text-green-600 mt-1">{{ $kamarDisewa ?? 0 }}</p>
  <a href="{{ route('pemilik.sewa-kamar') }}" 
     class="mt-3 inline-block bg-primary text-white px-4 py-2 rounded-md hover:bg-purple-700 transition">
     🔍 Lihat Pemesanan
  </a>
</div>
      <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
  <h3 class="text-gray-500">Pesan Masuk</h3>
  <p class="text-3xl font-bold text-yellow-500 mt-1">{{ $PesanMasuk ?? 0 }}</p>
  <a href="{{ route('chat.index') }}" 
     class="mt-3 inline-block bg-primary text-white px-4 py-2 rounded-md hover:bg-purple-700 transition">
     💬 Lihat Chat
  </a>
</div>
    </section>

    <!-- Section: Kost Saya -->
<section class="mb-10">
  <div class="flex justify-between items-center mb-5">
    <h2 class="text-2xl font-bold text-gray-800">Daftar Kost Saya</h2>
    <a href="{{ route('kost.create') }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-purple-700 transition">+ Tambah Kost</a>
  </div>

  @if($kosts->isEmpty())
    <p class="text-gray-500">Belum ada kost yang ditambahkan.</p>
  @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach ($kosts as $kost)
        <div class="bg-white rounded-xl shadow hover:shadow-2xl transition overflow-hidden">
          <img src="{{ $kost->gambar ? asset('storage/' . $kost->gambar) : asset('images/default.jpg') }}"
               alt="Kost {{ $kost->nama }}" class="w-full h-48 object-cover">

          <div class="p-5">
            <h4 class="font-bold text-lg text-gray-800">{{ $kost->nama }}</h4>
            <p class="text-sm text-gray-500 mb-3">{{ $kost->kota }} | {{ $kost->jumlah_kamar }} kamar</p>
            <p class="text-primary font-semibold mb-3">Rp {{ number_format($kost->harga, 0, ',', '.') }} / bulan</p>

            <div class="flex justify-between">
              <a href="{{ route('kost.show', $kost->id) }}"
                 class="bg-green-500 text-white px-3 py-1.5 rounded-md hover:bg-green-600 transition text-sm">
                 Lihat
              </a>
              <form action="{{ route('kost.destroy', $kost->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kost ini?')">
    @csrf
    @method('DELETE')
    <button type="submit"
        class="bg-red-600 text-white px-3 py-1.5 rounded-md hover:bg-red-700 transition text-sm">
        Hapus
    </button>
</form>

              </div>
          </div>
        </div>
      @endforeach
    </div>
  @endif
</section>

    
  
  </main>

  <footer class="text-center py-6 text-gray-500 text-sm border-t mt-10">
    © 2025 GoKost. Semua hak dilindungi.
  </footer>

</body>
</html>

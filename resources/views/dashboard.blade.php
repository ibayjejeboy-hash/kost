<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Admin | KostKu</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#7C3AED',
            accent: '#A78BFA',
            dark: '#1E1B4B',
          }
        }
      }
    }
  </script>
</head>
<body class="bg-gray-50 min-h-screen flex font-sans">

  <!-- Sidebar -->
  <aside class="w-64 bg-gradient-to-b from-primary to-accent text-white flex flex-col shadow-lg">
    <div class="p-6 border-b border-white/20 text-center">
      <h1 class="text-2xl font-bold tracking-wide">🏠 KostKu Admin</h1>
      <p class="text-sm text-purple-200 mt-1">Panel Kendali Kost</p>
    </div>

    <nav class="flex-1 p-5 space-y-2">
      <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-md bg-white/20 hover:bg-white/30 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 stroke-white" fill="none" viewBox="0 0 24 24" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M4 10v10h16V10" />
        </svg>
        Dashboard
      </a>
      <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-white/20 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 stroke-white" fill="none" viewBox="0 0 24 24" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16" />
        </svg>
        Data Penghuni
      </a>
      <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-white/20 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 stroke-white" fill="none" viewBox="0 0 24 24" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M3 12h18M3 17h18" />
        </svg>
        Data Kamar
      </a>
      <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-white/20 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 stroke-white" fill="none" viewBox="0 0 24 24" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 17l6-6 4 4 6-6" />
        </svg>
        Transaksi
      </a>
    </nav>

    <form action="{{ route('logout') }}" method="POST" class="p-4 border-t border-white/20">
      @csrf
      <button type="submit" class="w-full bg-white text-primary font-semibold py-2 rounded-md hover:bg-gray-100 transition">
        Logout
      </button>
    </form>
  </aside>

  <!-- Main -->
  <main class="flex-1 p-8">
    <!-- Header -->
    <header class="flex justify-between items-center mb-10">
      <div>
        <h2 class="text-3xl font-bold text-gray-800">Selamat datang, {{ Auth::user()->name }} 👋</h2>
        <p class="text-gray-500">Kelola semua data kostmu dari sini</p>
      </div>
      <div class="flex items-center gap-3">
        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" alt="Avatar" class="w-10 h-10 rounded-full border-2 border-purple-500" />
      </div>
    </header>

    <!-- Statistik -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
      <div class="bg-white p-6 rounded-xl shadow-md hover:scale-105 transition transform">
        <div class="flex items-center justify-between">
          <div>
            <h3 class="text-gray-500">Total Penghuni</h3>
            <p class="text-3xl font-bold text-primary mt-1">48</p>
          </div>
          <div class="bg-purple-100 p-3 rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a2 2 0 00-2-2h-3v4zM2 20h5v-4H4a2 2 0 00-2 2v2zM7 9a5 5 0 0110 0v5H7V9z" />
            </svg>
          </div>
        </div>
      </div>

      <div class="bg-white p-6 rounded-xl shadow-md hover:scale-105 transition transform">
        <div class="flex items-center justify-between">
          <div>
            <h3 class="text-gray-500">Kamar Tersedia</h3>
            <p class="text-3xl font-bold text-green-600 mt-1">12</p>
          </div>
          <div class="bg-green-100 p-3 rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M9 21V3M15 21V3" />
            </svg>
          </div>
        </div>
      </div>

      <div class="bg-white p-6 rounded-xl shadow-md hover:scale-105 transition transform">
        <div class="flex items-center justify-between">
          <div>
            <h3 class="text-gray-500">Transaksi Bulan Ini</h3>
            <p class="text-3xl font-bold text-blue-600 mt-1">Rp 8.200.000</p>
          </div>
          <div class="bg-blue-100 p-3 rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
        </div>
      </div>

      <div class="bg-white p-6 rounded-xl shadow-md hover:scale-105 transition transform">
        <div class="flex items-center justify-between">
          <div>
            <h3 class="text-gray-500">Tagihan Belum Lunas</h3>
            <p class="text-3xl font-bold text-red-500 mt-1">5</p>
          </div>
          <div class="bg-red-100 p-3 rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636L5.636 18.364M5.636 5.636l12.728 12.728" />
            </svg>
          </div>
        </div>
      </div>
    </section>

    <!-- Daftar Penghuni -->
    <section class="bg-white rounded-xl shadow-md p-6">
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-semibold text-gray-700">Daftar Penghuni Kost</h3>
        <button class="bg-primary text-white px-4 py-2 rounded-md hover:bg-accent transition">+ Tambah Penghuni</button>
      </div>
      <table class="w-full border-collapse">
        <thead>
          <tr class="bg-purple-100 text-gray-700 text-left">
            <th class="p-3">Nama</th>
            <th class="p-3">Kamar</th>
            <th class="p-3">Status</th>
            <th class="p-3">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr class="border-b hover:bg-gray-50 transition">
            <td class="p-3">Rizky Hidayat</td>
            <td class="p-3">Kamar A1</td>
            <td class="p-3"><span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm">Aktif</span></td>
            <td class="p-3 flex gap-2">
              <button class="text-blue-600 hover:underline">Detail</button>
              <button class="text-red-500 hover:underline">Hapus</button>
            </td>
          </tr>
          <tr class="border-b hover:bg-gray-50 transition">
            <td class="p-3">Nadia Sari</td>
            <td class="p-3">Kamar B3</td>
            <td class="p-3"><span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm">Pending</span></td>
            <td class="p-3 flex gap-2">
              <button class="text-blue-600 hover:underline">Detail</button>
              <button class="text-red-500 hover:underline">Hapus</button>
            </td>
          </tr>
        </tbody>
      </table>
    </section>
  </main>

</body>
</html>

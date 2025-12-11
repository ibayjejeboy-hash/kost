<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>GoKost | Temukan Kost Impianmu</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#6D28D9',
            secondary: '#4C1D95',
            accent: '#A78BFA',
            soft: '#EEF2FF',
          },
        },
      },
    };
  </script>
</head>

<body class="bg-gradient-to-br from-primary via-indigo-700 to-blue-700 text-white font-sans min-h-screen flex flex-col">

  <!-- Navbar -->
  <header class="flex justify-between items-center px-8 md:px-16 py-5 bg-white/10 backdrop-blur-md sticky top-0 z-50 shadow-lg">
    <div class="flex items-center gap-3">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M4 10v10h16V10" />
      </svg>
      <h1 class="text-2xl font-bold">GoKost</h1>
    </div>

    <nav class="hidden md:flex space-x-8 text-white/80 font-medium">
      <a href="#" class="hover:text-accent transition">Beranda</a>
      <a href="#" class="hover:text-accent transition">Cari Kost</a>
      <a href="#" class="hover:text-accent transition">Informasi</a>
      <a href="#" class="hover:text-accent transition">Kontak</a>
    </nav>

    <a href="{{ route('login') }}" class="bg-white text-primary px-5 py-2 rounded-full font-semibold shadow hover:bg-accent hover:text-white transition">
      Login
    </a>
  </header>

  <!-- Hero Section -->
  <section class="relative overflow-hidden">
    <div class="flex flex-col md:flex-row items-center justify-between px-8 md:px-20 py-24 gap-10">
      <div class="max-w-xl space-y-6 animate-fadeIn">
        <h2 class="text-5xl md:text-6xl font-extrabold leading-tight">
          Temukan <span class="text-accent">Kost Impianmu</span> dengan Mudah
        </h2>
        <p class="text-purple-100 text-lg">
          Jelajahi ribuan kost di seluruh Indonesia, lengkap dengan foto, harga, dan fasilitas. Temukan tempat tinggal yang nyaman dan sesuai kebutuhanmu.
        </p>
        <div class="flex flex-col md:flex-row gap-4 pt-4">
          <a href="{{ route('register') }}" class="px-8 py-3 bg-white text-primary font-semibold rounded-full shadow-md hover:bg-accent hover:text-white transition transform hover:scale-105">
            Daftar Sekarang
          </a>
          <a href="#" class="px-8 py-3 border border-white font-semibold rounded-full hover:bg-white hover:text-primary transition transform hover:scale-105">
            Jelajahi Kost
          </a>
        </div>
      </div>

    <!-- Gradient Decoration -->
    <div class="absolute -bottom-20 -right-20 w-80 h-80 bg-accent/20 rounded-full blur-3xl"></div>
  </section>

  <!-- Why Choose Section -->
  <section class="bg-soft text-gray-800 py-20 px-6 md:px-20 text-center">
    <h3 class="text-3xl font-bold text-primary mb-12">Kenapa Memilih GoKost?</h3>
    <div class="grid md:grid-cols-3 gap-10">
      <div class="p-6 bg-white rounded-2xl shadow-lg hover:-translate-y-2 transition transform">
        <div class="text-primary mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M9 21V3m6 18V3" />
          </svg>
        </div>
        <h4 class="font-bold text-xl mb-2">Pencarian Cepat</h4>
        <p class="text-gray-600">Temukan kost dengan filter harga, lokasi, dan fasilitas secara instan.</p>
      </div>

      <div class="p-6 bg-white rounded-2xl shadow-lg hover:-translate-y-2 transition transform">
        <div class="text-primary mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
        <h4 class="font-bold text-xl mb-2">24/7 Akses</h4>
        <p class="text-gray-600">Cari atau pasang iklan kost kapan pun dan di mana pun kamu mau.</p>
      </div>

      <div class="p-6 bg-white rounded-2xl shadow-lg hover:-translate-y-2 transition transform">
        <div class="text-primary mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
        </div>
        <h4 class="font-bold text-xl mb-2">Terpercaya</h4>
        <p class="text-gray-600">Platform dengan ribuan pengguna aktif dan review terpercaya.</p>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-secondary text-white text-center py-6 mt-auto">
    <p>© 2025 <strong>GoKost</strong>. Semua hak dilindungi.</p>
  </footer>

  <!-- Animation -->
  <style>
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeIn { animation: fadeIn 1s ease-out forwards; }
    .delay-200 { animation-delay: 0.2s; }
  </style>

</body>
</html>

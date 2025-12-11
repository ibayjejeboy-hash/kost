<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GoKost | Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#7C3AED',
            accent: '#A78BFA'
          }
        }
      }
    }
  </script>
</head>
<body class="bg-gradient-to-br from-purple-700 via-purple-600 to-purple-400 flex justify-center items-center min-h-screen text-white relative overflow-hidden">

  <!-- Tombol Kembali -->
  <a href="{{ route('landing') }}" class="absolute top-6 left-6 bg-white/90 text-purple-700 px-4 py-2 rounded-md font-semibold hover:bg-white transition">
    ← Kembali
  </a>

  <!-- Background Glow -->
  <div class="absolute w-72 h-72 bg-white/20 rounded-full blur-3xl top-10 left-20"></div>
  <div class="absolute w-80 h-80 bg-purple-300/30 rounded-full blur-3xl bottom-10 right-20"></div>

  <!-- Card Login -->
  <div class="relative z-10 w-full max-w-md bg-white/10 backdrop-blur-md rounded-2xl shadow-2xl p-8 text-center border border-white/20">

    <!-- Notifikasi -->
    @if(session('error'))
      <div class="bg-red-500/90 p-2 rounded mb-4">{{ session('error') }}</div>
    @endif
    @if(session('success'))
      <div class="bg-green-500/90 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif

    <!-- Icon -->
    <div class="mx-auto mb-6 bg-white/20 rounded-full w-20 h-20 flex items-center justify-center">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 stroke-white animate-bounce" fill="none" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c.828 0 1.5-.672 1.5-1.5S12.828 8 12 8s-1.5.672-1.5 1.5S11.172 11 12 11zM12 13.5v4.5" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 12a8 8 0 1116 0 8 8 0 01-16 0z" />
      </svg>
    </div>

    <h2 class="text-3xl font-bold mb-6">Selamat Datang</h2>
    <p class="text-purple-100 mb-6">Masuk untuk melanjutkan ke akun GoKost kamu</p>

    <!-- Form Login -->
    <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
      @csrf
      <input type="email" name="email" placeholder="Email" class="w-full p-3 rounded-md text-gray-900 placeholder-gray-500 focus:ring-2 focus:ring-accent outline-none" required>
      <input type="password" name="password" placeholder="Password" class="w-full p-3 rounded-md text-gray-900 placeholder-gray-500 focus:ring-2 focus:ring-accent outline-none" required>
      <button type="submit" class="w-full bg-primary text-white font-semibold py-3 rounded-md shadow-md hover:bg-accent transition transform hover:scale-105">
        Login
      </button>
    </form>

    <p class="mt-6 text-sm text-purple-100">
      Belum punya akun?
      <a href="{{ route('register') }}" class="text-white underline hover:text-accent transition">Daftar</a>
    </p>
  </div>

</body>
</html>

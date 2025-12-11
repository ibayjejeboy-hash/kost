<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GoKost | Register</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#7C3AED',
            accent: '#A78BFA',
          },
          keyframes: {
            fadeInUp: {
              '0%': { opacity: '0', transform: 'translateY(30px)' },
              '100%': { opacity: '1', transform: 'translateY(0)' }
            },
            floatGlow: {
              '0%, 100%': { transform: 'translateY(0)', opacity: '0.4' },
              '50%': { transform: 'translateY(-15px)', opacity: '0.8' }
            }
          },
          animation: {
            fadeInUp: 'fadeInUp 1s ease-out forwards',
            floatGlow: 'floatGlow 6s ease-in-out infinite',
          }
        }
      }
    }
  </script>
</head>
<body class="bg-gradient-to-br from-purple-700 via-purple-600 to-purple-400 flex justify-center items-center min-h-screen text-white relative overflow-hidden">

  <!-- Tombol Kembali -->
  <a href="{{ route('landing') }}" 
     class="absolute top-6 left-6 bg-white/90 text-purple-700 px-4 py-2 rounded-md font-semibold shadow-md hover:bg-white transition-all duration-300 hover:scale-105 animate-fadeInUp">
    ← Kembali
  </a>

  <!-- Background Glow -->
  <div class="absolute w-72 h-72 bg-white/20 rounded-full blur-3xl top-10 left-20 animate-floatGlow"></div>
  <div class="absolute w-80 h-80 bg-purple-300/30 rounded-full blur-3xl bottom-10 right-20 animate-floatGlow"></div>

  <!-- Card Register -->
  <div class="relative z-10 w-full max-w-md bg-white/10 backdrop-blur-md rounded-2xl shadow-2xl p-8 text-center border border-white/20 animate-fadeInUp">

    <!-- Pesan Error -->
    @if($errors->any())
      <div class="bg-red-500/90 p-2 rounded mb-4 transition-all duration-300 animate-fadeInUp">
        @foreach($errors->all() as $error)
          <p>{{ $error }}</p>
        @endforeach
      </div>
    @endif

    <!-- Icon -->
    <div class="mx-auto mb-2 bg-white/20 rounded-full w-20 h-20 flex items-center justify-center">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 stroke-white animate-bounce" fill="none" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c.828 0 1.5-.672 1.5-1.5S12.828 8 12 8s-1.5.672-1.5 1.5S11.172 11 12 11zM12 13.5v4.5" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 12a8 8 0 1116 0 8 8 0 01-16 0z" />
      </svg>
    </div>

    <!-- Judul -->
    <h2 class="text-3xl font-bold mb-0 animate-fadeInUp">Buat Akun Baru</h2>
    <p class="text-purple-100 mb-2 animate-fadeInUp">Gabung sekarang dan temukan kost impianmu</p>

    <!-- Form Registrasi -->
    <form action="{{ route('register.post') }}" method="POST" class="space-y-3 animate-fadeInUp">
      @csrf
      <input type="text" name="name" placeholder="Nama Lengkap" 
             class="w-full p-3 rounded-md text-gray-900 transition-all duration-300 focus:ring-2 focus:ring-accent focus:scale-[1.02]" required>

      <input type="email" name="email" placeholder="Email" 
             class="w-full p-3 rounded-md text-gray-900 transition-all duration-300 focus:ring-2 focus:ring-accent focus:scale-[1.02]" required>

      <input type="password" name="password" placeholder="Password" 
             class="w-full p-3 rounded-md text-gray-900 transition-all duration-300 focus:ring-2 focus:ring-accent focus:scale-[1.02]" required>

      <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" 
             class="w-full p-3 rounded-md text-gray-900 transition-all duration-300 focus:ring-2 focus:ring-accent focus:scale-[1.02]" required>

      <!-- Tambah pilihan role -->
      <select name="role" 
              class="w-full p-3 rounded-md text-gray-900 transition-all duration-300 focus:ring-2 focus:ring-accent focus:scale-[1.02]" required>
        <option value="" disabled selected>Pilih Role</option>
        <option value="user">Pencari Kost</option>
        <option value="pemilik">Pemilik Kost</option>
        <option value="admin">Admin</option>
      </select>

      <button type="submit" 
              class="w-full bg-primary text-white font-semibold py-3 rounded-md shadow-md transition-all duration-300 hover:bg-accent hover:scale-105 hover:shadow-lg">
        Daftar
      </button>
    </form>

    <p class="mt-4 text-sm text-purple-100 animate-fadeInUp">
      Sudah punya akun?
      <a href="{{ route('login') }}" class="text-white underline hover:text-accent transition-all duration-300">Login</a>
    </p>
  </div>

</body>
</html>

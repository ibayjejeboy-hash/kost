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
      <a href class="flex items-center gap-3 px-4 py-2 rounded-md bg-white/20 hover:bg-white/30 transition">
        📦 Data Kost Terdaftar
      </a>
      <a href="{{ route('admin.testimoni') }}" 
      class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-white/20 transition">Testimoni Penghuni</a>
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

    <header class="flex justify-between items-center mb-10">
       <h2 class="text-3xl font-bold text-gray-800">Selamat datang, {{ Auth::user()->name }} 👋</h2>
      </div>
      <div class="flex items-center gap-3">
        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" alt="Avatar" class="w-10 h-10 rounded-full border-2 border-purple-500" />
      </div>
    </header>

    <!-- DATA KOST -->
    <section class="bg-white rounded-xl shadow-md p-6 mb-10">
  <div class="flex justify-between items-center mb-4">
    <h3 class="text-xl font-semibold text-gray-700">Data Kost Terdaftar</h3>
  </div>

  <table class="w-full border-collapse">
    <thead>
      <tr class="bg-purple-100 text-gray-700 text-left">
        <th class="p-3">Nama Kost</th>
        <th class="p-3">Alamat</th>
        <th class="p-3">Foto</th>
        <th class="p-3">Aksi</th>
      </tr>
    </thead>

    <tbody>
      @forelse ($kosts as $kost)
      <tr class="border-b hover:bg-gray-50 transition">
        <td class="p-3 font-semibold text-gray-800">{{ $kost->nama }}</td>
        <td class="p-3 text-gray-600">{{ $kost->alamat }}</td>

        <td class="p-3">
          <img src="{{ asset('storage/' . $kost->gambar) }}" class="w-16 h-16 object-cover rounded-md shadow">
        </td>

        <td class="p-3 flex gap-2">
          <a href="{{ route('kost.show', $kost->id) }}"
            class="text-blue-600 hover:text-blue-800 font-medium">Detail</a>

          <form action="{{ route('kost.destroy', $kost->id) }}" method="POST"
                onsubmit="return confirm('Yakin ingin menghapus kost ini?')">
            @csrf @method('DELETE')
            <button class="text-red-600 hover:text-red-800 font-medium">
              Hapus
            </button>
          </form>
        </td>
      </tr>

      @empty
      <tr>
        <td colspan="4" class="p-4 text-center text-gray-500">
          Belum ada kost yang terdaftar.
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>
</section>
  </main>

</body>
</html>

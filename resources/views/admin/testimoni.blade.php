<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Testimoni Penghuni | GoKost</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 font-sans min-h-screen flex flex-col">

  <!-- Header -->
  <header class="bg-purple-600 text-white px-8 py-4 flex justify-between items-center shadow-md">
    <h1 class="text-2xl font-bold">GoKost Admin</h1>

    <a href="{{ route('dashboard.admin') }}"
      class="bg-white text-purple-600 px-4 py-2 rounded-lg hover:bg-purple-100 transition">
      ← Kembali
    </a>
  </header>

  <!-- Content -->
  <main class="flex-1 p-8 max-w-6xl mx-auto w-full">
    <h2 class="text-3xl font-bold text-gray-800 mb-6 flex items-center gap-2">
      ⭐ Testimoni Penghuni
    </h2>

    <!-- LIST TESTIMONI -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

      @forelse($testimoni as $t)
      <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-200 transition hover:shadow-lg hover:-translate-y-1">

        <!-- Profile -->
        <div class="flex items-center gap-4 mb-4">
          <img src="https://ui-avatars.com/api/?name={{ $t->user->name }}"
            class="w-14 h-14 rounded-full border-2 border-purple-500 shadow">
          <div>
            <h3 class="font-bold text-gray-900 text-lg">{{ $t->user->name }}</h3>
            <p class="text-gray-600 text-sm">
              Penghuni Kost: <span class="font-semibold text-purple-600">{{ $t->kost->nama }}</span>
            </p>
          </div>
        </div>

        <!-- Rating -->
        <div class="flex mb-3">
          @for($i=1; $i<=5; $i++)
            <span class="{{ $i <= $t->rating ? 'text-yellow-400' : 'text-gray-300' }} text-xl">★</span>
          @endfor
        </div>

        <!-- Message -->
        <p class="text-gray-800 mb-4">“{{ $t->pesan }}”</p>

        <!-- Footer -->
        <div class="flex justify-between items-center">
          <span class="bg-purple-200 text-purple-800 text-xs font-bold px-3 py-1 rounded-full">
            {{ $t->created_at->format('d M Y') }}
          </span>

          <form action="{{ route('testimoni.destroy', $t->id) }}" method="POST"
            onsubmit="return confirm('Yakin ingin menghapus testimoni ini?')">
            @csrf @method('DELETE')
            <button title="Hapus" class="text-red-600 hover:text-red-800 text-xl hover:scale-125 transition">🗑️</button>
          </form>
        </div>
      </div>

      @empty
      <p class="col-span-3 text-center text-gray-500 font-medium">
        Belum ada testimoni penghuni.
      </p>
      @endforelse

    </section>
  </main>

  <!-- Footer -->
  <footer class="text-center py-4 text-gray-500 text-sm border-t mt-6">
    © 2025 GoKost. Semua hak dilindungi.
  </footer>

</body>
</html>

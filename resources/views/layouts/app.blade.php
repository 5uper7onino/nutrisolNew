<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Nutrisol</title>
  @vite(['resources/js/app.js'])

  <style>
    html {
      background-image: url("{{ asset('img/pexels-badulescu.webp') }}");
      background-size: cover;
    }
    .fade-in {
      opacity: 0;
      transition: opacity 0.4s ease-in;
    }
    .fade-in.show {
      opacity: 1;
    }
    ::-webkit-scrollbar-thumb {
      background: rgba(255, 255, 255, 0.25);
      backdrop-filter: blur(6px);
      border-radius: 20px;
    }
  </style>
  <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body x-data="{ mobileMenuOpen: false }" class="font-sans antialiased overflow-x-hidden flex min-h-screen">

  <!-- Sidebar lateral fijo -->
  <aside class="hidden lg:flex flex-col w-64 bg-white/50 dark:bg-gray-900/50 backdrop-blur-lg shadow-lg border-r border-gray-200 dark:border-gray-700 fixed inset-y-0 left-0 z-40">
    <div class="flex flex-col items-center py-1 space-y-4">
      <x-logo-nutrisol size="80" />
      <div class="flex flex-col items-center py-1 space-y-4">
        @php
            $user = Auth::user();
            $photo = $user && $user->profile_photo_path
                ? asset($user->profile_photo_path)
                : asset('img/default-user.png');
        @endphp

        <!-- Imagen del usuario o avatar por defecto -->
        <img src="{{ $photo }}"
             alt="Foto de perfil"
             class="w-48 h-64 rounded-full object-cover shadow-md border border-white/40 dark:border-gray-700">
      </div>
    </div>

    <nav class="flex-1 mt-6 space-y-2 px-4 text-gray-700 dark:text-gray-50">
            <!-- Dropdown usuario -->
            <div x-data="{ open: false }" class="relative">
              <button @click="open = !open" class="w-full flex text-xl items-center font-bold justify-center px-4 py-2 rounded hover:bg-gray-200/20 dark:hover:bg-gray-800">

                <span class="text-gray-700 dark:text-gray-50 uppercase"><span class="text-3xl">👤</span> {{ Auth::user()->name ?? 'Usuario' }}</span>

              </button>

              <div x-show="open" @click.away="open = false" x-transition
                   class="absolute left-0 mt-2 w-full bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-lg shadow-lg z-50">
                <a href="{{ route('profile.show') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">Perfil</a>
                <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">Configuración</a>
                <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">Modo Oscuro</a>
                <hr class="border-gray-200 dark:border-gray-700" />
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                    Cerrar sesión
                  </button>
                </form>
              </div>
            </div>
      <hr class="border-gray-300 border-4 dark:border-gray-600 my-3" />
      <a href="#" class="menu-link block px-4 py-2 rounded hover:bg-gray-200/20 text-2xl dark:hover:bg-gray-800" data-url="{{ route('home') }}" id="home"><span class="text-3xl">🏠</span> Home</a>
      <a href="#" class="menu-link block px-4 py-2 rounded hover:bg-gray-200/20 text-2xl dark:hover:bg-gray-800" data-url="{{ route('pacientes.index') }}"><span class="text-3xl">🧑‍⚕️</span> Pacientes</a>
      @auth
        @if (Auth::user()->is_admin)
          <a href="#" class="menu-link block px-4 py-2 rounded hover:bg-gray-200/20 text-2xl dark:hover:bg-gray-800" data-url="{{ route('usuarios') }}"><span class="text-3xl">👥</span> Usuarios</a>
        @endif
      @endauth
      <a href="#" class="hidden menu-link block px-4 py-2 rounded hover:bg-gray-200/20 text-2xl dark:hover:bg-gray-800" data-url="{{ route('menus') }}"><span class="text-3xl">📋</span> Menús</a>
      <a href="#" class="hidden menu-link block px-4 py-2 rounded hover:bg-gray-200/20 text-2xl dark:hover:bg-gray-800" data-url="{{ route('productos') }}"><span class="text-3xl">🍅</span> Productos</a>
      <a href="#" class=" menu-link block px-4 py-2 rounded hover:bg-gray-200/20 text-2xl dark:hover:bg-gray-800" data-url="{{ route('citas.index') }}"><span class="text-3xl">📆</span> Citas</a>

      <hr class="border-gray-300 border-4 dark:border-gray-600 my-3" />

    </nav>
  </aside>

  <!-- Contenido principal -->
  <div class="w-full lg:ml-64 flex flex-col overflow-hidden">

    <!-- Header móvil -->
    <header class="bg-white/70 backdrop-blur-md shadow sticky top-0 z-30 lg:hidden flex justify-between items-center px-4 py-4">
      <div class="flex items-center space-x-3">
        <x-logo-nutrisol size="64" />
      </div>
      <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-2xl">☰</button>
    </header>

    <!-- Menú móvil -->
    <nav x-show="mobileMenuOpen" x-transition
      class="absolute right-4 top-16 w-48 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-lg py-3 space-y-2 z-40 lg:hidden">
      <a href="#" @click="mobileMenuOpen = false"
          class="menu-link block px-4 py-2 text-gray-800 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700"
          data-url="{{ route('home') }}">
          🏠 Home
      </a>

      <a href="#" @click="mobileMenuOpen = false"
          class="menu-link block px-4 py-2 text-gray-800 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700"
          data-url="{{ route('pacientes.index') }}">
          🧑‍⚕️ Pacientes
      </a>
      @auth
        @if (Auth::user()->is_admin)
          <a href="#" @click="mobileMenuOpen = false"
              class="menu-link block px-4 py-2 text-gray-800 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700"
              data-url="{{ route('usuarios') }}">
            👥 Usuarios
          </a>
        @endif
      @endauth

    </nav>

    <!-- Main dinámico -->
    <main id="main-content" class="flex-1 p-0 lg:p-6 rounded-2xl backdrop-blur-md fade-in show">

    </main>

    <!-- Footer -->
    <footer class="bg-gray-100 py-4 text-center text-gray-600">
      © {{ date('Y') }} Desarrollo de Sistemas - DIF Jalisco
    </footer>
  </div>

  @include('components.modalMenus',['id'=>'miformu'])

  <script>
    // Escuchar eventos personalizados
    window.addEventListener('reload-usuarios', async () => {
      const main = document.getElementById('main-content');
      try {
        const response = await fetch('/usuarios', { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
        if (!response.ok) throw new Error('Error al obtener la lista.');
        const html = await response.text();
        main.innerHTML = html;
        if (typeof initUsuarios === 'function') initUsuarios();
        void main.offsetWidth;
        main.classList.add('show');
      } catch (error) {
        main.innerHTML = `<div class="p-6 text-center text-red-600"><h2 class="text-xl font-semibold">Error al recargar usuarios</h2><p class="text-sm">${error.message}</p></div>`;
      }
    });

    window.addEventListener('reload-productos', async () => {
      const main = document.getElementById('main-content');
      try {
        const response = await fetch('/productos', { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
        if (!response.ok) throw new Error('Error al obtener la lista.');
        const html = await response.text();
        main.innerHTML = html;
        if (typeof initProductos === 'function') initProductos();
        void main.offsetWidth;
        main.classList.add('show');
      } catch (error) {
        main.innerHTML = `<div class="p-6 text-center text-red-600"><h2 class="text-xl font-semibold">Error al recargar productos</h2><p class="text-sm">${error.message}</p></div>`;
      }
    });
  </script>
</body>
</html>

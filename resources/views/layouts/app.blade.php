<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Mis Menús</title>
    @vite(['resources/css/app.css','resources/js/app.js']) <!-- Tailwind -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<style>
.fade-in {
  opacity: 0;
  transition: opacity 0.4s ease-in;
}

.fade-in.show {
  opacity: 1;
}
html{
    background-image: url("{{asset('img/salad-1672505.webp')}}");
    background-size: cover
}

::-webkit-scrollbar-thumb {
  background: rgba(255, 255, 255, 0.25);
  backdrop-filter: blur(6px);
  border-radius: 20px;
}

.my-scroll::-webkit-scrollbar-thumb { ... }


</style>


</head>
<body x-data="{ mobileMenuOpen: false }" class="font-sans antialiased overflow-x-visible">

<!-- Header / Menú -->
<header class="bg-white/30 backdrop-blur-xl shadow sticky top-0 z-50">
    <div class="container mx-auto px-4 flex justify-between items-center py-6">
        <div class="flex justify-around  w-1/2">
                <x-logo-dif-gobierno size="96" />
                <h1 class="text-4xl">SAMI </h1>
                <span class="ml-4 pl-2 border border-8 border-t-0 border-b-0 border-r-0 border-l-red-400">Sistema de Administración de Menús e Insumos</span>
        </div>
        <div class="lg:hidden">
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-2xl">☰</button>
        </div>

        <!-- Menú escritorio -->
        <nav class="hidden lg:flex items-center space-x-6">
            <!-- Home usa route('home') -->
            <a href="#" class="menu-link text-xl text-gray-600 hover:text-primary" data-url="{{ route('home') }}">Home</a>
            <!-- Los demás por ahora son placeholders -->
            <a href="#" class="menu-link text-xl text-gray-600 hover:text-primary" data-url="{{ route('menus') }}">Menús</a>
            <a href="#" class="menu-link text-xl text-gray-600 hover:text-primary" data-url="{{ route('productos') }}">Productos</a>
            @auth
                @if (Auth::user()->is_admin)
                    <a href="#" class="menu-link text-xl text-gray-600 hover:text-primary" data-url="{{ route('usuarios') }}"><i data-lucide="user"></i>Usuarios</a>
                @endif
            @endauth

            <!-- Dropdown usuario -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-1 text-gray-600 hover:text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M5.121 17.804A9 9 0 1112 21a9 9 0 01-6.879-3.196z"/>
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span class="text-2xl text-orange-400 font-semibold">{{ Auth::user()->name ?? 'Usuario' }}</span>
                </button>

                <div x-show="open" @click.away="open = false" x-transition
                     class="absolute right-0 mt-2 w-48 bg-white border rounded shadow-lg z-50">
                    @if (Route::has('profile.show'))
                        <a href="{{ route('profile.show') }}" class="block px-4 py-2 hover:bg-gray-100">Perfil</a>
                    @else
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Perfil</a>
                    @endif

                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Configuración</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Notificaciones</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Modo Oscuro</a>
                    <div class="border-t my-1"></div>

                    @if (Route::has('logout'))
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-gray-100 text-red-600">
                                Cerrar sesión
                            </button>
                        </form>
                    @else
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 text-red-600">Cerrar sesión</a>
                    @endif
                </div>
            </div>
        </nav>
    </div>

    <!-- Menú móvil overlay -->
    <nav
        x-show="mobileMenuOpen"
        x-transition
        class="fixed inset-0 bg-white bg-opacity-95 z-40 flex flex-col items-center justify-center space-y-6 lg:hidden "
    >
        <button @click="mobileMenuOpen = false" class="absolute top-6 right-6 text-2xl">✕</button>
        <a href="#" class="menu-link text-xl text-gray-800 hover:text-primary" data-url="{{ route('home') }}">Home</a>
        <a href="#" class="menu-link text-xl text-gray-800 hover:text-primary" data-url="{{ route('menus') }}">Menús</a>
        <a href="#" class="menu-link text-xl text-gray-800 hover:text-primary" data-url="{{ route('productos') }}">Productos</a>
        @auth
            @if (Auth::user()->is_admin)
                <a href="#" class="menu-link text-xl text-gray-800 hover:text-primary" data-url="{{ route('usuarios') }}">Usuarios</a>
            @endif
        @endauth
    </nav>
</header>

<!-- Main dinámico -->
<main id="main-content" class="pt-8 pb-8 mt-8 rounded-2xl container mx-auto px-4 backdrop-blur-md fade-in show">
    <h1 class="text-3xl font-semibold text-center text-gray-700">Bienvenido a Mis Menús</h1>
    <p class="text-center text-gray-500 mt-2">
        Haz clic en <strong>Home</strong> o en otro módulo para cargar contenido.
    </p>
</main>


<!-- Footer sticky -->
<footer class="bg-gray-100 py-4 fixed bottom-0 w-full z-50">
    <div class="container mx-auto px-4 text-center text-gray-600">
        © {{ date('Y') }} Desarrollo de Sistemas - DIF Jalisco
    </div>
</footer>
@include('components.modalMenus',['id'=>'miformu'])
    <script>
        document.addEventListener("click", async function (e) {
            // Botón "Nuevo Usuario"
            if (e.target.matches(".btn-nuevo") || e.target.closest(".btn-nuevo")) {
                e.preventDefault();

                const modal = document.querySelector('[x-data]');
                modal.__x.$data.title = "Nuevo Usuario";
                modal.__x.$data.content = `<p class='text-gray-600'>Aquí va el formulario de nuevo usuario.</p>`;
                modal.__x.$data.open = true;
            }

            // Botón "Editar Usuario"
            if (e.target.matches(".btn-editar") || e.target.closest(".btn-editar")) {
                e.preventDefault();

                const userId = e.target.dataset.id || e.target.closest(".btn-editar")?.dataset.id;

                // Si quieres cargar el formulario de edición por AJAX:
                const response = await fetch(`/usuarios/${userId}/edit`);
                const html = await response.text();

                const modal = document.querySelector('[x-data]');
                modal.__x.$data.title = "Editar Usuario";
                modal.__x.$data.content = html;
                modal.__x.$data.open = true;
            }
        });
        // Escuchar el evento global para recargar la tabla de usuarios
window.addEventListener('reload-usuarios', async () => {
    const main = document.getElementById('main-content');

    try {
        // Puedes ajustar esta ruta si tu lista de usuarios se carga con otra URL
        const response = await fetch('/usuarios', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });

        if (!response.ok) throw new Error('Error al obtener la lista.');

        const html = await response.text();

        // Reemplaza el contenido actual del main con la nueva lista
        main.innerHTML = html;

        // Si tienes una función para inicializar scripts en usuarios, la llamas aquí
        if (typeof initUsuarios === 'function') initUsuarios();

        // Animación suave
        void main.offsetWidth;
        main.classList.add('show');

    } catch (error) {
        main.innerHTML = `
            <div class="p-6 text-center text-red-600">
                <h2 class="text-xl font-semibold">Error al recargar usuarios</h2>
                <p class="text-sm">${error.message}</p>
            </div>
        `;
    }
});
window.addEventListener('reload-productos', async () => {
    const main = document.getElementById('main-content');

    try {
        // Puedes ajustar esta ruta si tu lista de usuarios se carga con otra URL
        const response = await fetch('/productos', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });

        if (!response.ok) throw new Error('Error al obtener la lista.');

        const html = await response.text();

        // Reemplaza el contenido actual del main con la nueva lista
        main.innerHTML = html;

        // Si tienes una función para inicializar scripts en usuarios, la llamas aquí
        if (typeof initProductos === 'function') initProductos();

        // Animación suave
        void main.offsetWidth;
        main.classList.add('show');

    } catch (error) {
        main.innerHTML = `
            <div class="p-6 text-center text-red-600">
                <h2 class="text-xl font-semibold">Error al recargar usuarios</h2>
                <p class="text-sm">${error.message}</p>
            </div>
        `;
    }
});
        </script>



</body>
</html>

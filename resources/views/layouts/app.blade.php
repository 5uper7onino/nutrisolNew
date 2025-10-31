<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Menús</title>
    @vite('resources/css/app.css') <!-- Tailwind -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.directive('smooth-scroll', (el) => {
                el.addEventListener('click', function(e) {
                    const href = el.getAttribute('href')
                    if (href && href.startsWith('#')) {
                        e.preventDefault();
                        const target = document.querySelector(href)
                        if (target) {
                            target.scrollIntoView({ behavior: 'smooth', block: 'start' })
                        }
                    }
                })
            })
        })
    </script>
</head>
<body x-data="{ mobileMenuOpen: false }" class="font-sans antialiased">

<!-- Header / Menú -->
<header class="bg-white shadow sticky top-0 z-50">
    <div class="container mx-auto px-4 flex justify-between items-center py-6">
        <div>
            <a href="#" class="text-xl font-bold text-primary">Mis Menús</a>
        </div>
        <!-- Botón menú hamburguesa móvil -->
        <div class="lg:hidden">
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-2xl">☰</button>
        </div>
        <!-- Menú escritorio -->
        <nav class="hidden lg:flex items-center space-x-6">
            <a href="#home" x-smooth-scroll class="text-gray-600 hover:text-primary">Home</a>
            <a href="#about" x-smooth-scroll class="text-gray-600 hover:text-primary">About</a>
            <a href="#menu" x-smooth-scroll class="text-gray-600 hover:text-primary">Menu</a>
            <a href="#contact" x-smooth-scroll class="text-gray-600 hover:text-primary">Contact</a>
            <a href="#users" x-smooth-scroll class="text-gray-600 hover:text-primary">Users</a>

            <!-- Dropdown usuario -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-2 text-gray-600 hover:text-primary">
                    <!-- Icono usuario -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M5.121 17.804A9 9 0 1112 21a9 9 0 01-6.879-3.196z"/>
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>Usuario</span>
                </button>
                <div x-show="open" @click.away="open = false" x-transition
                     class="absolute right-0 mt-2 w-48 bg-white border rounded shadow-lg z-50">
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Perfil</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Configuración</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Notificaciones</a>
                    <div class="border-t my-1"></div>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100 text-red-600">Cerrar sesión</a>
                </div>
            </div>
        </nav>
    </div>

    <!-- Menú móvil overlay -->
    <nav
        x-show="mobileMenuOpen"
        x-transition
        class="fixed inset-0 bg-white bg-opacity-95 z-40 flex flex-col items-center justify-center space-y-6 lg:hidden"
    >
        <button @click="mobileMenuOpen = false" class="absolute top-6 right-6 text-2xl">✕</button>
        <a href="#home" x-smooth-scroll @click="mobileMenuOpen = false" class="text-xl text-gray-800 hover:text-primary">Home</a>
        <a href="#about" x-smooth-scroll @click="mobileMenuOpen = false" class="text-xl text-gray-800 hover:text-primary">About</a>
        <a href="#menu" x-smooth-scroll @click="mobileMenuOpen = false" class="text-xl text-gray-800 hover:text-primary">Menu</a>
        <a href="#contact" x-smooth-scroll @click="mobileMenuOpen = false" class="text-xl text-gray-800 hover:text-primary">Contact</a>
        <a href="#users" x-smooth-scroll @click="mobileMenuOpen = false" class="text-xl text-gray-800 hover:text-primary">Users</a>

        <!-- Dropdown usuario en móvil -->
        <div x-data="{ open: false }" class="w-full text-center mt-4">
            <button @click="open = !open" class="flex items-center justify-center space-x-2 text-gray-800 hover:text-primary w-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M5.121 17.804A9 9 0 1112 21a9 9 0 01-6.879-3.196z"/>
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span>Usuario</span>
                <svg xmlns="http://www.w3.org/2000/svg" :class="open ? 'rotate-180' : ''"
                     class="h-4 w-4 ml-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="open" x-transition class="mt-2 space-y-1">
                <a href="#" class="block px-4 py-2 hover:bg-gray-100">Perfil</a>
                <a href="#" class="block px-4 py-2 hover:bg-gray-100">Configuración</a>
                <a href="#" class="block px-4 py-2 hover:bg-gray-100">Notificaciones</a>
                <div class="border-t my-1"></div>
                <a href="#" class="block px-4 py-2 hover:bg-gray-100 text-red-600">Cerrar sesión</a>
            </div>
        </div>
    </nav>
</header>

<!-- Main content -->
<main class="pt-8 pb-24">

    <section id="home"
             class="h-screen bg-background flex items-center justify-center transition-all duration-700"
             x-data="{ visible: true }"
             x-intersect:enter="visible = true"
             x-bind:class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
        <h1 class="text-4xl font-bold text-gray-800">Sección Home</h1>
    </section>

    <section id="about"
             class="h-screen bg-gray-50 flex items-center justify-center transition-all duration-700"
             x-data="{ visible: true }"
             x-intersect:enter="visible = true"
             x-bind:class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
        <h1 class="text-4xl font-bold text-gray-800">Sección About</h1>
    </section>

    <section id="menu"
             class="h-screen bg-background flex items-center justify-center transition-all duration-700"
             x-data="{ visible: true }"
             x-intersect:enter="visible = true"
             x-bind:class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
        <h1 class="text-4xl font-bold text-gray-800">Sección Menu</h1>
    </section>

    <section id="contact"
             class="h-screen bg-gray-50 flex items-center justify-center transition-all duration-700"
             x-data="{ visible: true }"
             x-intersect:enter="visible = true"
             x-bind:class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
        <h1 class="text-4xl font-bold text-gray-800">Sección Contact</h1>
    </section>

    <section id="users"
             class="h-screen bg-gray-50 flex items-center justify-center transition-all duration-700"
             x-data="{ visible: true }"
             x-intersect:enter="visible = true"
             x-bind:class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
        <h1 class="text-4xl font-bold text-gray-800">Sección Usuarios</h1>
    </section>

</main>

<!-- Footer sticky -->
<footer class="bg-gray-100 py-4 fixed bottom-0 w-full z-50">
    <div class="container mx-auto px-4 text-center text-gray-600">
        © {{ date('Y') }} Mis Menús
    </div>
</footer>

</body>
</html>

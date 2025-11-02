<div class="min-h-[60vh] flex flex-col items-center justify-center">
    <h1 class="text-4xl font-bold text-gray-800 mb-2">🏠 Sección Home</h1>

    <p class="text-gray-600 mt-2">mensaje</p>

    <p class="text-gray-500 text-sm mt-1">
        Última actualización: <span class="font-mono">fecha</span>
    </p>
    @forEach ($usuarios as $usuario)
        <div class="bg-white shadow-md rounded-lg p-4 mb-4 w-full max-w-md">
            <h2 class="text-2xl font-semibold text-gray-800 mb-2">{{ $usuario->nombre }}</h2>
            <p class="text-gray-600">Email: {{ $usuario->email }}</p>
            <p class="text-gray-600">Registrado el: {{ $usuario->created_at->format('d/m/Y') }}</p>
        </div>
    @endforeach
</div>

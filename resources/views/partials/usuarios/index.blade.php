<div class="bg-transparent shadow-md rounded-lg p-0 lg:p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-4xl font-semibold text-gray-700 dark:text-gray-100">Usuarios</h2>
        <button
            class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600"
            onclick="window.dispatchEvent(new CustomEvent('open-modal', {
                detail: {
                    title: 'Nuevo Usuario',
                    url: '{{ route('usuarios.create') }}',
                }
            }))"
        >
            + Nuevo Usuario
        </button>
    </div>

    <!-- 🖥️ Vista de TABLA (solo en pantallas grandes) -->
    <div class="rounded-xl overflow-auto hidden md:block">
        <table class="min-w-full bg-white/30 backdrop-blur-sm text-gray-900 rounded-xl select-none">
            <thead>
                <tr class="backdrop-blur-xl text-gray-900 uppercase text-sm leading-normal select-none">
                    <th class="py-3 px-6 text-gray-700 dark:text-gray-50 text-center text-lg">ID</th>
                    <th class="py-3 px-6 text-gray-700 dark:text-gray-50 text-center text-lg">Nombre</th>
                    <th class="py-3 px-6 text-gray-700 dark:text-gray-50 text-center text-lg">Email</th>
                    <th class="py-3 px-6 text-gray-700 dark:text-gray-50 text-center text-lg">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $usuario)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-1 px-3">{{ $usuario->id }}</td>
                        <td class="py-1 px-3">{{ $usuario->name }}</td>
                        <td class="py-1 px-3">{{ $usuario->email }}</td>
                        <td class="py-1 px-3 text-center">
                            <button
                                class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600"
                                onclick="window.dispatchEvent(new CustomEvent('open-modal', {
                                    detail: {
                                        title: 'Editar Usuario',
                                        url: '{{ route('usuarios.edit', $usuario->id) }}'
                                    }
                                }))"
                            >Editar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- 📱 Vista en CARDS (solo en móvil) -->
    <div class="md:hidden space-y-4 p-1">
        @foreach ($usuarios as $usuario)
            <div class="bg-white/30 backdrop-blur-lg rounded-xl p-4 shadow border border-white/20">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-700">ID:</p>
                        <p class="text-xl font-semibold">{{ $usuario->id }}</p>

                        <p class="text-sm text-gray-700 mt-2">Nombre:</p>
                        <p class="text-lg">{{ $usuario->name }}</p>

                        <p class="text-sm text-gray-700 mt-2">Email:</p>
                        <p class="text-md">{{ $usuario->email }}</p>
                    </div>

                    <button
                        class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600"
                        onclick="window.dispatchEvent(new CustomEvent('open-modal', {
                            detail: {
                                title: 'Editar Usuario',
                                url: '{{ route('usuarios.edit', $usuario->id) }}'
                            }
                        }))"
                    >
                        Editar
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $usuarios->links() }}
    </div>
</div>

<div class="bg-transparent shadow-md rounded-lg p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-4xl font-semibold text-gray-100">Usuarios</h2>
        <button
        class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600"
        onclick="window.dispatchEvent(new CustomEvent('open-modal', {
            detail: {
                title: 'Nuevo Usuario',
                url: '{{ route('usuarios.create') }}'
            }
        }))"
    >
        + Nuevo Usuario
    </button>
    </div>
    <div class="rounded-xl overflow-auto">
    <table class="min-w-full bg-white/30 backdrop-blur-sm text-gray-900 rounded-xl select-none">
        <thead>
            <tr class="backdrop-blur-xl text-gray-900 uppercase text-sm leading-normal select-none">
                <th class="py-3 px-6 text-gray-50 text-center text-lg">ID</th>
                <th class="py-3 px-6 text-gray-50 text-center text-lg">Nombre</th>
                <th class="py-3 px-6 text-gray-50 text-center text-lg">Email</th>
                <th class="py-3 px-6 text-gray-50 text-center text-lg">Acciones</th>
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
                    >
                        Editar
                    </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>


    <div class="mt-4">
        {{ $usuarios->links() }}
    </div>
</div>
<script>
    document.addEventListener('reload-usuarios', () => {
        const tableContainer = document.querySelector('#main-content');

        fetch('{{ route('usuarios') }}', { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(res => res.text())
            .then(html => {
                // Reemplazar contenido dentro de #main-content
                tableContainer.innerHTML = html;
                // Efecto fade-in
                tableContainer.style.opacity = 0;
                setTimeout(() => tableContainer.style.transition = 'opacity 0.4s', 10);
                setTimeout(() => tableContainer.style.opacity = 1, 20);
            })
            .catch(err => console.error('Error recargando usuarios:', err));
    });
    </script>


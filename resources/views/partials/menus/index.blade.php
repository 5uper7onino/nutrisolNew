<div class="bg-transparent shadow-md rounded-lg p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-4xl font-semibold text-gray-100">Menús</h2>
        <button
        class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 font-bold"
        onclick="window.dispatchEvent(new CustomEvent('open-modal', {
            detail: {
                title: 'Nuevo Menú',
                url: '{{ route('menus.create') }}',
                //maxWidth: 'max-w-7xl'
            }
        }))"
    >
        + Nuevo Menú
    </button>
    </div>
    <div class="overflow-auto rounded-xl">
        <table class="min-w-full bg-white/30 backdrop-blur-sm text-gray-900 rounded-xl select-none">
            <thead>
                <tr class="backdrop-blur-xl text-gray-900 uppercase text-sm leading-normal select-none">
                    <th class="py-3 px-6 text-gray-50 text-center text-lg">ID</th>
                    <th class="py-3 px-6 text-gray-50 text-center text-lg">Nombre</th>
                    <th class="py-3 px-6 text-gray-50 text-center text-lg">Descripción</th>
                    <th class="py-3 px-6 text-gray-50 text-center text-lg">Comensáles</th>
                    <th class="py-3 px-6 text-gray-50 text-center text-lg">Tipo</th>
                    <th class="py-3 px-6 text-gray-50 text-center text-lg">Temporada</th>
                    <th class="py-3 px-6 text-gray-50 text-center text-lg">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($menus as $menu)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-1 font-bold px-3">{{ $menu->id }}</td>
                        <td class="py-1 font-bold px-3">{{ $menu->nombre }}</td>
                        <td class="py-1 font-bold px-3 text-center">{{ $menu->descripcion }}</td>
                        <td class="py-1 font-bold px-3 text-center">{{ $menu->comensales }}</td>
                        <td class="py-1 font-bold px-3 text-center">{{ $menu->tipo->nombre }}</td>
                        <td class="py-1 font-bold px-3 text-center">{{ $menu->temporada->nombre }}</td>
                        <td class="py-1 font-bold px-3 text-center">
                            <button
                            class="bg-yellow-500/40 text-white px-3 py-1 rounded hover:bg-yellow-500 backdrop-blur-sm"
                            onclick="window.dispatchEvent(new CustomEvent('open-modal', {
                                detail: {
                                    title: 'Editar menu',
                                    url: '{{ route('menus.edit', $menu->id) }}'
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
        {{ $menus->links() }}
    </div>
</div>
<script>

    document.addEventListener('reload-menus', () => {
        const tableContainer = document.querySelector('#main-content');

        fetch('{{ route('menus') }}', { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(res => res.text())
            .then(html => {
                // Reemplazar contenido dentro de #main-content
                tableContainer.innerHTML = html;
                // Efecto fade-in
                tableContainer.style.opacity = 0;
                setTimeout(() => tableContainer.style.transition = 'opacity 0.4s', 10);
                setTimeout(() => tableContainer.style.opacity = 1, 20);
            })
            .catch(err => console.error('Error recargando menus:', err));
    });
    </script>


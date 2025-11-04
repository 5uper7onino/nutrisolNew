<div class="bg-transparent shadow-md rounded-lg p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-4xl font-semibold text-gray-100">Productos</h2>
        <button
        class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600"
        onclick="window.dispatchEvent(new CustomEvent('open-modal', {
            detail: {
                title: 'Nuevo Producto',
                url: '{{ route('productos.create') }}'
            }
        }))"
    >
        + Nuevo Producto
    </button>
    </div>
    <div class="rounded-xl overflow-auto">
    <table class="min-w-full bg-white/30 backdrop-blur-sm text-gray-900 rounded-xl select-none">
        <thead>
            <tr class="backdrop-blur-xl text-gray-900 uppercase text-sm leading-normal select-none">
                <th class="py-3 px-6 text-gray-50 text-center text-lg">ID</th>
                <th class="py-3 px-6 text-gray-50 text-center text-lg">Nombre</th>
                <th class="py-3 px-6 text-gray-50 text-center text-lg">Precio</th>
                <th class="py-3 px-6 text-gray-50 text-center text-lg">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productos as $producto)
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-1 px-3">{{ $producto->id }}</td>
                    <td class="py-1 px-3">{{ $producto->nombre }}</td>
                    <td class="py-1 px-3 text-center">$ {{ $producto->coste }}</td>
                    <td class="py-1 px-3 text-center">
                        <button
                        class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600"
                        onclick="window.dispatchEvent(new CustomEvent('open-modal', {
                            detail: {
                                title: 'Editar Producto',
                                url: '{{ route('productos.edit', $producto->id) }}'
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
        {{ $productos->links() }}
    </div>
</div>
<script>
    document.addEventListener('reload-productos', () => {
        const tableContainer = document.querySelector('#main-content');

        fetch('{{ route('productos') }}', { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(res => res.text())
            .then(html => {
                // Reemplazar contenido dentro de #main-content
                tableContainer.innerHTML = html;
                // Efecto fade-in
                tableContainer.style.opacity = 0;
                setTimeout(() => tableContainer.style.transition = 'opacity 0.4s', 10);
                setTimeout(() => tableContainer.style.opacity = 1, 20);
            })
            .catch(err => console.error('Error recargando productos:', err));
    });
    </script>


<form
    x-data
    @submit.prevent="
    const formData = new FormData($el);

    // Si es actualización, agregamos manualmente el método PUT
    if ('{{ $producto ? 'true' : 'false' }}' === 'true') {
        formData.append('_method', 'PUT');
    }

    fetch('{{ $producto ? route('productos.update', $producto->id) : route('productos.store') }}', {
        method: 'POST', // siempre POST, Laravel interpretará PUT por _method
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData,
        credentials: 'same-origin' // 🔹 mantiene la sesión del usuario
    })
    .then(async res => {
        // si Laravel redirige (302), fetch lo sigue y devuelve HTML, no JSON
        try {
            const data = await res.json();
            if (data.success) {
                $dispatch('close-modal');
                window.dispatchEvent(new CustomEvent('reload-productos'));
            } else {
                alert('Ocurrió un error: ' + (data.message || 'verifique los campos.'));
            }
        } catch (err) {
            alert('Error inesperado: la respuesta no es JSON.');
        }
    })
    .catch(() => alert('Error de red o servidor.'))
"

    class="space-y-4"

>
@csrf
    <div>
        <label class="block text-sm text-gray-800 font-bold mb-1">Nombre</label>
        <input
            type="text"
            name="nombre"
            value="{{ $producto->nombre ?? '' }}"
            class="w-full border rounded-lg px-3 py-2 bg-white/20"
            placeholder="Nombre completo"
            required
        >
    </div>

    <div>
        <label class="block text-sm text-gray-800 font-bold mb-1">Precio
        </label>
        <input
            type="text"
            name="coste"
            value="{{ $producto->coste ?? '' }}"
            class="w-full border rounded-lg px-3 py-2 bg-white/20"
            placeholder="Descripción"
            required
        >
    </div>

    <div class="flex justify-end">
        <button type="button" class="bg-gray-400/50 px-4 py-2 rounded mr-2" @click="$dispatch('close-modal')">Cancelar</button>
        <button type="submit" class="bg-orange-500/20 backdrop-blur-md text-white px-4 py-2 rounded hover:bg-orange-600">Guardar</button>
    </div>
</form>

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
        <label class="block text-sm text-gray-600 mb-1">Nombre</label>
        <input
            type="text"
            name="nombre"
            value="{{ $producto->nombre ?? '' }}"
            class="w-full border rounded-lg px-3 py-2"
            placeholder="Nombre completo"
            required
        >
    </div>

    <div>
        <label class="block text-sm text-gray-600 mb-1">Precio
        </label>
        <input
            type="text"
            name="coste"
            value="{{ $producto->coste ?? '' }}"
            class="w-full border rounded-lg px-3 py-2"
            placeholder="Descripción"
            required
        >
    </div>
    <!--div class="flex items-center space-x-3">
        <label class="relative inline-flex items-center cursor-pointer">
            <input 
                type="checkbox" 
                name="is_admin" 
                value="1"
                {{-- isset($producto) && $producto->is_admin ? 'checked' : '' --}}
                class="sr-only peer"
            >
            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-orange-500 transition-all duration-300"></div>
            <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow-md transform peer-checked:translate-x-5 transition-all duration-300"></div>
            <span class="ml-3 text-gray-700 font-medium select-none">Administrador</span>
        </label>
    </div-->
    
    

    <div class="flex justify-end">
        <button type="button" class="bg-gray-300 px-4 py-2 rounded mr-2" @click="$dispatch('close-modal')">Cancelar</button>
        <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">Guardar</button>
    </div>
</form>

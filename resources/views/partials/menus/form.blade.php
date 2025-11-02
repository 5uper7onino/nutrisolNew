<form
    x-data
    @submit.prevent="
    const formData = new FormData($el);

    // Si es actualización, agregamos manualmente el método PUT
    if ('{{ $menu ? 'true' : 'false' }}' === 'true') {
        formData.append('_method', 'PUT');
    }

    fetch('{{ $menu ? route('menus.update', $menu->id) : route('menus.store') }}', {
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
                window.dispatchEvent(new CustomEvent('reload-menus'));
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
<div class="flex justify-start gap-x-6">
    <div class="w-1/3">
        <label class="block text-sm text-gray-600 mb-1">Nombre</label>
        <input
            type="text"
            name="nombre"
            value="{{ $menu->nombre ?? '' }}"
            class="w-full border rounded-lg px-3 py-2"
            placeholder="¿Cómo se llama el menú?"
            required
        >
    </div>

    <div class="w-2/3">
        <label class="block text-sm text-gray-600 mb-1">Descripción
        </label>
        <input
            type="text"
            name="descripcion"
            value="{{ $menu->descripcion ?? '' }}"
            class="w-full border rounded-lg px-3 py-2"
            placeholder="Milanesa de pollo, ensalada, fruta..."
            required
        >
    </div>

</div>
    <div class="flex justify-start gap-x-6">
        <div>
            <label class="block text-sm text-gray-600 mb-1">Comensales
            </label>
            <input
                type="number"
                name="comensales"
                value="{{ $menu->comensales ?? '' }}"
                class="w-full border rounded-lg px-3 py-2"
                placeholder="Número de comensales"
                required
            >
        </div>
        <div>
            <label class="block text-sm text-gray-600 mb-1">Tipo
            </label>
            <select
                name="tipo_id"
                class="w-full border rounded-lg px-3 py-2"
                required
            >
                <option value="" disabled {{ !isset($menu) ? 'selected' : '' }}>Seleccione un tipo</option>
                @foreach ($tipos as $tipo)
                    <option value="{{ $tipo->id }}" {{ (isset($menu) && $menu->tipo_id == $tipo->id) ? 'selected' : '' }}>
                        {{ $tipo->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm text-gray-600 mb-1">Temporada
            </label>
            <select
                name="temporada_id"
                class="w-full border rounded-lg px-3 py-2"
                required
            >
                <option value="" disabled {{ !isset($menu) ? 'selected' : '' }}>Seleccione una temporada</option>
                @foreach ($temporadas as $temporada)
                    <option value="{{ $temporada->id }}" {{ (isset($menu) && $menu->temporada_id == $temporada->id) ? 'selected' : '' }}>
                        {{ $temporada->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    
    
    

    <div class="flex justify-end">
        <button type="button" class="bg-gray-300 px-4 py-2 rounded mr-2" @click="$dispatch('close-modal')">Cancelar</button>
        <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">Guardar</button>
    </div>
</form>

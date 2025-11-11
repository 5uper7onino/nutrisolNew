<form
    x-data
    @submit.prevent="
    const formData = new FormData($el);

    // Si es actualización, agregamos manualmente el método PUT
    if ('{{ $usuario ? 'true' : 'false' }}' === 'true') {
        formData.append('_method', 'PUT');
    }

    fetch('{{ $usuario ? route('usuarios.update', $usuario->id) : route('usuarios.store') }}', {
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
                window.dispatchEvent(new CustomEvent('reload-usuarios'));
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
        <x-input-number type="text" label="Nombre" name="name" :value="$usuario->name ?? ''" placeholder="Nombre"/>
        <x-nice-input
            type="text"
            name="name"
            label="Nombre"
            :value="$usuario->name ?? ''"
            placeholder="Nombre completo"
            required />
        <input
            type="text"
            name="name"
            value="{{ $usuario->name ?? '' }}"
            class="w-full border rounded-lg px-3 py-2"
            placeholder="Nombre completo"
            required
        >
    </div>

    <div>
        <label class="block text-sm text-gray-600 mb-1">Email</label>
        <input
            type="email"
            name="email"
            value="{{ $usuario->email ?? '' }}"
            class="w-full border rounded-lg px-3 py-2"
            placeholder="Correo electrónico"
            required
        >
    </div>
    <div class="flex items-center space-x-3">
        <label class="relative inline-flex items-center cursor-pointer">
            <input 
                type="checkbox" 
                name="is_admin" 
                value="1"
                {{ isset($usuario) && $usuario->is_admin ? 'checked' : '' }}
                class="sr-only peer"
            >
            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-orange-500 transition-all duration-300"></div>
            <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow-md transform peer-checked:translate-x-5 transition-all duration-300"></div>
            <span class="ml-3 text-gray-700 font-medium select-none">Administrador</span>
        </label>
    </div>
    
        <label class="block text-sm text-gray-600 mb-1">Contraseña</label>
        <input
            type="password"
            name="password"
            class="w-full border rounded-lg px-3 py-2"
            placeholder="{{ $usuario ? 'Dejar vacío para no cambiar' : 'Contraseña' }}"
            {{ $usuario ? '' : 'required' }}
        >
    </div>

    <div class="flex justify-end">
        <button type="button" class="bg-gray-300 px-4 py-2 rounded mr-2" @click="$dispatch('close-modal')">Cancelar</button>
        <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">Guardar</button>
    </div>
</form>

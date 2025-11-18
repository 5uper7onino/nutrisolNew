<form
    x-data
    @submit.prevent="
        const formData = new FormData($el);

        if ('{{ $usuario ? 'true' : 'false' }}' === 'true') {
            formData.append('_method', 'PUT');
        }

        fetch('{{ $usuario ? route('usuarios.update', $usuario->id) : route('usuarios.store') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData,
            credentials: 'same-origin'
        })
        .then(async res => {
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

    <!-- 🔥 CONTENEDOR RESPONSIVE -->
    <div class="flex flex-col lg:flex-row items-start lg:space-x-4 space-y-4 lg:space-y-0">

        <!-- 🟧 Columna izquierda con Inputs -->
        <div class="flex-1 space-y-3">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <x-nice-input
                    type="text"
                    name="name"
                    label="Nombre"
                    :value="$usuario->name ?? ''"
                    placeholder="Nombre completo"
                    required
                />

                <x-nice-input
                    type="email"
                    name="email"
                    label="Email"
                    :value="$usuario->email ?? ''"
                    placeholder="Correo electrónico"
                    autocomplete="off"
                    required
                />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <x-nice-checkbox
                    name="is_admin"
                    label="Administrador"
                    text="Activo"
                    :checked="$usuario->is_admin ?? false"
                />

                <x-nice-select
                    label="Sucursal"
                    name="sucursal_id"
                    :options="$sucursales"
                    :selected="$usuario->sucursal_id ?? null"
                    placeholder="Elija"
                />
            </div>

            <x-nice-input
                type="password"
                name="password"
                label="Contraseña"
                placeholder="Contraseña"
                required
            />

        </div>

        <!-- 🟧 Columna derecha: Imagen -->
        <div
            x-data="{
                preview: '{{ $usuario && $usuario->profile_photo_path ? asset($usuario->profile_photo_path) : '' }}',
                selectImage() { this.$refs.fileInput.click() },
                handleFileChange(event) {
                    const file = event.target.files[0];
                    if (!file) return;
                    this.preview = URL.createObjectURL(file);
                }
            }"
            class="relative w-40 h-48 mx-auto lg:mx-0 rounded-xl border-2 border-dashed border-gray-400 dark:border-gray-600
                   flex flex-col items-center justify-center text-gray-400 dark:text-gray-200 cursor-pointer
                   hover:border-orange-500 hover:text-orange-500 transition-all backdrop-blur-md bg-white/20 dark:bg-black/30"
            @click="selectImage"
        >
            <template x-if="preview">
                <img :src="preview" class="absolute inset-0 w-full h-full object-cover rounded-xl">
            </template>

            <template x-if="!preview">
                <div class="flex flex-col items-center">
                    <i class="fa fa-user text-4xl mb-2 opacity-70"></i>
                    <span class="text-sm">Subir imagen</span>
                </div>
            </template>

            <input
                type="file"
                name="profile_photo"
                accept="image/*"
                x-ref="fileInput"
                class="hidden"
                @change="handleFileChange"
            />
        </div>

    </div>

    <!-- 🔥 Botones -->
    <div class="flex justify-end pt-2">
        <button type="button" class="bg-gray-300 px-4 py-2 rounded mr-2" @click="$dispatch('close-modal')">
            Cancelar
        </button>
        <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">
            Guardar
        </button>
    </div>

</form>

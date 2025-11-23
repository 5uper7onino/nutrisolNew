<form
    x-data
    @submit.prevent="
        const formData = new FormData($el);

        if ('{{ isset($cita) ? 'true' : 'false' }}' === 'true') {
            formData.append('_method', 'PUT');
        }

        fetch('{{ isset($cita) ? route('citas.update', $cita->id) : route('citas.store') }}', {
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

                if (data.ok) {
                    $dispatch('close-modal');
                    Swal.fire({
                    title: 'Operación exitosa',
                    text: 'Se ha guardado la cita correctamente.',
                    icon: 'success',
                    
                    buttonsStyling: false,
                    customClass: {
                        popup: 'glass-popup',       // 👈 Glass en contenedor
                        confirmButton: 'glass-button',
                        cancelButton: 'glass-button'
                    }
                }).then(()=>{
                    window.dispatchEvent(new CustomEvent('reload-citas'));
                });
                    
                } else {
                    alert('Error: ' + (data.message || 'Verifique los campos.'));
                }

            } catch (err) {
                alert('Error de formato: el servidor no regresó JSON.');
            }
        })
        .catch(() => alert('Error de red o servidor.'))
    "
    class="space-y-4"
>
    @csrf

    <!-- PACIENTE -->
    <label class="block font-semibold">Paciente</label>
    <select 
        name="paciente_id"
        id="paciente_id"
        class="w-full border p-2 rounded"
        required
    >
        <option value="">Seleccione un paciente</option>

        @foreach($pacientes as $p)
            <option 
                value="{{ $p->id }}"
                {{ isset($cita) && $cita->paciente_id == $p->id ? 'selected' : '' }}
            >
                {{ $p->nombre }} {{ $p->apellido }}
            </option>
        @endforeach
    </select>

    <!-- INICIO -->
    <label class="block font-semibold mt-3">Inicio</label>
    <input 
        type="datetime-local"
        name="inicio"
        class="w-full border p-2 rounded"
        value="{{$inicio}}"
        required
    >

    <!-- FIN -->
    <label class="block font-semibold mt-3">Fin (opcional)</label>
    <input 
        type="datetime-local"
        name="fin"
        class="w-full border p-2 rounded"
        value="{{$fin}}"
    >

    <!-- NOTA -->
    <label class="block font-semibold mt-3">Nota (opcional)</label>
    <textarea 
        name="nota"
        class="w-full border p-2 rounded"
        rows="3"
    >{{ $cita->nota ?? '' }}</textarea>

    <div class="flex justify-end mt-4">
        <button type="button" class="bg-gray-300 px-4 py-2 rounded mr-2" @click="$dispatch('close-modal')">Cancelar</button>

        <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">
            Guardar
        </button>
    </div>
</form>

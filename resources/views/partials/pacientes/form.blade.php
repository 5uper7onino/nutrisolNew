<form
    x-data
    @submit.prevent="
    const formData = new FormData($el);

    // Si es actualización, agregamos manualmente el método PUT
    if ('{{ isset($paciente) ? 'true' : 'false' }}' === 'true') {
        formData.append('_method', 'PUT');
    }

    fetch('{{ isset($paciente) ? route('pacientes.update', $paciente->id) : route('pacientes.store') }}', {
        method: 'POST', // siempre POST, Laravel interpretará PUT por _method
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
                window.dispatchEvent(new CustomEvent('reload-pacientes'));
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

<div class="flex flex-wrap gap-x-6">

    <x-input-number type="text" name="nombre" label="Nombre" :value="$paciente->nombre ?? ''" placeholder="Nombre del Paciente" width="w-full sm:w-1/2 lg:w-1/5" required />
    <x-input-number type="text" name="apellido_paterno" label="Apellido Paterno" :value="$paciente->apellido_paterno ?? ''" placeholder="Apellido Paterno" width="w-full sm:w-1/2 lg:w-1/5" required />
    <x-input-number type="text" name="apellido_materno" label="Apellido Materno" :value="$paciente->apellido_materno ?? ''" placeholder="Apellido Materno" width="w-full sm:w-1/2 lg:w-1/5" required />
    <x-input-number type="text" name="apellido_paterno" label="Apellido Paterno" :value="$paciente->apellido_paterno ?? ''" placeholder="Apellido Paterno" width="w-full sm:w-1/2 lg:w-1/5" required />

</div>

<div class="flex flex-wrap gap-x-6">
    <x-input-number type="text" name="curp" label="CURP" :value="$paciente->curp ?? ''" placeholder="CURP" width="w-full sm:w-1/2 lg:w-1/5" required />
    <x-input-number type="date" name="fecha_nacimiento" label="Fecha de Nacimiento" :value="$paciente->fecha_nacimiento ?? ''" placeholder="Fecha de Nacimiento" width="w-full sm:w-1/2 lg:w-1/5" required />
    <x-input-number type="text" name="telefono" label="Teléfono" :value="$paciente->telefono ?? ''" placeholder="Teléfono" width="w-full sm:w-1/2 lg:w-1/5" required />
</div>

<div class="flex flex-wrap gap-x-6">
    <div class="w-1/3 backdrop-blur-md bg-black/10 font-bold p-2 rounded-lg">
        <label class="block font-semibold text-gray-200 mb-1">Estado civil</label>
        <select
            name="estado_civil"
            class="w-full border rounded-lg px-3 py-2 ring-none border-none outline-0 focus:ring-1 focus:ring-orange-500 backdrop-blur-md bg-white/20 font-bold"
        >
            <option value="" disabled {{ empty($paciente->estado_civil) ? 'selected' : '' }}>Seleccione</option>
            <option value="soltero" {{ (isset($paciente) && $paciente->estado_civil == 'soltero') ? 'selected' : '' }}>Soltero(a)</option>
            <option value="casado" {{ (isset($paciente) && $paciente->estado_civil == 'casado') ? 'selected' : '' }}>Casado(a)</option>
            <option value="viudo" {{ (isset($paciente) && $paciente->estado_civil == 'viudo') ? 'selected' : '' }}>Viudo(a)</option>
            <option value="divorciado" {{ (isset($paciente) && $paciente->estado_civil == 'divorciado') ? 'selected' : '' }}>Divorciado(a)</option>
        </select>
    </div>

    <div class="w-1/3 backdrop-blur-md bg-black/10 font-bold p-2 rounded-lg">
        <label class="block font-semibold text-gray-200 mb-1">Ocupación</label>
        <input
            type="text"
            name="ocupacion"
            value="{{ $paciente->ocupacion ?? '' }}"
            class="w-full border rounded-lg px-3 py-2 ring-none border-none outline-0 focus:ring-1 focus:ring-orange-500 backdrop-blur-md bg-white/20 font-bold"
            placeholder="Ocupación actual"
        >
    </div>

    <div class="w-1/3 backdrop-blur-md bg-black/10 font-bold p-2 rounded-lg">
        <label class="block font-semibold text-gray-200 mb-1">Fecha de inicio de tratamiento</label>
        <input
            type="date"
            name="fecha_inicio_tratamiento"
            value="{{ $paciente->fecha_inicio_tratamiento ?? '' }}"
            class="w-full border rounded-lg px-3 py-2 ring-none border-none outline-0 focus:ring-1 focus:ring-orange-500 backdrop-blur-md bg-white/20 font-bold"
        >
    </div>
</div>

<div class="backdrop-blur-md bg-black/10 font-bold p-2 rounded-lg">
    <label class="block font-semibold text-gray-200 mb-1">Motivo de consulta</label>
    <textarea
        name="motivo_consulta"
        class="w-full border rounded-lg px-3 py-2 ring-none border-none outline-0 focus:ring-1 focus:ring-orange-500 backdrop-blur-md bg-white/20 font-bold"
        placeholder="Describa el motivo principal de la consulta"
    >{{ $paciente->motivo_consulta ?? '' }}</textarea>
</div>

<div class="flex justify-end mt-4">
    <button type="button" class="bg-gray-300 px-4 py-2 rounded mr-2" @click="$dispatch('close-modal')">Cancelar</button>
    <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">Guardar</button>
</div>

</form>

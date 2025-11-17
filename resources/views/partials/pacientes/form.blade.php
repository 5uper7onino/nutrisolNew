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

<div x-data="{ tab: 'datos' }" class="mt-6">

    <!-- NAV TABS -->
    <div class="flex border-b border-gray-300 dark:border-gray-700">

        <!-- TAB: DATOS PERSONALES -->
        <button 
            @click="tab = 'datos'"
            type="button"
            :class="tab === 'datos' 
                ? 'border-orange-500 text-orange-600 font-bold' 
                : 'border-transparent text-gray-500'"
            class="px-6 py-3 border-b-4 transition font-semibold text-xl">
            Datos Personales
        </button>

        <!-- TAB: ANTECEDENTES -->
        <button 
            @click="tab = 'antecedentesPatologicos'"
            type="button"
            :class="tab === 'antecedentesPatologicos'
                ? 'border-orange-500 text-orange-600 font-bold' 
                : 'border-transparent text-gray-500'"
            class="px-6 py-3 border-b-4 transition font-semibold text-xl">
            Antecedentes Patológicos
        </button>
        <!-- TAB: ANTECEDENTES NO PATOLÓGICOS-->
        <button 
            @click="tab = 'antecedentesNoPatologicos'"
            type="button"
            :class="tab === 'antecedentesNoPatologicos'
                ? 'border-orange-500 text-orange-600 font-bold' 
                : 'border-transparent text-gray-500'"
            class="px-6 py-3 border-b-4 transition font-semibold text-xl">
            Antecedentes No Patológicos
        </button>
    </div>

    <!-- CONTENIDO TAB: DATOS PERSONALES -->
    <div x-show="tab === 'datos'" x-transition.opacity>
        <!-- AQUÍ PEGAS TODA TU SECCIÓN COMPLETA DE DATOS PERSONALES -->
        <input type="hidden" name="sucursal_id" value="{{ Auth::user()->sucursal_id }}">

        @include('partials.pacientes._personales')
        
    </div>

    <!-- CONTENIDO TAB: ANTECEDENTES PATOLÓGICOS -->
    <div x-show="tab === 'antecedentesPatologicos'" x-transition.opacity>

        @include('partials.pacientes._antecedentes_patologicos')
    </div>

    <!-- CONTENIDO TAB: ANTECEDENTES NO PATOLÓGICOS -->
    <div x-show="tab === 'antecedentesNoPatologicos'" x-transition.opacity>

        @include('partials.pacientes._antecedentes_no_patologicos')
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
<script>
    document.addEventListener('DOMContentLoaded', () => {
    const el = document.getElementById('padecimientos');

    if (el) {
        new TomSelect(el, {
            plugins: ['remove_button'],
            persist: true,
            create: false,
            maxItems: null,
            closeAfterSelect: false,
            hideSelected: true,
            allowEmptyOption: false,
        });
    }
});

</script>
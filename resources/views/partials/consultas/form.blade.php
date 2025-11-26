<form
    x-data
    x-init = "inicializarCalculadora(); imageUploader();"
    @submit.prevent="
        const formData = new FormData($el);

        fetch('{{ route('consultas.store') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData,
            credentials: 'same-origin'
        })
        .then(async res => {
            const data = await res.json();

            if (data.ok) {

                Swal.fire({
                    icon: 'success',
                    title: 'Consulta registrada',
                    text: data.message,
                    confirmButtonColor: '#f97316'
                }).then(() => {
                    $dispatch('close-modal');
                    window.dispatchEvent(new CustomEvent('reload-consultas'));
                });

            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Revise los campos.'
                });
            }
        })
        .catch(() => {
            Swal.fire({
                icon: 'error',
                title: 'Error de red',
                text: 'No se pudo guardar.'
            });
        })
    "
    class="space-y-6 p-4"
>
    <div class="grid grid-cols-3 gap-x-6">

    </div>


    <!-- PESO Y ALTURA -->
    <div class="grid grid-cols-8 gap-4">
        <div>
            <label class="font-semibold block mb-1">Peso (kg)</label>
            <input 
                id="peso"
                name="peso"
                type="number"
                step="0.1"
                class="calc-input w-full border rounded px-3 py-2 focus:ring-orange-500 focus:border-orange-500"
            >
        </div>

        <div>
            <label class="font-semibold block mb-1">Altura (cm)</label>
            <input 
                id="altura"
                name="altura"
                type="number"
                step="0.1"
                class="calc-input w-full border rounded px-3 py-2 focus:ring-orange-500 focus:border-orange-500"
            >
        </div>
        <div>
            <label class="font-semibold block mb-1">Cintura (cm)</label>
            <input 
                id="cintura"
                name="cintura"
                type="number"
                step="0.1"
                class="calc-input w-full border rounded px-3 py-2 focus:ring-orange-500 focus:border-orange-500"
            >
        </div>

        <div>
            <label class="font-semibold block mb-1">Cadera (cm)</label>
            <input 
                id="cadera"
                name="cadera"
                type="number"
                step="0.1"
                class="calc-input w-full border rounded px-3 py-2 focus:ring-orange-500 focus:border-orange-500"
            >
        </div>
        <div>
            <label class="font-semibold block mb-1">Cuello (cm)</label>
            <input 
                id="cuello"
                name="cuello"
                type="number"
                step="0.1"
                class="calc-input w-full border rounded px-3 py-2 focus:ring-orange-500 focus:border-orange-500"
            >
        </div>
                <div>
            <label class="font-semibold block mb-1">IMC</label>
            <input 
                id="imc"
                name="imc"
                readonly
                class="w-full bg-gray-100 border rounded px-3 py-2"
            >
        </div>
        <div>
            <label class="font-semibold block mb-1">ICC</label>
            <input 
                id="icc"
                name="icc"
                readonly
                class="w-full bg-gray-100 border rounded px-3 py-2"
            >
        </div>

        <div>
            <label class="font-semibold block mb-1">IGC</label>
            <input 
                id="igc"
                name="igc"
                readonly
                class="w-full bg-gray-100 border rounded px-3 py-2"
            >
        </div>
    </div>


    <!-- CAMPOS CALCULADOS -->
    <div class="grid grid-cols-3 gap-4">


    </div>

    <!-- DESCRIPCIÓN -->
    <div>
        <label class="font-semibold block mb-1">Descripción</label>
        <textarea 
            name="descripcion"
            class="w-full border rounded px-3 py-2 focus:ring-orange-500 focus:border-orange-500"
            rows="3"
        ></textarea>
    </div>

    <!-- PLAN -->
    <div>
        <label class="font-semibold block mb-1">Plan</label>
        <textarea 
            name="plan"
            class="w-full border rounded px-3 py-2 focus:ring-orange-500 focus:border-orange-500"
            rows="3"
        ></textarea>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6">

    @php
        $fotos = [
            ['label' => 'Frente', 'name' => 'foto_frente', 'col' => $paciente->foto_frente ?? ''],
            ['label' => 'Espalda', 'name' => 'foto_espalda', 'col' => $paciente->foto_espalda ?? ''],
            ['label' => 'Brazo', 'name' => 'foto_brazo', 'col' => $paciente->foto_brazo ?? ''],
            ['label' => 'Pierna', 'name' => 'foto_pierna', 'col' => $paciente->foto_pierna ?? ''],
            ['label' => 'Perfil', 'name' => 'foto_perfil', 'col' => $paciente->foto_perfil ?? ''],
        ];
    @endphp

    @foreach ($fotos as $foto)
        @php
            $preview = $foto['col'] ? asset($foto['col']) : '';
        @endphp

        @include('components.photo', [
            'label' => $foto['label'],
            'name'  => $foto['name'],
            'preview' => $preview
        ])
    @endforeach

</div>


    <!-- BOTONES -->
    <div class="flex justify-end gap-2 pt-4">
        <button type="button" class="px-4 py-2 bg-gray-300 rounded" @click="$dispatch('close-modal')">
            Cancelar
        </button>

        <button 
            type="submit"
            class="px-4 py-2 bg-orange-500 text-white rounded hover:bg-orange-600"
        >
            Guardar consulta
        </button>
    </div>

</form>


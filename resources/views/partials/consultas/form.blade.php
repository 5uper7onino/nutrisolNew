<form
    x-data
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
    <div class="grid grid-cols-2 gap-x-6">
    <!-- PACIENTE -->
    <div>
        <label class="font-semibold block mb-1">Paciente</label>
        <select 
            name="paciente_id"
            class="w-full border rounded px-3 py-2 focus:ring-orange-500 focus:border-orange-500"
            required
        >
            <option value="">Seleccione un paciente</option>
            @foreach ($pacientes as $p)
                <option value="{{ $p->id }}">
                    {{ $p->nombre }} {{ $p->apellido }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- FECHA -->
    <div>
        <label class="font-semibold block mb-1">Fecha</label>
        <input 
            type="date"
            name="fecha"
            class="w-full border rounded px-3 py-2 focus:ring-orange-500 focus:border-orange-500"
            required
        >
    </div>
    </div>


    <!-- PESO Y ALTURA -->
    <div class="grid grid-cols-2 gap-4">
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
    </div>

    <!-- MEDIDAS -->
    <div class="grid grid-cols-3 gap-4">
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
    </div>

    <!-- SEXO -->
    <div>
        <label class="font-semibold block mb-1">Sexo</label>
        <select 
            id="sexo"
            name="sexo"
            class="calc-input w-full border rounded px-3 py-2 focus:ring-orange-500 focus:border-orange-500"
        >
            <option value="H">Hombre</option>
            <option value="M">Mujer</option>
        </select>
    </div>

    <!-- CAMPOS CALCULADOS -->
    <div class="grid grid-cols-3 gap-4">

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

    <!-- FOTOS -->
    <div>
        <label class="font-semibold block mb-1">Fotos (múltiples)</label>
        <input 
            type="file"
            name="fotos[]"
            multiple
            accept="image/*"
            class="w-full"
        >
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

<!-- JS CALCULADOR (funciona aun en render AJAX) -->
<script>
document.querySelectorAll('.calc-input').forEach(el => {
    el.addEventListener('input', calcularValores);
});

function calcularValores() {
    let peso    = parseFloat(document.getElementById('peso')?.value) || 0;
    let altura  = parseFloat(document.getElementById('altura')?.value) || 0;
    let cintura = parseFloat(document.getElementById('cintura')?.value) || 0;
    let cadera  = parseFloat(document.getElementById('cadera')?.value) || 0;
    let cuello  = parseFloat(document.getElementById('cuello')?.value) || 0;
    let sexo    = document.getElementById('sexo')?.value || 'H';

    // IMC
    if (peso > 0 && altura > 0) {
        let altura_m = altura / 100;
        document.getElementById('imc').value = (peso / (altura_m ** 2)).toFixed(2);
    }

    // ICC
    if (cintura > 0 && cadera > 0) {
        document.getElementById('icc').value = (cintura / cadera).toFixed(2);
    }

    // IGC (US Navy)
    if (cintura > 0 && cuello > 0 && altura > 0) {
        let igc = 0;

        if (sexo === 'H') {
            igc = 495 / (
                1.0324
                - 0.19077 * Math.log10(cintura - cuello)
                + 0.15456 * Math.log10(altura)
            ) - 450;

        } else {
            if (cadera > 0) {
                igc = 495 / (
                    1.29579
                    - 0.35004 * Math.log10(cintura + cadera - cuello)
                    + 0.22100 * Math.log10(altura)
                ) - 450;
            }
        }

        document.getElementById('igc').value = igc.toFixed(2);
    }
}
</script>

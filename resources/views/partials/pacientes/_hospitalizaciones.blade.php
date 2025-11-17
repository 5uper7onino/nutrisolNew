@php
$hospitalizacionesData = isset($paciente) 
    ? $paciente->hospitalizaciones->map(function($h) {
        return [
            'id' => $h->id,
            'motivo' => $h->motivo,
            'ingreso' => $h->fecha_ingreso ?? '',
            'alta' => $h->fecha_alta,
            'hospital' => $h->hospital ?? '',
            'notas' => $h->notas ?? ''
        ];
    }) 
    : [];
@endphp

<div x-data='{ hospitalizaciones: @json($hospitalizacionesData) }'>
    
    <div class="h-72 overflow-y-auto space-y-1 pr-2 border-2 border-orange-300 rounded-xl p-4 bg-white/20 dark:bg-black/30 shadow-inner">
        <h2 class="text-2xl font-bold text-orange-600 mb-4 border-b border-orange-300 pb-2">
            Historial de Hospitalizaciones
        </h2>   

        <template x-for="(h, index) in hospitalizaciones" :key="index">
            <div class="flex flex-wrap gap-2 items-center border-b border-gray-200 dark:border-gray-600 pb-1 mb-1">
                <!-- ID oculto para hospitalizaciones existentes -->
                <input type="hidden" name="hospitalizacion_id[]" :value="h.id ?? ''">


                <x-nice-input 
                    type="text"
                    label="Motivo"
                    name="hospitalizacion_motivo[]"
                    placeholder="Especifique"
                    x-model="h.motivo"
                    width="w-full sm:w-1/2 lg:w-[20%]"
                />

                <x-nice-input 
                    type="date"
                    label="Ingreso"
                    name="hospitalizacion_ingreso[]"
                    x-model="h.ingreso"
                    width="w-full sm:w-1/2 lg:w-[16%]"
                />

                <x-nice-input 
                    type="date"
                    label="alta"
                    name="hospitalizacion_alta[]"
                    x-model="h.alta"
                    width="w-full sm:w-1/2 lg:w-[16%]"
                />

                <x-nice-input 
                    type="text"
                    label="Hospital"
                    name="hospitalizacion_hospital[]"
                    x-model="h.hospital"
                    width="w-full sm:w-1/2 lg:w-[20%]"
                />

                <x-nice-input 
                    label="Notas"
                    type="text"
                    name="hospitalizacion_notas[]"
                    x-model="h.notas"
                    width="w-full sm:w-1/2 lg:w-[20%]"
                />

                <button 
                    type="button"
                    class="text-red-500 text-2xl font-bold mt-5"
                    @click="hospitalizaciones.splice(index, 1)"
                    title="Eliminar hospitalización"
                >
                    ✖
                </button>

            </div>
        </template>

    </div>

    <button 
        type="button"
        class="mt-4 px-4 py-2 bg-orange-500 text-white rounded hover:bg-orange-600 transition"
        @click="hospitalizaciones.push({ hospitalizacion_motivo: '', hospitalizacion_ingreso:'', hospitalizacion_alta:'', hospitalizacion_hospital:'', notas:'' })"
    >
        + Agregar hospitalización
    </button>

</div>

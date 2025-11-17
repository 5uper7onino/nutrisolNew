@php
$cirugiasData = isset($paciente) 
    ? $paciente->cirugias->map(function($c) {
        return [
            'id' => $c->id,
            'tipo' => $c->cirugia_tipo_id,
            'otro' => $c->cirugia_otro ?? '',
            'fecha' => $c->fecha,
            'notas' => $c->notas ?? ''
        ];
    }) 
    : [];
@endphp

<div x-data='{ cirugias: @json($cirugiasData) }'>
    
    <div class="h-72 overflow-y-auto space-y-1 pr-2 border-2 border-orange-300 rounded-xl p-4 bg-white/20 dark:bg-black/30 shadow-inner">
        <h2 class="text-2xl font-bold text-orange-600 mb-4 border-b border-orange-300 pb-2">
            Historial de Cirugías
        </h2>   

        <template x-for="(c, index) in cirugias" :key="index">
            <div class="flex flex-wrap gap-4 items-center border-b border-gray-200 dark:border-gray-600 pb-1 mb-1">
                <!-- ID oculto para cirugías existentes -->
                <input type="hidden" name="id[]" :value="c.id ?? ''">

                

                

                <x-nice-select 
                    label="Tipo de cirugía"
                    name="cirugia_tipo[]"
                    :options="$tipos_cirugia"
                    x-model="c.tipo"
                    width="w-full sm:w-1/2 lg:w-[20%]"
                />

                <x-nice-input 
                    type="text"
                    label="Otro (si aplica)"
                    name="cirugia_otro[]"
                    placeholder="Especifique"
                    x-model="c.otro"
                    width="w-full sm:w-1/2 lg:w-[20%]"
                />

                <x-nice-input 
                    type="date"
                    label="Fecha"
                    name="cirugia_fecha[]"
                    x-model="c.fecha"
                    width="w-full sm:w-1/2 lg:w-[20%]"
                />

                <x-nice-input 
                    label="Notas"
                    type="text"
                    name="cirugia_notas[]"
                    x-model="c.notas"
                    width="w-full sm:w-1/2 lg:w-[20%]"
                />

                <button 
                    type="button"
                    class="text-red-500 text-2xl font-bold mt-5"
                    @click="cirugias.splice(index, 1)"
                    title="Eliminar cirugía"
                >
                    ✖
                </button>

            </div>
        </template>

    </div>

    <button 
        type="button"
        class="mt-4 px-4 py-2 bg-orange-500 text-white rounded hover:bg-orange-600 transition"
        @click="cirugias.push({ cirugia_tipo_id: '', cirugia_otro:'', fecha:'', notas:'' })"
    >
        + Agregar cirugía
    </button>

</div>

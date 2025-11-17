@php
$alergiasData = isset($paciente) 
    ? $paciente->alergias->map(function($c) {
        return [
            'id' => $c->id,
            'tipo' => $c->alergia_tipo_id,
            'otro' => $c->alergia_otro ?? '',
            'fecha' => $c->fecha,
            'notas' => $c->notas ?? ''
        ];
    }) 
    : [];
@endphp

<div x-data='{ alergias: @json($alergiasData) }'>
    
    <div class="h-72 overflow-y-auto space-y-1 pr-2 border-2 border-orange-300 rounded-xl p-4 bg-white/20 dark:bg-black/30 shadow-inner">
        <h2 class="text-2xl font-bold text-orange-600 mb-4 border-b border-orange-300 pb-2">
            Historial de alergías
        </h2>   

        <template x-for="(a, index) in alergias" :key="index">
            <div class="flex flex-wrap gap-4 items-center border-b border-gray-200 dark:border-gray-600 pb-1 mb-1">
                <!-- ID oculto para alergías existentes -->
                <input type="hidden" name="alergia_id[]" :value="a.id ?? ''">

                <x-nice-select 
                    label="Tipo de alergía"
                    name="alergia_tipo[]"
                    :options="$tipos_alergia"
                    x-model="a.tipo"
                    width="w-full sm:w-1/2 lg:w-[20%]"
                />

                <x-nice-input 
                    type="text"
                    label="Alergia"
                    name="alergia_nombre[]"
                    placeholder="Especifique"
                    x-model="a.otro"
                    width="w-full sm:w-1/2 lg:w-[20%]"
                />

                <x-nice-input 
                    label="Notas"
                    type="text"
                    name="alergia_notas[]"
                    x-model="a.notas"
                    width="w-full sm:w-1/2 lg:w-[20%]"
                />

                <button 
                    type="button"
                    class="text-red-500 text-2xl font-bold mt-5"
                    @click="alergias.splice(index, 1)"
                    title="Eliminar alergía"
                >
                    ✖
                </button>

            </div>
        </template>

    </div>

    <button 
        type="button"
        class="mt-4 px-4 py-2 bg-orange-500 text-white rounded hover:bg-orange-600 transition"
        @click="alergias.push({ alergia_tipo: '', alergia_nombre:'', alergia_notas:'' })"
    >
        + Agregar alergía
    </button>

</div>

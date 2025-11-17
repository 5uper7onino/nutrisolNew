<div 
    x-data="{
        fuma: {{ old('fuma', $paciente->fuma ?? 0) ? 'true' : 'false' }},
        toma: {{ old('toma', $paciente->toma ?? 0) ? 'true' : 'false' }},
        haceEjercicio: {{ old('hace_ejercicio', $paciente->hace_ejercicio ?? 0) ? 'true' : 'false' }},
        covid: {{ old('tuvo_covid', $paciente->tuvo_covid ?? 0) ? 'true' : 'false' }},
        fracturas: {{ old('fracturas', $paciente->fracturas ?? 0) ? 'true' : 'false' }},
    }"
    class="space-y-8 mt-8"
>
    <!-- Estilo checkbox -->
    <style>
        .pretty-check input:checked + span {
            background: rgba(249, 115, 22, 0.25);
            border-color: rgb(249 115 22);
        }
        .pretty-check input:checked + span::after {
            content: '✔';
            font-size: 0.8rem;
            color: rgb(249 115 22);
            position: absolute;
            top: 2px;
            left: 6px;
        }
    </style>

    <!-- ==================== 3 COLUMNAS ==================== -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        <!-- === FUMA === -->
        <div class="p-4 bg-white/50 dark:bg-black/30 rounded-xl shadow backdrop-blur">
            <label class="pretty-check cursor-pointer inline-flex items-center gap-1 relative">
                <input type="checkbox" x-model="fuma" name="fuma" value="1" class="hidden">
                <span class="w-6 h-6 block rounded-md border border-gray-400 transition"></span>
                <span class="text-xl text-gray-700 dark:text-gray-200">Fuma</span>
            </label>

            <div x-show="fuma" x-transition class="mt-3 space-y-3">
                <x-nice-input 
                    label="Fumador desde"
                    name="fumador_desde"
                    type="date"
                    :value="$paciente->fumador_desde ?? null"
                    width="w-full"
                />

                <x-nice-input 
                    label="Cantidad"
                    type="text"
                    name="fumador_cantidad"
                    :value="$paciente->fumador_cantidad ?? null"
                    width="w-full"
                />
            </div>
        </div>

        <!-- === TOMA === -->
        <div class="p-4 bg-white/50 dark:bg-black/30 rounded-xl shadow backdrop-blur">
            <label class="pretty-check cursor-pointer inline-flex items-center gap-1 relative">
                <input type="checkbox" x-model="toma" name="toma" value="1" class="hidden">
                <span class="w-6 h-6 block rounded-md border border-gray-400 transition"></span>
                <span class="text-xl text-gray-700 dark:text-gray-200">Toma alcohol</span>
            </label>

            <div x-show="toma" x-transition class="mt-3">
                <x-nice-input 
                    label="Frecuencia"
                    type="text"
                    name="toma_frecuencia"
                    :value="$paciente->toma_frecuencia ?? null"
                    width="w-full"
                />
            </div>
        </div>

        <!-- === EJERCICIO === -->
        <div class="p-4 bg-white/50 dark:bg-black/30 rounded-xl shadow backdrop-blur">
            <label class="pretty-check cursor-pointer inline-flex items-center gap-1 relative">
                <input type="checkbox" x-model="haceEjercicio" name="hace_ejercicio" value="1" class="hidden">
                <span class="w-6 h-6 block rounded-md border border-gray-400 transition"></span>
                <span class="text-xl text-gray-700 dark:text-gray-200">Ejercicio</span>
            </label>

            <div x-show="haceEjercicio" x-transition class="mt-3">
                <x-nice-input 
                    label="Tipo de ejercicio"
                    type="text"
                    name="tipo_ejercicio"
                    :value="$paciente->tipo_ejercicio ?? null"
                    width="w-full"
                />
            </div>
        </div>

        <!-- === COVID === -->
        <div class="p-4 bg-white/50 dark:bg-black/30 rounded-xl shadow backdrop-blur">
            <label class="pretty-check cursor-pointer inline-flex items-center gap-1 relative">
                <input type="checkbox" x-model="covid" name="tuvo_covid" value="1" class="hidden">
                <span class="w-6 h-6 block rounded-md border border-gray-400 transition"></span>
                <span class="text-xl text-gray-700 dark:text-gray-200">COVID</span>
            </label>

            <div x-show="covid" x-transition class="mt-3">
                <x-nice-input 
                    label="Fecha"
                    name="covid_fecha"
                    type="date"
                    :value="$paciente->covid_fecha ?? null"
                    width="w-full"
                />
            </div>
        </div>

        <!-- === FRACTURAS === -->
        <div class="p-4 bg-white/50 dark:bg-black/30 rounded-xl shadow backdrop-blur">
            <label class="pretty-check cursor-pointer inline-flex items-center gap-1 relative">
                <input type="checkbox" x-model="fracturas" name="fracturas" value="1" class="hidden">
                <span class="w-6 h-6 block rounded-md border border-gray-400 transition"></span>
                <span class="text-xl text-gray-700 dark:text-gray-200">Fracturas</span>
            </label>

            <div x-show="fracturas" x-transition class="mt-3">
                <x-nice-textarea 
                    label="Detalles"
                    name="detalle_fracturas"
                    :value="$paciente->detalle_fracturas ?? null"
                    rows="2"
                />
            </div>
        </div>
        <!-- === MEDICAMENTOS === -->
        <div class="p-4 bg-white/50 dark:bg-black/30 rounded-xl shadow backdrop-blur">
            <x-nice-textarea 
                label="Medicamentos Actuales"
                name="medicamentos_actuales"
                :value="$paciente->medicamentos_actuales ?? null"
                rows="3"
            />
        </div>

    </div>

</div>

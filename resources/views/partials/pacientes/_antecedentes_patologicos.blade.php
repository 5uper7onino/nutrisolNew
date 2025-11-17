<div x-data="{ tab: 'cirugias' }" class="mt-4">

    <!-- Tabs -->
    <div class="flex border-b border-gray-300 dark:border-gray-700 mb-4">

        <button 
            @click="tab = 'cirugias'"
            type="button"
            :class="tab === 'cirugias' 
                ? 'border-b-2 border-yellow-600 text-yellow-600' 
                : 'text-gray-600 dark:text-gray-400'"
            class="px-4 py-2 font-semibold focus:outline-none"
        >
            Cirugías
        </button>

        <button 
            @click="tab = 'hospitalizaciones'"
            type="button"
            :class="tab === 'hospitalizaciones' 
                ? 'border-b-2 border-yellow-600 text-yellow-600' 
                : 'text-gray-600 dark:text-gray-400'"
            class="px-4 py-2 font-semibold focus:outline-none"
        >
            Hospitalizaciones
        </button>
        <button 
            @click="tab = 'alergias'"
            type="button"
            :class="tab === 'alergias' 
                ? 'border-b-2 border-yellow-600 text-yellow-600' 
                : 'text-gray-600 dark:text-gray-400'"
            class="px-4 py-2 font-semibold focus:outline-none"
        >
            Alergias
        </button>
    </div>

    <!-- Contenido de pestañas -->
    <div>
        <div x-show="tab === 'cirugias'">
            @include('partials.pacientes._cirugias')
        </div>

        <div x-show="tab === 'hospitalizaciones'">
            @include('partials.pacientes._hospitalizaciones')
        </div>

        <div x-show="tab === 'alergias'">
            @include('partials.pacientes._alergias')
        </div>
    </div>

</div>

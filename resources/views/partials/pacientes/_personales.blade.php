<div x-data="{ tab: 'generales' }" class="mt-4">

    <!-- Tabs -->
    <div class="flex border-b border-gray-300 dark:border-gray-700 mb-4">

        <button 
            @click="tab = 'generales'"
            type="button"
            :class="tab === 'generales' 
                ? 'border-b-2 border-yellow-600 text-yellow-600' 
                : 'text-gray-600 dark:text-gray-400'"
            class="px-4 py-2 font-semibold focus:outline-none"
        >
            Generales
        </button>

        <button 
            @click="tab = 'habitos'"
            type="button"
            :class="tab === 'habitos' 
                ? 'border-b-2 border-yellow-600 text-yellow-600' 
                : 'text-gray-600 dark:text-gray-400'"
            class="px-4 py-2 font-semibold focus:outline-none"
        >
            Habitos
        </button>
        <button 
            @click="tab = 'otros'"
            type="button"
            :class="tab === 'otros' 
                ? 'border-b-2 border-yellow-600 text-yellow-600' 
                : 'text-gray-600 dark:text-gray-400'"
            class="px-4 py-2 font-semibold focus:outline-none"
        >
            otros
        </button>
    </div>

    <!-- Contenido de pestañas -->
    <div>
        <div x-show="tab === 'generales'">
            @include('partials.pacientes._generales')
        </div>

        <div x-show="tab === 'habitos'">
            @include('partials.pacientes._habitos')
        </div>

        <div x-show="tab === 'otros'">
        </div>
    </div>

</div>
@props([
    'name' => 'is_admin',
    'label' => 'Administrador',
    'text' => 'Activo',
    'checked' => false,
    'width' => '1/3',
    'id' => null,
])

@php
    $id = $id ?? $name;
    // Si hay un old() para este name, lo respetamos; si no, usamos el prop checked
    $old = session()->getOldInput($name);
    if ($old !== null) {
        // old puede venir como '1' o true, o '0'
        $isChecked = ($old === '1' || $old === 1 || $old === true);
    } else {
        $isChecked = (bool) $checked;
    }
@endphp

<div class=" w-full md:w-{{ $width }} relative p-2 rounded-lg">
    <label
        for="{{ $id }}"
        class="relative flex items-center justify-between border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-3 bg-white/40 dark:bg-black/30 backdrop-blur-md cursor-pointer transition-colors duration-300 hover:bg-white/60 dark:hover:bg-black/50 hover:border-orange-500"
    >
        <!-- Label fijo sobre el borde -->
        <span
            class="absolute -top-3 left-3 px-1.5 text-xl text-orange-500 bg-white/60 dark:bg-black/50 rounded-md backdrop-blur-sm pointer-events-none"
        >
            {{ $label }}
        </span>

        <!-- Texto descriptivo -->
        <span class="text-gray-700 dark:text-gray-200 font-medium select-none">
            {{ $text }}
        </span>

        <!-- Switch -->
        <div class="relative inline-flex items-center">
            <input
                type="checkbox"
                name="{{ $name }}"
                id="{{ $id }}"
                value="1"
                class="sr-only peer"
                {{ $isChecked ? 'checked' : '' }}
            >
            <div class="w-11 h-6 bg-gray-200 rounded-full peer-checked:bg-orange-500 transition-all duration-300"></div>
            <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow-md transform peer-checked:translate-x-5 transition-all duration-300"></div>
        </div>
    </label>
</div>

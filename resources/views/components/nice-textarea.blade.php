@props([
    'label' => '',
    'name' => '',
    'value' => '',
    'rows' => 4,
    'width' => 'w-full',
    'placeholder' => '',
])

<div class="{{ $width }} mb-4">
    <label 
        for="{{ $name }}" 
        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1"
    >
        {{ $label }}
    </label>

    <div class="relative">
        <textarea
            id="{{ $name }}"
            name="{{ $name }}"
            rows="{{ $rows }}"
            placeholder="{{ $placeholder }}"
            class="
                w-full px-4 py-3 rounded-xl bg-white/30 dark:bg-black/30
                border border-gray-300 dark:border-gray-700
                focus:border-orange-500 focus:ring focus:ring-orange-200/50
                dark:focus:border-orange-400 dark:focus:ring-orange-700/40
                backdrop-blur-md transition-all outline-none
                text-gray-800 dark:text-gray-200
                placeholder-gray-400 dark:placeholder-gray-500
            "
        >{{ old($name, $value) }}</textarea>
    </div>
</div>

@props([
    'label' => 'Campo',
    'name' => 'select_field',
    'options' => [],
    'optionValue' => 'id',
    'optionLabel' => 'nombre',
    'selected' => null,
    'placeholder' => 'Seleccione una opción',
    'width' => '1/3',
    'required' => false,
])
<div class="w-{{ $width ?? '1/3' }} relative p-2 rounded-lg">
    <div class="relative">
        <select
            name="{{ $name }}"
            id="{{ $name }}"
            class="peer w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 pt-4 pb-1 text-2xl text-gray-800 dark:text-gray-100 outline-none
                   focus:border-orange-500 focus:ring-0
                   bg-white/40 dark:bg-black/30 backdrop-blur-md appearance-none"
            x-data
            x-on:change="$el.dataset.hasValue = $el.value !== ''"
            x-on:focus="$el.dataset.focused = true"
            x-on:blur="$el.dataset.focused = false"
            x-bind:data-has-value="$el.value !== ''"
        >
            <option value="" disabled selected hidden></option>
            @foreach ($options as $option)
                <option
                    value="{{ $option[$optionValue] }}"
                    {{ $selected == $option[$optionValue] ? 'selected' : '' }}
                >
                    {{ $option[$optionLabel] }}
                </option>
            @endforeach
        </select>

        <label
            for="{{ $name }}"
            class="absolute left-3 top-3.5 text-gray-500 dark:text-gray-300 text-2xl transition-all duration-200 ease-in-out
                   pointer-events-none
                   peer-focus:-top-3 peer-focus:text-xl peer-focus:text-orange-500
                   peer-focus:px-1.5 peer-focus:rounded-md peer-focus:bg-white/60 dark:peer-focus:bg-black/50 backdrop-blur-sm
                   peer-data-[has-value=true]:-top-3 peer-data-[has-value=true]:text-xl peer-data-[has-value=true]:text-orange-500
                   peer-data-[has-value=true]:px-1.5 peer-data-[has-value=true]:rounded-md peer-data-[has-value=true]:bg-white/60 dark:peer-data-[has-value=true]:bg-black/50"
        >
            {{ $label }}
        </label>
    </div>
</div>

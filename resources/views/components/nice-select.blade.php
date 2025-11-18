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

@php
    // Helper local para obtener value y label soportando:
    // - colección de objetos (->id / ->nombre)
    // - array asociativo (key => label) cuando usas pluck()
    // - array de arrays ['id'=>..,'nombre'=>..]
    $normalized = [];
    foreach ($options as $k => $opt) {
        if (is_object($opt)) {
            $val = data_get($opt, $optionValue);
            $lab = data_get($opt, $optionLabel);
        } elseif (is_array($opt)) {
            $val = $opt[$optionValue] ?? $opt[$optionLabel] ?? $k;
            $lab = $opt[$optionLabel] ?? $opt[$optionValue] ?? $k;
        } else {
            // $opt es string => asumimos array asociativo pluck: key => label
            $val = $k;
            $lab = $opt;
        }
        $normalized[] = ['value' => $val, 'label' => $lab];
    }

    // Determina si se pasó x-model entre los atributos
    $hasXModel = $attributes->has('x-model');
    $xModelAttr = $hasXModel ? $attributes->get('x-model') : null;
@endphp

<div class="w-ful md:w-{{ $width ?? '1/3' }} relative p-2 rounded-lg" x-data>
    <div class="relative">
        <select
            name="{{ $name }}"
            id="{{ $name }}"
            class="peer w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 pt-4 pb-0 text-2xl text-gray-800 dark:text-gray-100 outline-none
                   focus:border-orange-500 focus:ring-0
                   bg-white/40 dark:bg-black/30 backdrop-blur-md appearance-none"
            {{-- solo añadir x-model si fue pasado --}}
            @if($hasXModel) x-model="{{ $xModelAttr }}" @endif

            {{-- inicializa data-has-value si tiene selected de servidor o value --}}
            x-init="$el.dataset.hasValue = ($el.value !== '' && $el.value != null) || $el.querySelector('option[selected]') !== null"
            x-on:change="$el.dataset.hasValue = ($el.value !== '' && $el.value != null) || $el.querySelector('option[selected]') !== null"
            x-on:focus="$el.dataset.focused = true"
            x-on:blur="$el.dataset.focused = false"
            x-bind:data-has-value="$el.dataset.hasValue"
            {{ $required ? 'required' : '' }}
        >
            <option value="" disabled hidden>{{ $placeholder }}</option>

            @foreach ($normalized as $opt)
                <option value="{{ $opt['value'] }}" {{ ((string)$selected === (string)$opt['value']) ? 'selected' : '' }}>
                    {{ $opt['label'] }}
                </option>
            @endforeach
        </select>

        <label
            for="{{ $name }}"
            class="absolute left-3 top-3.5 text-gray-500 dark:text-gray-300 text-2xl transition-all duration-200 ease-in-out pointer-events-none backdrop-blur-sm
                   peer-focus:-top-3 peer-focus:text-xl peer-focus:text-orange-500
                   peer-focus:px-1.5 peer-focus:rounded-md peer-focus:bg-white/60 dark:peer-focus:bg-black/50
                   peer-data-[has-value=true]:-top-3 peer-data-[has-value=true]:text-xl peer-data-[has-value=true]:text-orange-500
                   peer-data-[has-value=true]:px-1.5 peer-data-[has-value=true]:rounded-md peer-data-[has-value=true]:bg-white/60 dark:peer-data-[has-value=true]:bg-black/50"
        >
            {{ $label }}
        </label>
    </div>
</div>

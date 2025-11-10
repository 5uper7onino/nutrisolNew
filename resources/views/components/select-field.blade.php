<div class="w-{{ $width ?? '1/3' }} backdrop-blur-md bg-black/10 font-bold p-2 rounded-lg">
    <label class="block font-semibold text-gray-200 mb-1">{{ $label }}</label>

    <select
        name="{{ $name }}"
        class="w-full border rounded-lg px-3 py-2 ring-none border-none outline-0 
               focus:ring-1 focus:ring-orange-500 backdrop-blur-md bg-white/20 font-bold text-gray-100"
        {{ $required ? 'required' : '' }}
    >
        <option value="" disabled {{ !$selected ? 'selected' : '' }}>
            {{ $placeholder ?? 'Seleccione una opción' }}
        </option>

        @foreach ($options as $option)
            <option 
                value="{{ $option[$optionValue] }}" 
                {{ $selected == $option[$optionValue] ? 'selected' : '' }}
            >
                {{ $option[$optionLabel] }}
            </option>
        @endforeach
    </select>
</div>

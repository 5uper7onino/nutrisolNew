<div class="w-{{ $width ?? '1/3' }} backdrop-blur-md bg-black/10 font-bold p-2 rounded-lg">
    <label class="block font-semibold text-gray-200 mb-1">
        {{ $label }}
    </label>

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        value="{{ old($name, $value ?? '') }}"
        class="w-full border rounded-lg px-3 py-2 ring-none border-none outline-0 text-gray-100
               focus:ring-1 focus:ring-orange-500 backdrop-blur-md bg-white/20 font-bold"
        placeholder="{{ $placeholder ?? '' }}"
        {{ $required ? 'required' : '' }}
    >
</div>

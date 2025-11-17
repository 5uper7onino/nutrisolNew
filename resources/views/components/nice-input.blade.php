<div class="w-{{ $width ?? '1/3' }} relative p-2 rounded-lg">
    <div class="relative">
        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $name }}"
            value="{{ old($name, $value ?? '') }}"
            {{ $attributes->merge(['x-model' => $attributes->get('x-model') ?? null]) }}
            placeholder=" "
            class="peer w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 pt-3 pb-0 text-2xl text-gray-800 dark:text-gray-100 outline-none
                   focus:border-orange-500 focus:ring-0
                   bg-white/40 dark:bg-black/30 backdrop-blur-md"
            {{ $required ? 'required' : '' }}
        />
        <label
            for="{{ $name }}"
            class="absolute left-3 top-3.5 text-gray-500 dark:text-gray-300 text-2xl transition-all duration-200 ease-in-out
                   peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-2xl
                   peer-focus:-top-3 peer-focus:text-xl peer-focus:text-orange-500
                   peer-[&:not(:placeholder-shown)]:-top-3 peer-[&:not(:placeholder-shown)]:text-xl peer-[&:not(:placeholder-shown)]:text-orange-500
                   peer-[&:not(:placeholder-shown)]:bg-white/0 dark:peer-[&:not(:placeholder-shown)]:bg-black/50
                   peer-focus:bg-white/60 dark:peer-focus:bg-black/50
                   peer-[&:not(:placeholder-shown)]:px-1.5 peer-focus:px-1.5 peer-[&:not(:placeholder-shown)]:rounded-md peer-focus:rounded-md backdrop-blur-sm"
            autocomplete="off"
        >
            {{ $label }}
        </label>
    </div>
</div>

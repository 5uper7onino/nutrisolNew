@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-green-800']) }}>
    {{ $value ?? $slot }}
</label>

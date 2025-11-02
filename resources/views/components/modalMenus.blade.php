@props(['id', 'maxWidth'])

@php
$id = $id ?? md5($attributes->wire('model'));

$maxWidth = [
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
][$maxWidth ?? '2xl'];
@endphp

<!-- Modal global (crear/editar usuario) -->
<div
    x-data="{ open: false, title: '', content: '' }"
    x-on:close-modal.window="open = false"
    id = "{{ $id }}"
    x-on:open-modal.window="
        title = $event.detail.title;
        open = true;
        content = 'Cargando...';
        fetch($event.detail.url)
            .then(res => res.text())
            .then(html => content = html)
            .catch(() => content = '<p class=\'text-red-500\'>Error al cargar contenido.</p>');
    "
    x-show="open"
    x-cloak
    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
    x-transition.opacity.duration.600ms
>
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-6 relative {{ $maxWidth }} ">
        <button
            @click="open = false"
            class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-2xl leading-none"
        >
            &times;
        </button>

        <h2 class="text-2xl font-semibold text-gray-800 mb-4" x-text="title"></h2>

        <div x-html="content"></div>
    </div>
</div>
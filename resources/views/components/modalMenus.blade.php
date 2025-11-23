@props(['id','maxWidth'])

@php
$id = $id ?? md5($attributes->wire('model'));
$defaultWidth = 'max-w-'.($maxWidth ?? '2xl');
@endphp

<!-- Modal global (crear/editar usuario) -->
<div
    x-data="{ open: false, title: '', content: '',width: '{{ $defaultWidth }}' }"
    x-on:close-modal.window="open = false"
    id = "{{ $id }}"
    x-on:open-modal.window="
        title = $event.detail.title;
        open = true;
        width = $event.detail.maxWidth || '{{ $defaultWidth }}';
        content = 'Cargando...';
        fetch($event.detail.url)
            .then(res => res.text())
            .then(html => {
                content = html; 
                setTimeout(() => initTomSelect(), 50);
            })
            .catch(() => content = '<p class=\'text-red-500\'>Error al cargar contenido.</p>');
    "
    x-show="open"
    x-cloak
    class="fixed inset-0 flex items-center justify-center backdrop-blur z-50"

    x-transition.opacity.50.duration.800ms
>
    <div
    x-bind:class="[
        'border md:border-4 border-orange-600 md:rounded-2xl shadow-3xl bg-orange-50/50 w-11/12 sm:w-full md:p-6 m-0 relative  overflow-y-auto h-full md:h-auto ',
        width === 'max-w-sm' ? 'w-full md:max-w-sm' :
        width === 'max-w-md' ? 'w-full md:max-w-md' :
        width === 'max-w-lg' ? 'w-full md:max-w-lg' :
        width === 'max-w-7xl' ? 'w-full md:max-w-7xl' :
        width === 'max-w-8xl' ? 'w-full md:max-w-[80%]' :
        width === 'full' ? 'w-full h-full' : 'max-w-3xl'
    ]">
        <div class="flex justify-between items-center sticky top-0 bg-orange-600 md:bg-transparent backdrop-blur-lg z-10">
            <h2 class="text-2xl font-semibold text-gray-100 md:text-orange-700" x-text="title"></h2>
            <button
                @click="open = false"
                class=" text-orange-100 md:text-orange-700 hover:text-red-600 font-bold text-4xl"
            >
                &times;
            </button>
        </div>


            <div x-html="content" x-init="$nextTick(() => window.initTomSelect())"></div>
        </div>

</div>

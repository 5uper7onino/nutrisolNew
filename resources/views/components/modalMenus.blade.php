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
            .then(html => content = html)
            .catch(() => content = '<p class=\'text-red-500\'>Error al cargar contenido.</p>');
    "
    x-show="open"
    x-cloak
    class="fixed inset-0 flex items-center justify-center backdrop-blur z-50"

    x-transition.opacity.50.duration.800ms
>
    <div
    x-bind:class="[
        'border-4 border-orange-600 rounded-2xl shadow-3xl bg-orange-50/50 w-11/12 sm:w-full p-6 relative ',
        width === 'max-w-sm' ? 'max-w-sm' :
        width === 'max-w-md' ? 'max-w-md' :
        width === 'max-w-lg' ? 'max-w-lg' :
        width === 'max-w-7xl' ? 'max-w-7xl' :
        width === 'max-w-8xl' ? 'max-w-[70%]' :
        width === 'full' ? 'w-full h-full' : 'max-w-3xl'
    ]">
    <!--style="background-image: url('{{asset("img/Blog-antiguo-1024x738-3.jpg")}}'); background-size: cover; background-position: center; backdrop-filter: blur(10px)"-->

            <button
                @click="open = false"
                class="absolute top-3 right-3 text-orange-700 hover:text-red-600 text-4xl font-bold leading-none"
            >
                &times;
            </button>



            <h2 class="text-2xl font-semibold text-orange-700 mb-4" x-text="title"></h2>

            <div x-html="content"></div>
        </div>

</div>

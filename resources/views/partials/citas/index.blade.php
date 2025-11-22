<div class="p-0 w-full flex flex-col justify-center items-center">
    <h1 class="text-2xl font-semibold mb-4">Calendario de Citas</h1>

    {{-- Contenedor donde FullCalendar se renderizará --}}
    <div id="calendar" class="bg-white/20 shadow rounded-lg p-3"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Cuando este parcial se carga en #main-content,
        // tu app.js debe detectar esto y ejecutar initFullCalendar()

        if (typeof initFullCalendar === 'function') {
            initFullCalendar('calendar');
        }
    });
</script>

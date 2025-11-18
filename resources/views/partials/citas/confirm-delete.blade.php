<div class="p-4">

    <h2 class="text-lg font-semibold mb-3">¿Eliminar esta cita?</h2>

    <p class="mb-4 text-gray-700">
        <strong>Fecha:</strong> {{ $cita->inicio }} <br>
        <strong>Nota:</strong> {{ $cita->nota ?? 'Sin nota' }}
    </p>

    <div class="flex justify-end gap-2">

        <button
            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
            onclick="window.dispatchEvent(new CustomEvent('close-modal'))"
        >
            Cancelar
        </button>

    <button
        onclick="eliminarCita({{ $cita->id }})"
        class="bg-red-500 text-white px-4 py-2 rounded"
    >
        Confirmar eliminación
    </button>


    </div>
</div>

<script>

</script>

<div class="bg-transparent shadow-md rounded-lg p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-4xl font-semibold text-gray-100">Pacientes</h2>
        <button
            class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 font-bold"
            onclick="window.dispatchEvent(new CustomEvent('open-modal', {
                detail: {
                    title: 'Nuevo Paciente',
                    url: '{{ route('pacientes.create') }}',
                    maxWidth:'max-w-8xl'
                }
            }))"
        >
            + Nuevo Paciente
        </button>
    </div>

    <div class="overflow-auto rounded-xl">
        <table class="min-w-full bg-black/30 backdrop-blur-sm text-gray-100 rounded-xl select-none">
            <thead>
                <tr class="backdrop-blur-xl text-gray-900 uppercase text-sm leading-normal select-none">
                    <th class="py-3 px-6 text-gray-50 text-center text-lg">ID</th>
                    <th class="py-3 px-6 text-gray-50 text-center text-lg">Nombre completo</th>
                    <th class="py-3 px-6 text-gray-50 text-center text-lg">CURP</th>
                    <th class="py-3 px-6 text-gray-50 text-center text-lg">Teléfono</th>
                    <th class="py-3 px-6 text-gray-50 text-center text-lg">Edad</th>
                    <th class="py-3 px-6 text-gray-50 text-center text-lg">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pacientes as $paciente)
                    <tr class="border-b hover:bg-white/20">
                        <td class="py-1 font-bold px-3 text-center">{{ $paciente->id }}</td>
                        <td class="py-1 font-bold px-3 text-center">
                            {{ $paciente->nombre }} {{ $paciente->apellido_paterno }} {{ $paciente->apellido_materno }}
                        </td>
                        <td class="py-1 font-bold px-3 text-center">{{ $paciente->curp }}</td>
                        <td class="py-1 font-bold px-3 text-center">{{ $paciente->telefono }}</td>
                        <td class="py-1 font-bold px-3 text-center">{{ $paciente->edad }}</td>
                        <td class="py-1 font-bold px-3 text-center flex items-center justify-center gap-2">
                            <button
                                class="bg-yellow-500/10 border-2 border-yellow-600 text-white px-3 py-1 rounded hover:bg-yellow-500"
                                onclick="window.dispatchEvent(new CustomEvent('open-modal', {
                                    detail: {
                                        title: 'Editar Paciente',
                                        url: '{{ route('pacientes.edit', $paciente->id) }}',
                                        maxWidth:'max-w-8xl'
                                    }
                                }))"
                            >
                                <i class="fa fa-edit"></i>
                            </button>

                            <form action="{{ route('pacientes.destroy', $paciente->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="relative px-3 py-1 rounded-lg border-2 border-red-500/60 text-white font-medium
                                            bg-gradient-to-br from-red-600/50 via-red-600/20 to-red-900/10
                                            hover:from-red-600/40 hover:via-red-700/30 hover:to-red-900/20
                                            transition-all duration-300 shadow-md hover:shadow-red-500/30"
                                    onclick="return confirm('¿Estás seguro de que deseas eliminar este paciente?')"
                                >
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach

                @if ($pacientes->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-300">
                            No hay pacientes registrados.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $pacientes->links() }}
    </div>
</div>

<script>
document.addEventListener('reload-pacientes', () => {
    const tableContainer = document.querySelector('#main-content');

    fetch('{{ route('pacientes.index') }}', { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(res => res.text())
        .then(html => {
            tableContainer.innerHTML = html;
            tableContainer.style.opacity = 0;
            setTimeout(() => tableContainer.style.transition = 'opacity 0.4s', 10);
            setTimeout(() => tableContainer.style.opacity = 1, 20);
        })
        .catch(err => console.error('Error recargando pacientes:', err));
});
</script>

<div class="bg-transparent shadow-md rounded-lg p-0 lg:p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-4xl font-semibold text-gray-700 dark:text-gray-100">Pacientes</h2>
        <button
            class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600"
            onclick="window.dispatchEvent(new CustomEvent('open-modal', {
                detail: {
                    title: 'Nuevo Paciente',
                    url: '{{ route('pacientes.create') }}',
                    maxWidth: 'max-w-8xl'
                }
            }))"
        >
            + Nuevo Paciente
        </button>
    </div>

    <!-- 🖥️ Vista TABLA (idéntica a Usuarios) -->
    <div class="rounded-xl overflow-auto hidden md:block">
        <table class="min-w-full bg-white/30 backdrop-blur-sm text-gray-900 rounded-xl select-none">
            <thead>
                <tr class="backdrop-blur-xl text-gray-900 uppercase text-sm leading-normal select-none">
                    <th class="py-3 px-6 text-gray-700 dark:text-gray-50 text-center text-lg">IDss</th>
                    <th class="py-3 px-6 text-gray-700 dark:text-gray-50 text-center text-lg">Nombre</th>
                    <th class="py-3 px-6 text-gray-700 dark:text-gray-50 text-center text-lg">CURP</th>
                    <th class="py-3 px-6 text-gray-700 dark:text-gray-50 text-center text-lg">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pacientes as $paciente)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-1 px-3">{{ $paciente->id }}</td>
                        <td class="py-1 px-3">{{ $paciente->nombre }}</td>
                        <td class="py-1 px-3">{{ $paciente->curp }}</td>
                        <td class="py-1 px-3 text-center">
                            <button
                                class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600"
                                onclick="window.dispatchEvent(new CustomEvent('open-modal', {
                                    detail: {
                                        title: 'Editar Paciente',
                                        url: '{{ route('pacientes.edit', $paciente->id) }}',
                                        maxWidth: 'max-w-8xl'
                                    }
                                }))"
                            >Editar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- 📱 Vista CARDS (idéntica a Usuarios pero con datos de pacientes) -->
    <div class="md:hidden space-y-4 p-1">
        @foreach ($pacientes as $paciente)
            <div class="bg-white/30 backdrop-blur-lg rounded-xl p-4 shadow border border-white/20">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-700">ID:</p>
                        <p class="text-xl font-semibold">{{ $paciente->id }}</p>

                        <p class="text-sm text-gray-700 mt-2">Nombre:</p>
                        <p class="text-lg">{{ $paciente->nombre }}</p>

                        <p class="text-sm text-gray-700 mt-2">CURP:</p>
                        <p class="text-md">{{ $paciente->curp }}</p>
                    </div>

                    <button
                        class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600"
                        onclick="window.dispatchEvent(new CustomEvent('open-modal', {
                            detail: {
                                title: 'Editar Paciente',
                                url: '{{ route('pacientes.edit', $paciente->id) }}',
                                maxWidth: 'max-w-8xl'
                            }
                        }))"
                    >
                        Editar
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $pacientes->links() }}
    </div>
</div>

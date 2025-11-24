<div class="p-6 space-y-6">

    <!-- Encabezado -->
    <h1 class="text-3xl font-semibold text-green-800 dark:text-gray-200 drop-shadow">
        Tablero del Consultorio
    </h1>

    <!-- GRID DE TARJETAS PRINCIPALES -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Próximas citas -->
        <div class="backdrop-blur-lg bg-white/10 border border-white/20 rounded-2xl shadow-xl p-5 text-green-800 dark:text-gray-200">
            <h2 class="text-lg font-semibold mb-4">Próximas citas</h2>

            @foreach ($proximasCitas as $cita)
                <div class="mb-3 p-3 rounded-xl bg-black/10 border border-white/10">
                    <p class="font-medium">{{ $cita->paciente->nombre }}</p>
                    <p class="text-sm opacity-80">
                        {{ \Carbon\Carbon::parse($cita->inicio)->format('H:i') }}
                    </p>
                </div>
            @endforeach

            @if ($proximasCitas->isEmpty())
                <p class="opacity-60 text-sm">No hay citas próximas.</p>
            @endif
        </div>

        <!-- Pacientes nuevos -->
        <div class="backdrop-blur-lg bg-white/10 border border-white/20 rounded-2xl shadow-xl p-5 text-green-800 dark:text-gray-200">
            <h2 class="text-lg font-semibold mb-4">Pacientes nuevos</h2>

            @foreach ($pacientesNuevos as $p)
                <div class="mb-3 p-3 rounded-xl bg-black/10 border border-white/10 flex justify-between">
                    <div>
                        <p class="font-medium">{{ $p->nombre }}</p>
                        <p class="text-sm opacity-80">
                            Registrado: {{ $p->created_at->format('d/m/Y') }}
                        </p>
                    </div>
                </div>
            @endforeach

            @if ($pacientesNuevos->isEmpty())
                <p class="opacity-60 text-sm">Aún no hay nuevos pacientes.</p>
            @endif
        </div>

        <!-- KPI: Consultas del mes -->
        <div class="backdrop-blur-lg bg-white/10 border border-white/20 rounded-2xl shadow-xl p-5 text-green-800 dark:text-gray-200 text-center">
            <h2 class="text-lg font-semibold mb-4">Consultas del mes</h2>
            <p class="text-6xl font-bold drop-shadow">{{ $consultasMes }}</p>
            <p class="opacity-70 mt-2">Registradas este mes</p>
        </div>
    </div>


    <!-- Últimos pacientes atendidos -->
    <div class="backdrop-blur-lg bg-white/10 border border-white/20 rounded-2xl shadow-xl p-6 text-green-800 dark:text-gray-200">
        <h2 class="text-xl font-semibold mb-4">Últimos pacientes atendidos</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

            @foreach ($ultimosAtendidos as $c)
                <div class="p-4 rounded-xl bg-black/10 border border-white/10">
                    <p class="font-medium">{{ $c->paciente->nombre }}</p>
                    <p class="text-sm opacity-75">Última consulta: {{ $c->fecha->format('d/m/Y') }}</p>
                    <p class="text-sm opacity-75 mt-1">
                        Peso: <span class="font-semibold">{{ $c->peso }} kg</span>  
                        | IMC: <span class="font-semibold">{{ $c->imc }}</span>
                    </p>
                </div>
            @endforeach

            @if ($ultimosAtendidos->isEmpty())
                <p class="opacity-60 text-sm">No hay consultas recientes.</p>
            @endif
        </div>
    </div>

</div>

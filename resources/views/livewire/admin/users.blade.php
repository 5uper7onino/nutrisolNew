<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Usuarios del sistema</h1>

    <input wire:model="search" type="text" placeholder="Buscar usuario..."
           class="border rounded p-2 w-full mb-4">

    <table class="w-full border-collapse bg-white shadow rounded">
        <thead class="bg-gray-100">
            <tr>
                <th class="border p-2 text-left">ID</th>
                <th class="border p-2 text-left">Nombre</th>
                <th class="border p-2 text-left">Email</th>
                <th class="border p-2 text-left">Admin</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $u)
                <tr>
                    <td class="border p-2">{{ $u->id }}</td>
                    <td class="border p-2">{{ $u->name }}</td>
                    <td class="border p-2">{{ $u->email }}</td>
                    <td class="border p-2">
                        @if($u->is_admin)
                            <span class="text-green-600 font-semibold">Sí</span>
                        @else
                            <span class="text-gray-500">No</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>

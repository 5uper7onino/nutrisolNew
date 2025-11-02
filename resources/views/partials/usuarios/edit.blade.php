<div class="p-8">
    <h2 class="text-2xl font-bold mb-4 text-gray-800">Editar usuario</h2>

    <form>
        <div class="mb-4">
            <label class="block text-gray-700">Nombre</label>
            <input type="text" value="{{ $user->name }}" class="border rounded w-full px-3 py-2">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Correo electrónico</label>
            <input type="email" value="{{ $user->email }}" class="border rounded w-full px-3 py-2">
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Actualizar
        </button>
    </form>
</div>

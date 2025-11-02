<div class="p-8">
    <h2 class="text-2xl font-bold mb-4 text-gray-800">Editar Producto</h2>

    <form>
        <div class="mb-4">
            <label class="block text-gray-700">Nombre</label>
            <input type="text" name="nombre" value="{{ $producto->nombre }}" class="border rounded w-full px-3 py-2">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Precio</label>
            <input type="text" name="coste" value="{{ $producto->coste }}" class="border rounded w-full px-3 py-2">
        </div>

        <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">
            Actualizar
        </button>
    </form>
</div>

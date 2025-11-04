<form
    x-data
    @submit.prevent="
    const formData = new FormData($el);

    // Si es actualización, agregamos manualmente el método PUT
    if ('{{ $menu ? 'true' : 'false' }}' === 'true') {
        formData.append('_method', 'PUT');
    }

    fetch('{{ $menu ? route('menus.update', $menu->id) : route('menus.store') }}', {
        method: 'POST', // siempre POST, Laravel interpretará PUT por _method
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData,
        credentials: 'same-origin' // 🔹 mantiene la sesión del usuario
    })
    .then(async res => {
        // si Laravel redirige (302), fetch lo sigue y devuelve HTML, no JSON
        try {
            const data = await res.json();
            if (data.success) {
                $dispatch('close-modal');
                window.dispatchEvent(new CustomEvent('reload-menus'));
            } else {
                alert('Ocurrió un error: ' + (data.message || 'verifique los campos.'));
            }
        } catch (err) {
            alert('Error inesperado: la respuesta no es JSON.');
        }
    })
    .catch(() => alert('Error de red o servidor.'))
"

    class="space-y-4"
>
@csrf
<div class="flex justify-start gap-x-6">
    <div class="w-1/3">
        <label class="block font-semibold text-gray-200 mb-1">Nombre</label>
        <input
            type="text"
            name="nombre"
            value="{{ $menu->nombre ?? '' }}"
            class="w-full border rounded-lg px-3 py-2 ring-none border-none outline-0 focus:ring-1 focus:ring-orange-500"
            placeholder="¿Cómo se llama el menú?"
            required
        >
    </div>

    <div class="w-2/3">
        <label class="block font-semibold text-gray-200 mb-1">Descripción
        </label>
        <input
            type="text"
            name="descripcion"
            value="{{ $menu->descripcion ?? '' }}"
            class="w-full border rounded-lg px-3 py-2 ring-none border-none outline-0 focus:ring-1 focus:ring-orange-500"
            placeholder="Milanesa de pollo, ensalada, fruta..."
            required
        >
    </div>

</div>
    <div class="flex justify-start gap-x-6">
        <div class="w-1/3">
            <label class="block font-semibold text-gray-200 mb-1">Comensales
            </label>
            <input
                type="number"
                name="comensales"
                value="{{ $menu->comensales ?? '' }}"
                class="w-full border rounded-lg px-3 py-2 ring-none border-none outline-0 focus:ring-1 focus:ring-orange-500"
                placeholder="Número de comensales"
                required
            >
        </div>
        <div class="w-1/3">
            <label class="block font-semibold text-gray-200 mb-1">Tipo
            </label>
            <select
                name="tipo_id"
                class="w-full border rounded-lg px-3 py-2 ring-none border-none outline-0 focus:ring-1 focus:ring-orange-500"
                required
            >
                <option value="" disabled {{ !isset($menu) ? 'selected' : '' }}>Seleccione</option>
                @foreach ($tipos as $tipo)
                    <option value="{{ $tipo->id }}" {{ (isset($menu) && $menu->tipo_id == $tipo->id) ? 'selected' : '' }}>
                        {{ $tipo->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="w-1/3">
            <label class="block font-semibold text-gray-200 mb-1">Temporada
            </label>
            <select
                name="temporada_id"
                class="w-full border rounded-lg px-3 py-2 ring-none border-none outline-0 focus:ring-1 focus:ring-orange-500"
                required
            >
                <option value="" disabled {{ !isset($menu) ? 'selected' : '' }}>Seleccione</option>
                @foreach ($temporadas as $temporada)
                    <option value="{{ $temporada->id }}" {{ (isset($menu) && $menu->temporada_id == $temporada->id) ? 'selected' : '' }}>
                        {{ $temporada->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="mt-6 border-t pt-4">
        <h3 class="text-lg font-semibold text-gray-200 mb-2">Productos del menú</h3>

        <div
            x-data="{
                productos: @js($productosSeleccionados??[]),
                lista: @js($productos),
                getCoste(id) {
                    let prod = this.lista.find(p => p.id == id);
                    return prod ? parseFloat(prod.coste) : 0;
                },
                get totalGeneral() {
                    return this.productos.reduce((sum, p) => {
                        const c = this.getCoste(p.producto_id);
                        const q = parseFloat(p.cantidad) || 0;
                        return sum + c * q;
                    }, 0);
                }
            }"
        >
        <div class="h-80 overflow-auto mb-4 border-2 border-gray-400 rounded-2xl my-scroll">
            <table class="min-w-full bg-white/30 backdrop-blur-sm text-gray-900 rounded-xl select-none">
              <thead >
                <tr class="backdrop-blur-xl text-gray-900 uppercase text-sm leading-normal select-none">
                  <th colspan="4" class="py-3 px-6  sticky top-0 z-20 bg-gray-100 text-center border-b border-gray-300">Producto</th>
                  <th class="py-3 px-6 sticky top-0 z-20 bg-gray-100 text-center border-b border-gray-300">Cantidad</th>
                  <th class="py-3 px-6 sticky top-0 z-20 bg-gray-100 text-center border-b border-gray-300">Coste Unitario</th>
                  <th class="py-3 px-6 sticky top-0 z-20 bg-gray-100 text-center border-b border-gray-300">Coste Total</th>
                  <th class="py-3 px-2 sticky top-0 z-20 bg-gray-100 text-center border-b border-gray-300"></th>
                </tr>
              </thead>
              <tbody class="">
                    <template x-for="(prod, index) in productos" :key="index">

                        <!-- Seleccionar producto -->
                        <tr>
                            <td colspan="4" class="px-1 py-2 text-center">
                                <select
                                    class="border rounded-lg px-3 py-2 ring-none border-none outline-0 focus:ring-1 focus:ring-orange-500"
                                    x-model="prod.producto_id"
                                    :name="'productos['+index+'][producto_id]'"
                                    required
                                >
                                    <option value="" disabled>Seleccione</option>
                                    <template x-for="item in lista" :key="item.id">
                                        <option :value="item.id" x-text="item.nombre"></option>
                                    </template>
                                </select>
                            </td>
                            <td class="pt-1 py-2 text-center">
                                <!-- Cantidad -->
                                <input
                                    type="number"
                                    step="0.5"
                                    min="0.5"
                                    class="border rounded-lg px-3 py-2 w-1/4 ring-none border-none outline-0 focus:ring-1 focus:ring-orange-500 w-2/3"
                                    placeholder="Cantidad"
                                    x-model="prod.cantidad"
                                    :name="'productos['+index+'][cantidad]'"
                                    required
                                >

                            </td>
                            <td class="px-1 py-2 text-center">
                                <!-- Coste unitario -->
                                <input
                                    type="text"
                                    readonly
                                    class="border rounded-lg px-3 py-2 bg-gray-100 ring-none border-none outline-0 focus:ring-1 focus:ring-orange-500 w-2/3"
                                    x-bind:value="'$ '+getCoste(prod.producto_id).toFixed(2)"
                                    placeholder="Coste unitario"
                                >
                            </td>
                            <td class="px-1 py-2 text-center">
                                <!-- Coste total -->
                                <input
                                    type="text"
                                    readonly
                                    class="border rounded-lg px-3 py-2 w-1/4 bg-gray-100 ring-none border-none outline-0 focus:ring-1 focus:ring-orange-500 w-2/3"
                                    x-bind:value="'$ '+(getCoste(prod.producto_id) * prod.cantidad || 0).toFixed(2)"
                                    placeholder="Coste total"
                                >
                            </td>
                            <td class="px-2">
                                <!-- Eliminar fila -->
                                <button
                                    type="button"
                                    class="text-red-500 hover:text-red-700 font-bold"
                                    @click="productos.splice(index, 1)">
                                    ✕
                                </button>
                            </td>
                        </tr>

                </template>
                </tbody>
            </table>
        </div>



        <div class="flex items-center justify-between mt-2">
            <!-- Total general -->
            <div class="text-right font-semibold text-gray-200">
                Total general:
                <span class="text-green-600" x-text="'$ ' + totalGeneral.toFixed(2)"></span>
            </div>

            <!-- Botón para agregar producto -->
            <button
                type="button"
                class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 text-semibold"
                @click="productos.push({producto_id: '', cantidad: ''})">
                + Agregar producto
            </button>
        </div>
        </div>
    </div>




    <div class="flex justify-end">
        <button type="button" class="bg-gray-300 px-4 py-2 rounded mr-2" @click="$dispatch('close-modal')">Cancelar</button>
        <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">Guardar</button>
    </div>
</form>

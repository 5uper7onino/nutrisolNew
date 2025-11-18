<div class="mt-4">
        
    <!-- GRID MAESTRO: 4 columnas, foto ocupa 1 col y 3 filas -->
    <div class="grid grid-cols-1 lg:grid-cols-6">

        <!-- FOTO (columna derecha) -->
        <div class="order-1 lg:order-2 lg:col-span-1 lg:row-span-2 flex justify-start items-center">
            <div
                x-data="{
                    preview: '{{ $paciente && $paciente->profile_photo_path ? asset($paciente->profile_photo_path) : '' }}',
                    selectImage() { this.$refs.fileInput.click() },
                    handleFileChange(e) {
                        const file = e.target.files[0];
                        if (file) this.preview = URL.createObjectURL(file);
                    }
                }"
                class="relative w-48 h-64 rounded-xl border-2 border-dashed border-gray-400 dark:border-gray-600
                    flex flex-col justify-center text-gray-400 dark:text-gray-200 cursor-pointer
                    hover:border-orange-500 hover:text-orange-500 transition-all backdrop-blur-md bg-white/20 dark:bg-black/30"
                @click="selectImage">

                <template x-if="preview">
                    <img :src="preview" class="absolute inset-0 w-full h-full object-cover rounded-xl">
                </template>

                <template x-if="!preview">
                    <div class="flex flex-col items-center">
                        <i class="fa fa-user text-4xl mb-2 opacity-70"></i>
                        <span class="text-sm">Subir imagen</span>
                    </div>
                </template>

                <input type="file"
                    name="profile_photo"
                    accept="image/*"
                    x-ref="fileInput"
                    class="hidden"
                    @change="handleFileChange" />
            </div>
        </div>

        <!-- CAMPOS (3 columnas) -->
        <div class="order-2 lg:order-1 lg:col-span-5">

            <!-- PRIMERA FILA: ahora sí entran 4 si quieres -->
            <div class="row flex flex-wrap gap-x-4">
                <x-nice-input width="w-full sm:w-1/2 lg:w-[30%]"
                    type="text" name="nombre" label="Nombre"
                    :value="$paciente->nombre ?? ''"
                    placeholder="Nombre del Paciente" required />

                <x-nice-input width="w-full sm:w-1/2 lg:w-[30%]"
                    type="text" name="apellido_paterno" label="Apellido Paterno"
                    :value="$paciente->apellido_paterno ?? ''"
                    placeholder="Apellido Paterno" required />

                <x-nice-input width="w-full sm:w-1/2 lg:w-[30%]"
                    type="text" name="apellido_materno" label="Apellido Materno"
                    :value="$paciente->apellido_materno ?? ''"
                    placeholder="Apellido Materno" required />
            </div>

            <!-- SIGUIENTES FILAS IGUAL QUE TENÍAS -->
            <div class="row flex flex-wrap gap-x-4 mt-4">
                <x-nice-input width="w-full sm:w-1/2 lg:w-[30%]"
                    type="text" name="curp" label="CURP"
                    :value="$paciente->curp ?? ''" required />

                <x-nice-input type="date" name="fecha_nacimiento" label="Nacimiento"
                    width="w-full sm:w-1/2 lg:w-[30%]"
                    :value="$paciente->fecha_nacimiento ?? ''" required />

                <x-nice-input type="text" name="telefono" label="Teléfono"
                    width="w-full sm:w-1/2 lg:w-[30%]"
                    :value="$paciente->telefono ?? ''" required />
            </div>

            <div class="row flex flex-wrap gap-x-4 mt-4">
                <x-nice-select label="Estado Civil" name="estado_civil_id"
                    width="w-full sm:w-1/2 lg:w-[30%]"
                    :options="$estado_civiles"
                    :selected="$paciente->estado_civil_id ?? null" />

                <x-nice-select label="Ocupación" name="ocupacion_id"
                    width="w-full sm:w-1/2 lg:w-[30%]"
                    :options="$ocupaciones"
                    :selected="$paciente->ocupacion_id ?? null" />

                <x-nice-select label="Escolaridad" name="escolaridad_id"
                    width="w-full sm:w-1/2 lg:w-[30%]"
                    :options="$escolaridades"
                    :selected="$paciente->escolaridad_id ?? null" />
            </div>

            <div class="row flex flex-wrap gap-x-4 mt-4">

                <x-nice-input type="email" name="email" label="Correo Electrónico"
                    width="w-full sm:w-1/2 lg:w-[30%]"
                    :value="$paciente->email ?? ''" />
                <x-nice-input type="text" name="direccion" label="Dirección"
                    width="w-full sm:w-1/2 lg:w-[30%]"
                    :value="$paciente->direccion ?? ''" />

                <x-nice-input type="date" name="fecha_inicio" label="Inicio"
                    width="w-full sm:w-1/2 lg:w-[30%]"
                    :value="$paciente->fecha_inicio ?? ''" />

            </div>
            <select 
                id="padecimientos"
                name="padecimientos[]"
                multiple
                placeholder="Selecciona uno o varios..."
                class="tom tom-custom w-full sm:w-1/2 lg:w-3/4"
            >
                @foreach ($padecimientos as $p)
                    <option 
                        value="{{ $p->id }}"
                        @if(isset($paciente) && $paciente->padecimientos->contains($p->id)) selected @endif
                    >
                        {{ $p->nombre }}
                    </option>
                @endforeach
            </select>
        

                
        </div>

    </div>
</div>
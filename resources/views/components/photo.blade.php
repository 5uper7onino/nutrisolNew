<div 
    x-data="imageUploader('{{ $preview }}')" 
    class="relative w-48 h-64 rounded-xl border-2 border-dashed border-gray-400 dark:border-gray-600
        flex flex-col justify-center text-gray-400 dark:text-gray-200 cursor-pointer
        hover:border-orange-500 hover:text-orange-500 transition-all backdrop-blur-md bg-white/20 dark:bg-black/30"
    @click="selectImage">

    <span class="absolute top-2 left-2 bg-black/40 text-white px-2 py-1 text-xs rounded">
        {{ $label }}
    </span>

    <template x-if="preview">
        <img :src="preview" class="absolute inset-0 w-full h-full object-cover rounded-xl">
    </template>

    <template x-if="!preview">
        <div class="flex flex-col items-center">
            <i class="fa fa-camera text-4xl mb-2 opacity-70"></i>
            <span class="text-sm">Subir imagen</span>
        </div>
    </template>

    <input 
        type="file" 
        name="{{ $name }}"
        accept="image/*"
        x-ref="fileInput"
        class="hidden"
        @change="handleFileChange"
    />
</div>
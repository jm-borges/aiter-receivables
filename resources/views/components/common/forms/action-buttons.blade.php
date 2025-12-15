@props([
    'cancelRoute' => '',
])

{{-- Botões --}}
<div class="mt-6 flex justify-end space-x-3">
    <a href="{{ $cancelRoute }}"
        class="inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
        Cancelar
    </a>
    <button type="submit"
        class="inline-flex justify-center rounded-md border border-transparent bg-[#69549F] px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
        Salvar
    </button>
</div>

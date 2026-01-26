@props(['suppliers', 'user' => null])

<div class="mb-4">
    <label for="supplier_id" class="block text-sm font-medium text-gray-700">Fornecedor</label>
    <select name="supplier_id" id="supplier_id"
        class="mt-1 block w-full rounded-md border-gray-300 bg-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        <option value="">Nenhum fornecedor</option>
        @foreach ($suppliers as $supplier)
            <option value="{{ $supplier->id }}" @selected(old('supplier_id', $user->supplier_id ?? '') == $supplier->id)>
                {{ $supplier->name }}
            </option>
        @endforeach
    </select>
    @error('supplier_id')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>

{{-- Checkbox para criar fornecedor automático --}}
<div class="mb-4 flex items-center gap-2">
    <input type="checkbox" name="create_supplier" id="create_supplier" value="1" @checked(old('create_supplier'))
        class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
    <label for="create_supplier" class="block text-sm text-gray-700">
        Criar e associar fornecedor automaticamente com os dados deste usuário
    </label>
</div>

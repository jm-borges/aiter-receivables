@props([
    'partner' => null,
    'inline' => false,
])

<div @class(['mb-4' => !$inline])>
    <label for="document_number" class="block text-sm font-medium text-gray-700">Documento</label>

    <input type="text" name="document_number" id="document_number"
        value="{{ old('document_number', $partner?->document_number) }}" placeholder="00.000.000/0000-00" maxlength="18"
        class="cnpj-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
</div>

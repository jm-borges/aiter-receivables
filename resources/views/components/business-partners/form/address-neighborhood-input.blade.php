@props(['partner' => null])

<div class="mb-4">
    <label for="address_neighborhood" class="block text-sm font-medium text-gray-700">Bairro</label>
    <input type="text" name="address_neighborhood" id="address_neighborhood"
        value="{{ old('address_neighborhood', $partner->address_neighborhood ?? '') }}"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
</div>

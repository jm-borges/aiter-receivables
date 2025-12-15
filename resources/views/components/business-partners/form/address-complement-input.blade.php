@props(['partner' => null])

<div class="mb-4">
    <label for="address_complement" class="block text-sm font-medium text-gray-700">Complemento</label>
    <input type="text" name="address_complement" id="address_complement"
        value="{{ old('address_complement', $partner->address_complement ?? '') }}"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
</div>

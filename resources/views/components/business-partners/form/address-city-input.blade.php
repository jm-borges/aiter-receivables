@props(['partner' => null])

<div class="mb-4">
    <label for="address_city" class="block text-sm font-medium text-gray-700">Cidade</label>
    <input type="text" name="address_city" id="address_city"
        value="{{ old('address_city', $partner->address_city ?? '') }}"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
</div>

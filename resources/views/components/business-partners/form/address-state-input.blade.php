@props(['partner' => null])

<div class="mb-4">
    <label for="address_state" class="block text-sm font-medium text-gray-700">Estado</label>
    <input type="text" name="address_state" id="address_state"
        value="{{ old('address_state', $partner->address_state ?? '') }}"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
</div>

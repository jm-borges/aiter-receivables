@props(['partner' => null])

<div class="mb-4">
    <label for="postal_code" class="block text-sm font-medium text-gray-700">CEP</label>
    <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $partner->postal_code ?? '') }}"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
</div>

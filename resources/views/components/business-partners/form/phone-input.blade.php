@props([
    'partner' => null,
    'inline' => false,
])

<div @class(['mb-4' => !$inline])>
    <label for="phone" class="block text-sm font-medium text-gray-700">Telefone</label>
    <input type="text" name="phone" id="phone" value="{{ old('phone', $partner?->phone) }}"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
</div>

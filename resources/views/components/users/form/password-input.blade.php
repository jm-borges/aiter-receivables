@props([
    'user' => null,
    'inline' => false,
])

<div @class(['mb-4' => !$inline])>
    <label for="password" class="block text-sm font-medium text-gray-700">
        Senha {{ isset($user) ? '(deixe em branco para manter)' : '' }}
    </label>
    <input type="password" name="password" id="password" {{ isset($user) ? '' : 'required' }}
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
    @error('password')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>

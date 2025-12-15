@props([
    'user' => null,
])


{{-- Super Admin --}}
<div class="mb-4 flex items-center">
    <input id="is_super_admin" name="is_super_admin" type="checkbox" value="1"
        class="h-4 w-4 text-indigo-600 border-gray-300 rounded"
        {{ old('is_super_admin', $user->is_super_admin ?? false) ? 'checked' : '' }}>
    <label for="is_super_admin" class="ml-2 block text-sm text-gray-700">
        Usuário é Super Admin
    </label>
</div>

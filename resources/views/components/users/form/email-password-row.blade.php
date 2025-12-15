@props(['user' => null])

<div class="mb-4 flex gap-4">
    {{-- Email --}}
    <div class="flex-1">
        <x-users.form.email-input :user="$user" :inline="true" />
    </div>

    {{-- Senha --}}
    <div class="flex-1">
        <x-users.form.password-input :user="$user" :inline="true" />
    </div>
</div>

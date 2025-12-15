@props(['user' => null])

<div class="mb-4 flex gap-4">
    {{-- Nome --}}
    <div class="flex-[7]">
        <x-users.form.name-input :user="$user" :inline="true" />
    </div>

    {{-- Telefone --}}
    <div class="flex-[3]">
        <x-users.form.phone-input :user="$user" :inline="true" />
    </div>
</div>

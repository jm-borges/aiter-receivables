@props(['suppliers', 'user' => null])

<form method="POST" action="{{ isset($user) ? '/users/' . $user->id : '/users' }}">
    @csrf
    @if (isset($user))
        @method('PUT')
    @endif

    <x-users.form.name-phone-row :user="$user ?? null" />

    <x-users.form.email-password-row :user="$user ?? null" />

    <x-users.form.supplier-section :suppliers="$suppliers" :user="$user ?? null" />

    <x-users.form.super-admin-input :user="$user ?? null" />

    <x-common.forms.action-buttons cancelRoute="/users" />
</form>

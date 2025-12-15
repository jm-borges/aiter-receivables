<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h1 class="text-2xl font-bold text-white mb-6">
                {{ isset($user) ? 'Editar usuário' : 'Cadastrar usuário' }}</h1>
        </div>
    </x-slot>

    <x-common.errors-container :errors="$errors" />

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <x-users.form.form :suppliers="$suppliers" :user="$user ?? null" />
            </div>
        </div>
    </div>
</x-app-layout>

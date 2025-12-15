<x-app-layout>

    <x-slot name="header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h1 class="text-2xl font-bold text-white mb-6">
                {{ isset($partner) ? 'Editar Parceiro' : 'Novo Parceiro' }}</h1>
        </div>
    </x-slot>

    <x-common.errors-container :errors="$errors" />

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <x-business-partners.form.form :partner="$partner" :types="$types" />
            </div>
        </div>
    </div>

</x-app-layout>

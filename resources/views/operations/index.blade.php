<x-app-layout>

    <x-slot name="header">
        <x-common.page-header title="Operações" />
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-common.error-message />
            <x-common.success-message />
            <x-operations.table :operations="$operations" />
        </div>
    </div>

</x-app-layout>

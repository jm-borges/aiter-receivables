<x-app-layout>

    <x-slot name="header">
        <div class="max-w-7xl  px-4 sm:px-6 lg:px-8 py-6" style="display: flex">
            <h1 class="font-bold text-white mb-2" style="font-size: 32px">Contratos</h1>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-common.error-message />
            <x-common.success-message />
            <x-contracts.table :contracts="$contracts" />
        </div>
    </div>
</x-app-layout>

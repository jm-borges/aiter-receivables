<x-app-layout>

    <x-slot name="header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Opt-Ins</h1>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-common.success-message />
            <x-common.error-message />
            <x-opt-ins.table :optins="$optins" />
        </div>
    </div>

</x-app-layout>

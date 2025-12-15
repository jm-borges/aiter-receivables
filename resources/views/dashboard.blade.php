<x-app-layout>
    <x-slot name="header">
        <x-common.page-header title="Detalhamento operacional" />
    </x-slot>

    <x-dashboard.top-cards />

    <x-dashboard.search-field />

    <x-dashboard.dashboard-table :partners="$partners" />

</x-app-layout>

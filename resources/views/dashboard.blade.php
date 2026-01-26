<x-app-layout>
    <x-slot name="header">
        <x-common.page-header title="Detalhamento operacional" />
    </x-slot>

    @if (session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <x-dashboard.top-cards />

    <x-dashboard.search-field />

    <x-dashboard.dashboard-table :partners="$partners" />

    @push('page-scripts')
        <script type="module" src="/assets/scripts/dashboard.js"></script>
    @endpush

</x-app-layout>

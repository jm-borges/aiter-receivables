<x-app-layout>
    <x-slot name="header">
        <x-common.page-header title="Executar operação" subtitle="Configure e execute operações de trava de recebíveis" />
    </x-slot>

    <x-common.errors-container />

    <form action="{{ route('operations.execute-submit') }}" method="post" id="execute-operation-form">
        @csrf
        <x-common.company-selector title="Identificação" search-label="Buscar empresa por CNPJ ou Razão Social"
            select-label="Empresa" />
        <x-operation-execute-index.operation-info-fields-container />
    </form>

    <x-common.calendar-modal :id="'receivables'" />

    @push('page-scripts')
        <script type="module" src="/assets/scripts/operation-execute-index/main.js"></script>
    @endpush

</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <x-common.page-header title="Conciliação de Operações"
            subtitle="Selecione uma empresa e visualize o status de recebíveis e inadimplência" />
    </x-slot>

    <x-common.company-selector title="Identificação" search-label="Buscar empresa por CNPJ ou Razão Social"
        select-label="Empresa" />

    <x-receivables-query.receivables-status-section :partners="$partners" />

    <x-receivables-query.payment-default-section :partners="$partners" />

    <x-common.calendar-modal :id="'receivables'" />

    @push('page-scripts')
        <script type="module" src="/assets/scripts/conciliation/main.js"></script>
        <script type="module" src="/assets/scripts/conciliation.js"></script>
    @endpush

</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <x-common.page-header title="Análise de Crédito" />
    </x-slot>

    <x-common.company-selector title="Identificação" search-label="Buscar empresa por CNPJ ou Razão Social"
        select-label="Empresa" />

    <div id="cnpj-result">
    </div>


    <div id="credit-analysis-data-container" class="hidden">
        <x-credit-analysis.value-field-container />

        <x-credit-analysis.warranty-availability-section />

        <x-credit-analysis.bank-debts-section />
    </div>

    @push('page-scripts')
        <script type="module" src="/assets/scripts/credit-analysis/main.js"></script>
    @endpush


</x-app-layout>

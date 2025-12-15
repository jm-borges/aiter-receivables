<x-app-layout>
    <x-slot name="header">
        <x-common.page-header title="Consulta de Recebíveis"
            subtitle="Selecione uma empresa e visualize o status de recebíveis e inadimplência" />
    </x-slot>

    <x-receivables-query.partner-selector-container />

    <x-receivables-query.receivables-status-section />

    <x-receivables-query.payment-default-section />

</x-app-layout>

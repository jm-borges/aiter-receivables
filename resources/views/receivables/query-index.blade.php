<x-app-layout>
    <x-slot name="header">
        <x-common.page-header title="Conciliação de Operações"
            subtitle="Selecione uma empresa e visualize o status de recebíveis e inadimplência" />
    </x-slot>

    <x-common.company-selector title="Identificação" search-label="Buscar empresa por CNPJ ou Razão Social"
        select-label="Empresa" />

    <x-receivables-query.receivables-status-section :partners="$partners" />

    <x-receivables-query.payment-default-section :partners="$partners" />

    <div id="receivables-modal-overlay"
        class="fixed inset-0 bg-[rgba(20,10,40,0.6)] flex items-center justify-center z-[9999] hidden">
        <div class="bg-[#f3f1f8] rounded-xl w-[90%] max-w-[800px] max-h-[85vh] flex flex-col overflow-hidden">

            {{-- Header --}}
            <div class="px-5 py-4 bg-[#2b1d55] text-white flex justify-between items-center">
                <span id="receivables-modal-title">Agenda</span>
                <button id="receivables-modal-close" class="text-white text-xl hover:opacity-80 transition">✕</button>
            </div>

            {{-- Body --}}
            <div class="p-5 overflow-auto" id="receivables-modal-body">
                <x-receivables-query.calendar />
            </div>

        </div>
    </div>


    @push('page-scripts')
        <script type="module" src="/assets/scripts/query-index/main.js"></script>
        <script type="module" src="/assets/scripts/conciliation.js"></script>
        <script type="module" src="/assets/scripts/calendar/calendar.js"></script>
    @endpush

</x-app-layout>

<div id="operation-info-fields-container" class="mt-5 flex flex-col md:flex-row md:gap-4 items-stretch"
    style="display: none; align-items: stretch;">

    {{-- Coluna esquerda: Agenda de Recebíveis --}}
    <div class="flex-1 flex flex-col">
        <x-operation-execute-index.operation-receivables-schedule-component />
    </div>

    {{-- Coluna direita: Trava de Recebíveis a Performar --}}
    <div class="flex-1 flex flex-col">
        <x-operation-execute-index.operation-form-input-card title="Trava de Recebíveis a Performar" />
    </div>

</div>

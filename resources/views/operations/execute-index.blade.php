<x-app-layout>
    <x-slot name="header">
        <x-common.page-header title="Executar operação" subtitle="Configure e execute operações de trava de recebíveis" />
    </x-slot>

    <x-common.errors-container />

    <form action="{{ route('operations.execute-submit') }}" method="post" id="execute-operation-form">
        @csrf
        <x-operation-execute-index.operation-client-field-container />
        <x-operation-execute-index.operation-info-fields-container />
    </form>

</x-app-layout>

<x-app-layout>

    <x-slot name="header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h1 class="text-2xl font-bold text-custom-blue-hover mb-6">
                {{ isset($contract) ? 'Editar Contrato' : 'Novo Contrato' }}</h1>
            <a href="{{ route('contracts.index') }}"
                class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition">
                Voltar
            </a>
        </div>
    </x-slot>


    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-800 border border-red-300 rounded">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($contract) ? route('contracts.update', $contract) : route('contracts.store') }}" method="POST"
        class="space-y-6 bg-white p-6 rounded shadow">
        @csrf
        @if (isset($contract))
            @method('PUT')
        @endif

        {{-- Cliente --}}
        <div>
            <label for="client_id" class="block text-sm font-medium text-gray-700">Cliente</label>
            <select name="client_id" id="client_id" required
                class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Selecione o cliente</option>
                @foreach ($clients as $client)
                    <option value="{{ $client->id }}"
                        {{ isset($contract) && $contract->client_id == $client->id ? 'selected' : '' }}>
                        {{ $client->name }} | {{ format_document($client->document_number) }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Fornecedor --}}
        <div>
            <label for="supplier_id" class="block text-sm font-medium text-gray-700">Fornecedor</label>
            <select name="supplier_id" id="supplier_id" required
                class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Selecione o fornecedor</option>
                @foreach ($suppliers as $supplier)
                    <option value="{{ $supplier->id }}"
                        {{ isset($contract) && $contract->supplier_id == $supplier->id ? 'selected' : '' }}>
                        {{ $supplier->name }} | {{ format_document($supplier->document_number) }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Adquirentes --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Adquirentes</label>

            <div class="mt-2 space-y-2">
                @foreach ($acquirers as $acquirer)
                    <label class="flex items-center">
                        <input type="checkbox" name="acquirers[]" value="{{ $acquirer->id }}"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                            {{ isset($contract) && $contract->acquirers->contains($acquirer->id) ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-gray-700">
                            {{ $acquirer->name }} | CNPJ: {{ format_document($acquirer->document_number) }}
                        </span>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Arranjos de Pagamento --}}
        <div>
            <span class="block text-sm font-medium text-gray-700">Arranjos de Pagamento</span>
            <div class="mt-2 flex flex-wrap gap-4">
                @foreach ($paymentArrangements as $arrangement)
                    <label class="flex items-center space-x-2 w-64 p-2 border border-gray-200 rounded">
                        <input type="checkbox" name="payment_arrangements[]" value="{{ $arrangement->id }}"
                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                            {{ isset($contract) && $contract->paymentArrangements->contains($arrangement->id) ? 'checked' : '' }}>
                        <span class="text-sm text-gray-700">
                            {{ $arrangement->name }} | {{ $arrangement->code }}
                        </span>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Modo de Operação --}}
        <div>
            <span class="block text-sm font-medium text-gray-700">Modo de Operação</span>
            <div class="mt-2 flex flex-col sm:flex-row gap-4">
                <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded w-80">
                    <input type="radio" name="is_automatic" value="1"
                        class="text-indigo-600 focus:ring-indigo-500"
                        {{ !isset($contract) || $contract->isAutomatic() ? 'checked' : '' }}>
                    <span class="text-sm text-gray-700">Automático (sistema realiza as operações)</span>
                </label>

                <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded w-80">
                    <input type="radio" name="is_automatic" value="0"
                        class="text-indigo-600 focus:ring-indigo-500"
                        {{ isset($contract) && !$contract->isAutomatic() ? 'checked' : '' }}>
                    <span class="text-sm text-gray-700">Manual (usuário realiza as operações)</span>
                </label>
            </div>
        </div>


        {{-- Tipo de Negociação --}}
        <div>
            <span class="block text-sm font-medium text-gray-700">Tipo de Negociação</span>
            <div class="mt-2 flex flex-col sm:flex-row gap-4">
                <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded w-80">
                    <input type="radio" name="negotiation_type"
                        value="{{ \App\Enums\NegotiationType::GRAVAME->value }}"
                        class="text-indigo-600 focus:ring-indigo-500"
                        {{ isset($contract) && $contract->negotiation_type === \App\Enums\NegotiationType::GRAVAME->value ? 'checked' : '' }}>
                    <span class="text-sm text-gray-700">Gravame</span>
                </label>

                <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded w-80">
                    <input type="radio" name="negotiation_type"
                        value="{{ \App\Enums\NegotiationType::CESSAO->value }}"
                        class="text-indigo-600 focus:ring-indigo-500"
                        {{ isset($contract) && $contract->negotiation_type === \App\Enums\NegotiationType::CESSAO->value ? 'checked' : '' }}>
                    <span class="text-sm text-gray-700">Cessão</span>
                </label>
            </div>
        </div>

        {{-- Valor --}}
        <div id="value-field">
            <label for="value" class="block text-sm font-medium text-gray-700">Valor</label>
            <input type="number" step="0.01" name="value" id="value"
                value="{{ $contract->value ?? old('value') }}" required
                class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>

        {{-- Datas --}}
        <div>
            <label for="start_date" class="block text-sm font-medium text-gray-700">Data Início</label>
            <input type="date" name="start_date" id="start_date"
                value="{{ $contract->start_date ?? old('start_date') }}" required
                class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>

        <div>
            <label for="end_date" class="block text-sm font-medium text-gray-700">Data Fim</label>
            <input type="date" name="end_date" id="end_date" value="{{ $contract->end_date ?? old('end_date') }}"
                class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>

        <div class="flex justify-end space-x-3">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                {{ isset($contract) ? 'Atualizar' : 'Salvar' }}
            </button>
        </div>
    </form>

    {{-- Script para exibir/ocultar campo Valor --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const radios = document.querySelectorAll('input[name="is_automatic"]');
            const valueField = document.getElementById('value-field');
            const valueInput = document.getElementById('value');
            const negotiationField = document.querySelector('input[name="negotiation_type"]').closest('div');

            function toggleFields() {
                const selected = document.querySelector('input[name="is_automatic"]:checked');
                const isManual = selected && selected.value === '0';

                if (isManual) {
                    valueField.classList.add('hidden');
                    negotiationField.classList.add('hidden');
                    valueInput.removeAttribute('required');
                    valueInput.value = '';
                } else {
                    valueField.classList.remove('hidden');
                    negotiationField.classList.remove('hidden');
                    valueInput.setAttribute('required', 'required');
                }
            }

            toggleFields();

            radios.forEach(radio => {
                radio.addEventListener('change', toggleFields);
            });
        });
    </script>



</x-app-layout>

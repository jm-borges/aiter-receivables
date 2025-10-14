<x-app-layout>

    <x-slot name="header">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold mb-6">
                {{ isset($contract) ? 'Editar Contrato' : 'Novo Contrato' }}
            </h1>

            <div class="mb-4">
                <a href="{{ route('contracts.index') }}"
                    class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition">
                    Voltar
                </a>
            </div>
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
                        {{ $client->name }}
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
                        {{ $supplier->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Adquirentes --}}
        <div>
            <label for="acquirers" class="block text-sm font-medium text-gray-700">Adquirentes</label>
            <select name="acquirers[]" id="acquirers" multiple
                class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @foreach ($acquirers as $acquirer)
                    <option value="{{ $acquirer->id }}"
                        {{ isset($contract) && $contract->acquirers->contains($acquirer->id) ? 'selected' : '' }}>
                        {{ $acquirer->name }}
                    </option>
                @endforeach
            </select>
            <p class="text-xs text-gray-500 mt-1">Segure Ctrl (ou Cmd) para selecionar múltiplos.</p>
        </div>

        {{-- Arranjos de Pagamento --}}
        <div>
            <span class="block text-sm font-medium text-gray-700">Arranjos de Pagamento</span>
            <div class="mt-2 flex flex-wrap gap-4">
                @foreach ($paymentArrangements as $arrangement)
                    <label class="inline-flex items-center space-x-2">
                        <input type="checkbox" name="payment_arrangements[]" value="{{ $arrangement->id }}"
                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                            {{ isset($contract) && $contract->paymentArrangements->contains($arrangement->id) ? 'checked' : '' }}>
                        <span>{{ $arrangement->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Valor --}}
        <div>
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

</x-app-layout>

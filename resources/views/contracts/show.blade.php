<x-app-layout>

    <x-slot name="header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h1 class="text-2xl font-bold text-custom-blue-hover mb-6">
                Detalhes do Contrato #{{ $contract->id }}</h1>
            <a href="{{ route('contracts.edit', $contract) }}"
                class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
                Editar
            </a>
            <a href="{{ route('contracts.index') }}"
                class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">
                Voltar
            </a>
        </div>
    </x-slot>

    {{-- Informações principais --}}
    <div class="overflow-x-auto bg-white shadow-md rounded-lg mb-8">
        <table class="w-full border border-gray-200">
            <tbody class="divide-y divide-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left bg-gray-100 font-semibold text-gray-700">Cliente</th>
                    <td class="px-4 py-3">{{ $contract->client?->name ?? '—' }}</td>
                </tr>
                <tr>
                    <th class="px-4 py-3 text-left bg-gray-100 font-semibold text-gray-700">Fornecedor</th>
                    <td class="px-4 py-3">{{ $contract->supplier?->name ?? '—' }}</td>
                </tr>
                <tr>
                    <th class="px-4 py-3 text-left bg-gray-100 font-semibold text-gray-700">Adquirentes</th>
                    <td class="px-4 py-3">
                        @if ($contract->acquirers->isEmpty())
                            —
                        @else
                            {{ $contract->acquirers->pluck('name')->join(', ') }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="px-4 py-3 text-left bg-gray-100 font-semibold text-gray-700">Valor</th>
                    <td class="px-4 py-3">{{ $contract->value }}</td>
                </tr>
                <tr>
                    <th class="px-4 py-3 text-left bg-gray-100 font-semibold text-gray-700">Data Início</th>
                    <td class="px-4 py-3">{{ $contract->start_date }}</td>
                </tr>
                <tr>
                    <th class="px-4 py-3 text-left bg-gray-100 font-semibold text-gray-700">Data Fim</th>
                    <td class="px-4 py-3">{{ $contract->end_date ?? '—' }}</td>
                </tr>
                <tr>
                    <th class="px-4 py-3 text-left bg-gray-100 font-semibold text-gray-700">Arranjos de Pagamento</th>
                    <td class="px-4 py-3">
                        @if ($contract->paymentArrangements->isEmpty())
                            —
                        @else
                            {{ $contract->paymentArrangements->pluck('name')->join(', ') }}
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Recebíveis associados --}}
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Recebíveis</h2>
    @if ($contract->receivables->isEmpty())
        <p class="text-gray-500">Nenhum recebível registrado.</p>
    @else
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="w-full border border-gray-200">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">ID</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Descrição</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Acquirer</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Data</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Valor</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($contract->receivables as $receivable)
                        <tr>
                            <td class="px-4 py-3">{{ $receivable->id }}</td>
                            <td class="px-4 py-3">{{ $receivable->tpObj }}</td>
                            <td class="px-4 py-3">{{ $receivable->acquirer?->name ?? '—' }}</td>
                            <td class="px-4 py-3">{{ $receivable->dtPrevtLiquid }}</td>
                            <td class="px-4 py-3">{{ $receivable->vlrTot }}</td>
                            <td class="px-4 py-3">{{ $receivable->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</x-app-layout>

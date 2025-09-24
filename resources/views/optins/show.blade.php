@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Detalhes do Opt-In</h1>

        {{-- Informações principais --}}
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Informações do Opt-In</h2>
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
                <div>
                    <dt class="text-sm font-medium text-gray-600">Identificador</dt>
                    <dd class="mt-1">{{ $optIn->unique_identifier ?? $optIn->id }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-600">Status</dt>
                    <dd class="mt-1">
                        <span
                            class="
                                @if ($optIn->status === \App\Enums\OptInStatus::ACTIVE) text-green-600 font-semibold
                                @elseif($optIn->status === \App\Enums\OptInStatus::OPTED_OUT) text-red-600 font-semibold
                                @elseif($optIn->status === \App\Enums\OptInStatus::PENDING) text-yellow-600 font-semibold
                                @else text-gray-600 @endif
                            ">
                            {{ $optIn->status->label() }}
                        </span>
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-600">Data do Opt-In</dt>
                    <dd class="mt-1">{{ $optIn->dtOptIn?->format('d/m/Y H:i') ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-600">Início da Vigência</dt>
                    <dd class="mt-1">{{ $optIn->dtIniOptIn?->format('d/m/Y') ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-600">Fim da Vigência</dt>
                    <dd class="mt-1">{{ $optIn->dtFimOptIn?->format('d/m/Y') ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-600">CNPJ Financiadora</dt>
                    <dd class="mt-1">{{ $optIn->cnpj_financiadora ?? '—' }}</dd>
                </div>
            </dl>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Cliente --}}
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Cliente (EC)</h2>
                @if ($optIn->client)
                    <p><span class="font-medium text-gray-700">Nome:</span> {{ $optIn->client->name }}</p>
                    <p><span class="font-medium text-gray-700">CNPJ:</span> {{ $optIn->client->document_number }}</p>
                    <p><span class="font-medium text-gray-700">Email:</span> {{ $optIn->client->email ?? '—' }}</p>
                    <p><span class="font-medium text-gray-700">Telefone:</span> {{ $optIn->client->phone ?? '—' }}</p>
                @else
                    <p class="text-gray-500">Não informado.</p>
                @endif
            </div>

            {{-- Adquirente --}}
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Adquirente</h2>
                @if ($optIn->acquirer)
                    <p><span class="font-medium text-gray-700">Nome:</span> {{ $optIn->acquirer->name }}</p>
                    <p><span class="font-medium text-gray-700">CNPJ:</span> {{ $optIn->acquirer->document_number }}</p>
                @else
                    <p class="text-gray-500">Não informado.</p>
                @endif
            </div>
        </div>

        {{-- Arranjo de Pagamento --}}
        <div class="bg-white shadow-md rounded-lg p-6 mt-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Arranjo de Pagamento</h2>
            @if ($optIn->paymentArrangement)
                <p><span class="font-medium text-gray-700">Nome:</span> {{ $optIn->paymentArrangement->name }}</p>
                <p><span class="font-medium text-gray-700">Código:</span> {{ $optIn->paymentArrangement->code }}</p>
            @else
                <p class="text-gray-500">Não informado.</p>
            @endif
        </div>

        {{-- Contrato --}}
        <div class="bg-white shadow-md rounded-lg p-6 mt-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Contrato Relacionado</h2>
            @if ($optIn->contract)
                <p><span class="font-medium text-gray-700">ID:</span> {{ $optIn->contract->id }}</p>
                <p><span class="font-medium text-gray-700">Valor:</span> R$
                    {{ number_format($optIn->contract->value, 2, ',', '.') }}</p>
                <p><span class="font-medium text-gray-700">Início:</span>
                    {{ $optIn->contract->start_date?->format('d/m/Y') }}</p>
                <p><span class="font-medium text-gray-700">Fim:</span>
                    {{ $optIn->contract->end_date?->format('d/m/Y') ?? '—' }}</p>
            @else
                <p class="text-gray-500">Não informado.</p>
            @endif
        </div>

        {{-- Recebíveis --}}
        <div class="bg-white shadow-md rounded-lg p-6 mt-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Recebíveis</h2>
            @if ($optIn->receivables->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="w-full border border-gray-200 rounded-lg">
                        <thead class="bg-gray-100 border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">ID</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Valor</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Data Prevista</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Arranjo</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($optIn->receivables as $receivable)
                                <tr>
                                    <td class="px-4 py-3">{{ $receivable->id }}</td>
                                    <td class="px-4 py-3">R$ {{ number_format($receivable->vlrTot, 2, ',', '.') }}</td>
                                    <td class="px-4 py-3">{{ $receivable->dtPrevtLiquid?->format('d/m/Y') ?? '—' }}</td>
                                    <td class="px-4 py-3">{{ $receivable->paymentArrangement?->code ?? '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500">Nenhum recebível vinculado.</p>
            @endif
        </div>
    </div>
@endsection

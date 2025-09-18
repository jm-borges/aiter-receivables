@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-6">
        <h1 class="text-2xl font-bold mb-6">Detalhes do Opt-In</h1>

        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h2 class="text-lg font-semibold mb-4">Informações do Opt-In</h2>
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
                <div>
                    <dt class="font-medium text-gray-600">Identificador</dt>
                    <dd>{{ $optIn->unique_identifier ?? $optIn->id }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-600">Status</dt>
                    <dd>
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
                    <dt class="font-medium text-gray-600">Data do Opt-In</dt>
                    <dd>{{ $optIn->dtOptIn?->format('d/m/Y H:i') ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-600">Início da Vigência</dt>
                    <dd>{{ $optIn->dtIniOptIn?->format('d/m/Y') ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-600">Fim da Vigência</dt>
                    <dd>{{ $optIn->dtFimOptIn?->format('d/m/Y') ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-600">CNPJ Financiadora</dt>
                    <dd>{{ $optIn->cnpj_financiadora ?? '—' }}</dd>
                </div>
            </dl>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Cliente --}}
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold mb-4">Cliente (EC)</h2>
                @if ($optIn->client)
                    <p><strong>Nome:</strong> {{ $optIn->client->name }}</p>
                    <p><strong>CNPJ:</strong> {{ $optIn->client->document_number }}</p>
                    <p><strong>Email:</strong> {{ $optIn->client->email ?? '—' }}</p>
                    <p><strong>Telefone:</strong> {{ $optIn->client->phone ?? '—' }}</p>
                @else
                    <p class="text-gray-500">Não informado.</p>
                @endif
            </div>

            {{-- Adquirente --}}
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold mb-4">Adquirente</h2>
                @if ($optIn->acquirer)
                    <p><strong>Nome:</strong> {{ $optIn->acquirer->name }}</p>
                    <p><strong>CNPJ:</strong> {{ $optIn->acquirer->document_number }}</p>
                @else
                    <p class="text-gray-500">Não informado.</p>
                @endif
            </div>
        </div>

        {{-- Arranjo de Pagamento --}}
        <div class="bg-white shadow rounded-lg p-6 mt-6">
            <h2 class="text-lg font-semibold mb-4">Arranjo de Pagamento</h2>
            @if ($optIn->paymentArrangement)
                <p><strong>Nome:</strong> {{ $optIn->paymentArrangement->name }}</p>
                <p><strong>Código:</strong> {{ $optIn->paymentArrangement->code }}</p>
            @else
                <p class="text-gray-500">Não informado.</p>
            @endif
        </div>

        {{-- Contrato --}}
        <div class="bg-white shadow rounded-lg p-6 mt-6">
            <h2 class="text-lg font-semibold mb-4">Contrato Relacionado</h2>
            @if ($optIn->contract)
                <p><strong>ID:</strong> {{ $optIn->contract->id }}</p>
                <p><strong>Valor:</strong> R$ {{ number_format($optIn->contract->value, 2, ',', '.') }}</p>
                <p><strong>Início:</strong> {{ $optIn->contract->start_date?->format('d/m/Y') }}</p>
                <p><strong>Fim:</strong> {{ $optIn->contract->end_date?->format('d/m/Y') ?? '—' }}</p>
            @else
                <p class="text-gray-500">Não informado.</p>
            @endif
        </div>

        {{-- Recebíveis --}}
        <div class="bg-white shadow rounded-lg p-6 mt-6">
            <h2 class="text-lg font-semibold mb-4">Recebíveis</h2>
            @if ($optIn->receivables->isNotEmpty())
                <table class="table-auto w-full border-collapse border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-2 py-1">ID</th>
                            <th class="border px-2 py-1">Valor</th>
                            <th class="border px-2 py-1">Data Prevista</th>
                            <th class="border px-2 py-1">Arranjo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($optIn->receivables as $receivable)
                            <tr>
                                <td class="border px-2 py-1">{{ $receivable->id }}</td>
                                <td class="border px-2 py-1">R$ {{ number_format($receivable->vlrTot, 2, ',', '.') }}</td>
                                <td class="border px-2 py-1">{{ $receivable->dtPrevtLiquid?->format('d/m/Y') ?? '—' }}</td>
                                <td class="border px-2 py-1">{{ $receivable->paymentArrangement?->code ?? '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-gray-500">Nenhum recebível vinculado.</p>
            @endif
        </div>
    </div>
@endsection

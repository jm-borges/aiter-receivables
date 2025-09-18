@extends('layouts.app')

@section('content')
    <h1 class="text-xl font-bold mb-4">Detalhes do Recebível</h1>

    <div class="bg-white shadow rounded p-4">
        <dl class="grid grid-cols-2 gap-x-4 gap-y-2">
            <div>
                <dt class="font-semibold">Identificador</dt>
                <dd>{{ $receivable->id }}</dd>
            </div>

            <div>
                <dt class="font-semibold">Contrato</dt>
                <dd>{{ $receivable->contract?->id ?? '—' }}</dd>
            </div>

            <div>
                <dt class="font-semibold">Cliente</dt>
                <dd>{{ $receivable->client?->name ?? '—' }} ({{ $receivable->client?->document_number ?? '—' }})</dd>
            </div>

            <div>
                <dt class="font-semibold">Adquirente</dt>
                <dd>{{ $receivable->acquirer?->name ?? '—' }} ({{ $receivable->acquirer?->document_number ?? '—' }})</dd>
            </div>

            <div>
                <dt class="font-semibold">Arranjo de Pagamento</dt>
                <dd>{{ $receivable->paymentArrangement?->name ?? '—' }} ({{ $receivable->codInstitdrArrajPgto ?? '—' }})
                </dd>
            </div>

            <div>
                <dt class="font-semibold">CNPJ ER</dt>
                <dd>{{ $receivable->cnpjER ?? '—' }}</dd>
            </div>

            <div>
                <dt class="font-semibold">CNPJ Credenciador Sub</dt>
                <dd>{{ $receivable->cnpjCreddrSub ?? '—' }}</dd>
            </div>

            <div>
                <dt class="font-semibold">CNPJ Usuário Final/Recebedor</dt>
                <dd>{{ $receivable->cnpjOuCnpjBaseOuCpfUsuFinalRecbdr ?? '—' }}</dd>
            </div>

            <div>
                <dt class="font-semibold">Valor Livre</dt>
                <dd>
                    {{ $receivable->vlrLivreUsuFinalRecbdr
                        ? 'R$ ' . number_format($receivable->vlrLivreUsuFinalRecbdr, 2, ',', '.')
                        : '—' }}
                </dd>
            </div>

            <div>
                <dt class="font-semibold">Valor Total</dt>
                <dd>
                    {{ $receivable->vlrTot ? 'R$ ' . number_format($receivable->vlrTot, 2, ',', '.') : '—' }}
                </dd>
            </div>

            <div>
                <dt class="font-semibold">Data Prevista Liquidação</dt>
                <dd>
                    {{ $receivable->dtPrevtLiquid ? \Carbon\Carbon::parse($receivable->dtPrevtLiquid)->format('d/m/Y') : '—' }}
                </dd>
            </div>

            <div>
                <dt class="font-semibold">Indicador Domicílio</dt>
                <dd>{{ $receivable->indrDomcl ?? '—' }}</dd>
            </div>
        </dl>
    </div>

    <div class="mt-6">
        <a href="{{ route('receivables.index') }}"
            class="bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600 transition">
            Voltar
        </a>
    </div>
@endsection

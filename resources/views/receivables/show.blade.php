<x-app-layout>

    <x-slot name="header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h1 class="text-2xl font-bold text-custom-blue-hover mb-6">Detalhes do Recebível</h1>
            <a href="{{ route('receivables.index') }}"
                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                Voltar
            </a>
        </div>
    </x-slot>

    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold mb-4">Informações do Recebível</h2>
        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
            <div>
                <dt class="font-medium text-gray-600">Identificador</dt>
                <dd class="mt-1 text-gray-800">{{ $receivable->id }}</dd>
            </div>

            <div>
                <dt class="font-medium text-gray-600">Contrato</dt>
                <dd class="mt-1 text-gray-800">{{ $receivable->contract?->id ?? '—' }}</dd>
            </div>

            <div>
                <dt class="font-medium text-gray-600">Cliente</dt>
                <dd class="mt-1 text-gray-800">
                    {{ $receivable->client?->name ?? '—' }}
                    ({{ format_document($receivable->client?->document_number ?? null) }})

                </dd>
            </div>

            <div>
                <dt class="font-medium text-gray-600">Adquirente</dt>
                <dd class="mt-1 text-gray-800">
                    {{ $receivable->acquirer?->name ?? '—' }}
                    ({{ format_document($receivable->acquirer?->document_number ?? null) }})

                </dd>
            </div>

            <div>
                <dt class="font-medium text-gray-600">Arranjo de Pagamento</dt>
                <dd class="mt-1 text-gray-800">
                    {{ $receivable->paymentArrangement?->name ?? '—' }}
                    ({{ $receivable->codInstitdrArrajPgto ?? '—' }})
                </dd>
            </div>

            <div>
                <dt class="font-medium text-gray-600">CNPJ ER</dt>
                <dd class="mt-1 text-gray-800">{{ format_document($receivable->cnpjER ?? null) }}</dd>

            </div>

            <div>
                <dt class="font-medium text-gray-600">CNPJ Credenciador Sub</dt>
                <dd class="mt-1 text-gray-800">{{ format_document($receivable->cnpjCreddrSub ?? null) }}</dd>

            </div>

            <div>
                <dt class="font-medium text-gray-600">CNPJ Usuário Final/Recebedor</dt>
                <dd class="mt-1 text-gray-800">
                    {{ format_document($receivable->cnpjOuCnpjBaseOuCpfUsuFinalRecbdr ?? null) }}
                </dd>
            </div>

            <div>
                <dt class="font-medium text-gray-600">Valor Livre</dt>
                <dd class="mt-1 text-gray-800">
                    {{ $receivable->vlrLivreUsuFinalRecbdr
                        ? 'R$ ' . number_format($receivable->vlrLivreUsuFinalRecbdr, 2, ',', '.')
                        : '—' }}
                </dd>
            </div>

            <div>
                <dt class="font-medium text-gray-600">Valor Total</dt>
                <dd class="mt-1 text-gray-800">
                    {{ $receivable->vlrTot ? 'R$ ' . number_format($receivable->vlrTot, 2, ',', '.') : '—' }}
                </dd>
            </div>

            <div>
                <dt class="font-medium text-gray-600">Data Prevista Liquidação</dt>
                <dd class="mt-1 text-gray-800">
                    {{ $receivable->dtPrevtLiquid ? \Carbon\Carbon::parse($receivable->dtPrevtLiquid)->format('d/m/Y') : '—' }}
                </dd>
            </div>

            <div>
                <dt class="font-medium text-gray-600">Indicador Domicílio</dt>
                <dd class="mt-1 text-gray-800">{{ $receivable->indrDomcl ?? '—' }}</dd>
            </div>
        </dl>
    </div>


</x-app-layout>

<x-app-layout>

    <x-slot name="header">
        <x-page-header title="Recebíveis" />
    </x-slot>

    <div class="overflow-x-auto">
        <table class="table-auto w-full border border-gray-200 rounded">
            <thead>
                <tr class="bg-gray-100">
                    <th scope="col" class="border px-4 py-2 text-left">Identificador</th>
                    <th scope="col" class="border px-4 py-2 text-left">CNPJ do Cliente</th>
                    <th scope="col" class="border px-4 py-2 text-left">CNPJ do Adquirente</th>
                    <th scope="col" class="border px-4 py-2 text-left">Arranjo de Pagamento</th>
                    <th scope="col" class="border px-4 py-2 text-left">Valor Total</th>
                    <th scope="col" class="border px-4 py-2 text-left">Data Prevista Liquidação</th>
                    <th scope="col" class="border px-4 py-2 text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($receivables as $receivable)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2">{{ $receivable->id }}</td>
                        <td class="border px-4 py-2">{{ $receivable->client?->document_number ?? '—' }}</td>
                        <td class="border px-4 py-2">{{ $receivable->acquirer?->document_number ?? '—' }}</td>
                        <td class="border px-4 py-2">
                            {{ $receivable->paymentArrangement?->name ?? ($receivable->codInstitdrArrajPgto ?? '—') }}
                        </td>
                        <td class="border px-4 py-2">
                            R$ {{ number_format($receivable->vlrTot, 2, ',', '.') }}
                        </td>
                        <td class="border px-4 py-2">
                            {{ $receivable->dtPrevtLiquid?->format('d/m/Y') ?? '—' }}
                        </td>
                        <td class="border px-4 py-2 text-center">
                            <a href="{{ route('receivables.show', $receivable->id) }}"
                                class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">
                                Detalhes
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="border px-4 py-4 text-center text-gray-600">
                            Nenhum recebível encontrado
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $receivables->links() }}
    </div>
</x-app-layout>

@extends('layouts.app')

@section('content')
    <h1 class="text-xl font-bold mb-4">Recebíveis</h1>

    <table class="table-auto w-full border-collapse border">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-2 py-1">Identificador</th>
                <th class="border px-2 py-1">CNPJ do Cliente</th>
                <th class="border px-2 py-1">CNPJ do Adquirente</th>
                <th class="border px-2 py-1">Arranjo de Pagamento</th>
                <th class="border px-2 py-1">Valor Total</th>
                <th class="border px-2 py-1">Data Prevista Liquidação</th>
                <th class="border px-2 py-1">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($receivables as $receivable)
                <tr>
                    <td class="border px-2 py-1">{{ $receivable->id }}</td>
                    <td class="border px-2 py-1">{{ $receivable->client?->document_number ?? '—' }}</td>
                    <td class="border px-2 py-1">{{ $receivable->acquirer?->document_number ?? '—' }}</td>
                    <td class="border px-2 py-1">
                        {{ $receivable->paymentArrangement?->name ?? ($receivable->codInstitdrArrajPgto ?? '—') }}</td>
                    <td class="border px-2 py-1">
                        R$ {{ number_format($receivable->vlrTot, 2, ',', '.') }}
                    </td>
                    <td class="border px-2 py-1">
                        {{ $receivable->dtPrevtLiquid ? \Carbon\Carbon::parse($receivable->dtPrevtLiquid)->format('d/m/Y') : '—' }}
                    </td>
                    <td class="border px-2 py-1 text-center">
                        <a href="{{ route('receivables.show', $receivable->id) }}"
                            class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">
                            Detalhes
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="border px-2 py-2 text-center text-gray-600">
                        Nenhum recebível encontrado
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $receivables->links() }}
    </div>
@endsection

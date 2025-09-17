{{-- resources/views/contracts/show.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Detalhes do Contrato #{{ $contract->id }}</h1>

        <div class="mb-3">
            <a href="{{ route('contracts.edit', $contract) }}" class="btn btn-warning">Editar</a>
            <a href="{{ route('contracts.index') }}" class="btn btn-secondary">Voltar</a>
        </div>

        {{-- Informações principais --}}
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th>Cliente</th>
                    <td>{{ $contract->client?->name ?? '—' }}</td>
                </tr>
                <tr>
                    <th>Fornecedor</th>
                    <td>{{ $contract->supplier?->name ?? '—' }}</td>
                </tr>
                <tr>
                    <th>Adquirentes</th>
                    <td>
                        @if ($contract->acquirers->isEmpty())
                            —
                        @else
                            {{ $contract->acquirers->pluck('name')->join(', ') }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Valor</th>
                    <td>{{ $contract->value }}</td>
                </tr>
                <tr>
                    <th>Data Início</th>
                    <td>{{ $contract->start_date }}</td>
                </tr>
                <tr>
                    <th>Data Fim</th>
                    <td>{{ $contract->end_date ?? '—' }}</td>
                </tr>
                <tr>
                    <th>Arranjos de Pagamento</th>
                    <td>
                        @if ($contract->paymentArrangements->isEmpty())
                            —
                        @else
                            {{ $contract->paymentArrangements->pluck('name')->join(', ') }}
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- Recebíveis associados --}}
        <h4>Recebíveis</h4>
        @if ($contract->receivables->isEmpty())
            <p>Nenhum recebível registrado.</p>
        @else
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Descrição</th>
                        <th>Acquirer</th>
                        <th>Data</th>
                        <th>Valor</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contract->receivables as $receivable)
                        <tr>
                            <td>{{ $receivable->id }}</td>
                            <td>{{ $receivable->tpObj }}</td>
                            <td>{{ $receivable->acquirer?->name ?? '—' }}</td>
                            <td>{{ $receivable->dtPrevtLiquid }}</td>
                            <td>{{ $receivable->vlrTot }}</td>
                            <td>{{ $receivable->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection

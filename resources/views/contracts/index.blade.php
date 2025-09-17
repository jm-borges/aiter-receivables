@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Contratos</h1>

        <div class="mb-3">
            <a href="{{ route('contracts.create') }}" class="btn btn-success">Novo Contrato</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($contracts->isEmpty())
            <p>Nenhum contrato registrado.</p>
        @else
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Fornecedor</th>
                        <th>Adquirentes</th>
                        <th>Valor</th>
                        <th>Início</th>
                        <th>Fim</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contracts as $contract)
                        <tr>
                            <td>{{ $contract->id }}</td>
                            <td>{{ $contract->client?->name ?? '—' }}</td>
                            <td>{{ $contract->supplier?->name ?? '—' }}</td>
                            <td>
                                @if ($contract->acquirers->isEmpty())
                                    —
                                @else
                                    {{ $contract->acquirers->pluck('name')->join(', ') }}
                                @endif
                            </td>
                            <td>{{ $contract->value }}</td>
                            <td>{{ $contract->start_date }}</td>
                            <td>{{ $contract->end_date }}</td>
                            <td>
                                <a href="{{ route('contracts.show', $contract) }}" class="btn btn-info btn-sm">Ver</a>
                                <a href="{{ route('contracts.edit', $contract) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('contracts.destroy', $contract) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Tem certeza que deseja excluir este contrato?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Paginação --}}
            <div class="mt-3">
                {{ $contracts->links() }}
            </div>
        @endif
    </div>
@endsection

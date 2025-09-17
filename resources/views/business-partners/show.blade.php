{{-- resources/views/business-partners/show.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Detalhes do Parceiro</h1>

        <div class="mb-3">
            <a href="{{ route('business-partners.edit', $businessPartner) }}" class="btn btn-warning">Editar</a>
            <a href="{{ route('business-partners.index') }}" class="btn btn-secondary">Voltar</a>
        </div>

        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th>Nome</th>
                    <td>{{ $businessPartner->name }}</td>
                </tr>
                <tr>
                    <th>Nome Fantasia</th>
                    <td>{{ $businessPartner->fantasy_name }}</td>
                </tr>
                <tr>
                    <th>Tipo</th>
                    <td>{{ $businessPartner->type->label() }}</td>
                </tr>
                <tr>
                    <th>Documento</th>
                    <td>{{ $businessPartner->document_number }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $businessPartner->email }}</td>
                </tr>
                <tr>
                    <th>Telefone</th>
                    <td>{{ $businessPartner->phone }}</td>
                </tr>
            </tbody>
        </table>

        <h4>Endereço</h4>
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th>CEP</th>
                    <td>{{ $businessPartner->postal_code }}</td>
                </tr>
                <tr>
                    <th>Rua</th>
                    <td>{{ $businessPartner->address }}</td>
                </tr>
                <tr>
                    <th>Número</th>
                    <td>{{ $businessPartner->address_number }}</td>
                </tr>
                <tr>
                    <th>Complemento</th>
                    <td>{{ $businessPartner->address_complement }}</td>
                </tr>
                <tr>
                    <th>Bairro</th>
                    <td>{{ $businessPartner->address_neighborhood }}</td>
                </tr>
                <tr>
                    <th>Cidade</th>
                    <td>{{ $businessPartner->address_city }}</td>
                </tr>
                <tr>
                    <th>Estado</th>
                    <td>{{ $businessPartner->address_state }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Contratos --}}
    <h4>Contratos</h4>
    @php
        $contracts = $businessPartner->contracts;
    @endphp

    @if ($contracts->isEmpty())
        <p>Nenhum contrato registrado.</p>
    @else
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Fornecedor</th>
                    <th>Valor</th>
                    <th>Início</th>
                    <th>Fim</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contracts as $contract)
                    <tr>
                        <td>{{ $contract->id }}</td>
                        <td>{{ $contract->client->name }}</td>
                        <td>{{ $contract->supplier->name }}</td>
                        <td>{{ $contract->value }}</td>
                        <td>{{ $contract->start_date }}</td>
                        <td>{{ $contract->end_date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- Recebíveis --}}
    <h4>Recebíveis</h4>
    @if ($businessPartner->receivables->isEmpty())
        <p>Nenhum recebível registrado.</p>
    @else
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descrição</th>
                    <th>Contrato</th>
                    <th>Data</th>
                    <th>Valor</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($businessPartner->receivables as $receivable)
                    <tr>
                        <td>{{ $receivable->id }}</td>
                        <td>{{ $receivable->tpObj }}</td>
                        <td>
                            @if ($receivable->contract)
                                {{ $receivable->contract->id }}
                            @else
                                —
                            @endif
                        </td>
                        <td>{{ $receivable->dtPrevtLiquid }}</td>
                        <td>{{ $receivable->vlrTot }}</td>
                        <td>{{ $receivable->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

@endsection

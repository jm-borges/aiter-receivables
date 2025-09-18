@extends('layouts.app')

@section('content')
    <div>
        <div>
            <div class="mb-4">
                <h2 class="text-xl font-semibold">Gerenciar Operações</h2>
            </div>

            <div>
                <table class="table-auto w-full border-collapse border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-2 py-1">Status</th>
                            <th class="border px-2 py-1">CNPJ ER</th>
                            <th class="border px-2 py-1">Identd Negc Recbvl</th>
                            <th class="border px-2 py-1">Identd Op</th>
                            <th class="border px-2 py-1">Tipo Negociação</th>
                            <th class="border px-2 py-1">Vencimento</th>
                            <th class="border px-2 py-1">Valor Total / Saldo</th>
                            <th class="border px-2 py-1">Valor Garantia</th>
                            <th class="border px-2 py-1">Situação</th>
                            <th class="border px-2 py-1">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($operations as $operation)
                            <tr>
                                <td class="border px-2 py-1">{{ $operation->status }}</td>
                                <td class="border px-2 py-1">{{ $operation->cnpjER }}</td>
                                <td class="border px-2 py-1">{{ $operation->identdNegcRecbvl }}</td>
                                <td class="border px-2 py-1">{{ $operation->identdOp }}</td>
                                <td class="border px-2 py-1">{{ $operation->indrTpNegc }}</td>
                                <td class="border px-2 py-1">
                                    {{ $operation->dtVencOp?->format('d/m/Y') }}
                                </td>
                                <td class="border px-2 py-1">
                                    R$ {{ number_format($operation->vlrTotLimOuSldDevdr, 2, ',', '.') }}
                                </td>
                                <td class="border px-2 py-1">
                                    R$ {{ number_format($operation->vlrGar, 2, ',', '.') }}
                                </td>
                                <td class="border px-2 py-1">{{ $operation->indrSitOp }}</td>
                                <td class="border px-2 py-1">
                                    <a href="{{ route('operations.show', $operation->id) }}"
                                        class="text-blue-600 underline">
                                        Ver
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="border px-2 py-2 text-center text-gray-600">
                                    Ainda não há operações
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <hr>
    @endsection

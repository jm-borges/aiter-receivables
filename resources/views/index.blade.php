@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto bg-white shadow-md rounded p-6">
        <h2 class="text-lg font-semibold mb-4">
            Solicitar Opt-in da Agenda de Recebíveis
        </h2>
        <form action="{{ route('opt-ins.store') }}" method="post" class="space-y-4">
            @csrf

            {{-- CNPJ do Estabelecimento Comercial --}}
            <div>
                <label for="cnpj_estabelecimento" class="block text-sm font-medium text-gray-700">
                    CNPJ do Estabelecimento Comercial
                </label>
                <input type="text" id="cnpj_estabelecimento" name="cnpjOuCnpjBaseOuCpfUsuFinalRecbdrOuTitlar"
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    placeholder="Digite o CNPJ" required>
            </div>

            {{-- CNPJ do Adquirente --}}
            <div>
                <label for="cnpj_adquirente" class="block text-sm font-medium text-gray-700">
                    CNPJ do Adquirente
                </label>
                <input type="text" id="cnpj_adquirente" name="cnpjCreddrSub"
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    placeholder="Digite o CNPJ" required>
            </div>

            {{-- Tipo de Pagamento/Cartão --}}
            <div>
                <label for="arranjo_pagamento" class="block text-sm font-medium text-gray-700">
                    Tipo de Pagamento/Cartão
                </label>
                <select id="arranjo_pagamento" name="codInstitdrArrajPgto"
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    required>
                    <option value="">Selecione...</option>
                    <option value="001">Visa Crédito</option>
                    <option value="002">Visa Débito</option>
                    <option value="003">Mastercard Crédito</option>
                    <option value="004">Mastercard Débito</option>
                    {{-- Adicionar outros arranjos conforme necessário --}}
                </select>
            </div>

            {{-- Botão --}}
            <div>
                <button type="submit"
                    class="w-full bg-indigo-600 text-white font-semibold px-4 py-2 rounded hover:bg-indigo-700 transition">
                    Solicitar Opt-in
                </button>
            </div>
        </form>
    </div>

    <hr>

    <div>
        <div class="mb-4">
            <h2 class="text-xl font-semibold">Gerenciar Opt-Ins</h2>
        </div>

        <div>
            <table class="table-auto w-full border-collapse border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-2 py-1">Identificador</th>
                        <th class="border px-2 py-1">CNPJ do EC</th>
                        <th class="border px-2 py-1">CNPJ do Adquirente</th>
                        <th class="border px-2 py-1">Arranjo de Pagamento</th>
                        <th class="border px-2 py-1">Status</th>
                        <th class="border px-2 py-1">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($optIns as $optIn)
                        <tr>
                            <td class="border px-2 py-1">{{ $optIn->unique_identifier }}</td>
                            <td class="border px-2 py-1">{{ $optIn->cnpj_estabelecimento_comercial }}</td>
                            <td class="border px-2 py-1">{{ $optIn->cnpj_adquirente ?? '—' }}</td>
                            <td class="border px-2 py-1">{{ $optIn->codInstitdrArrajPgto ?? '—' }}</td>
                            <td class="border px-2 py-1">
                                @switch($optIn->status)
                                    @case('opted-in')
                                        <span class="text-green-600 font-semibold">Ativo</span>
                                    @break

                                    @case('opted-out')
                                        <span class="text-red-600 font-semibold">Cancelado</span>
                                    @break

                                    @case('pending')
                                        <span class="text-yellow-600 font-semibold">Pendente</span>
                                    @break

                                    @default
                                        {{ ucfirst($optIn->status) }}
                                @endswitch
                            </td>
                            <td class="border px-2 py-1 text-center">
                                @if ($optIn->status === 'opted-in')
                                    <form action="{{ route('opt-ins.opt-out', $optIn->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">
                                            Cancelar
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="border px-2 py-2 text-center text-gray-600">
                                    Ainda não foram registrados Opt-Ins
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>

        <hr>

        <div>
            <div class="mb-4">
                <h2 class="text-xl font-semibold">Gerenciar Recebíveis</h2>
            </div>

            <div>
                <table class="table-auto w-full border-collapse border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-2 py-1">CNPJ Credor Sub</th>
                            <th class="border px-2 py-1">Usuário Final Recebedor</th>
                            <th class="border px-2 py-1">Instituidor Arranjo</th>
                            <th class="border px-2 py-1">Data Prevista Liquidação</th>
                            <th class="border px-2 py-1">Valor Total</th>
                            <th class="border px-2 py-1">Valor Livre Usuário Final</th>
                            <th class="border px-2 py-1">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($receivables as $receivable)
                            <tr>
                                <td class="border px-2 py-1">{{ $receivable->cnpjCreddrSub }}</td>
                                <td class="border px-2 py-1">{{ $receivable->cnpjOuCnpjBaseOuCpfUsuFinalRecbdr }}</td>
                                <td class="border px-2 py-1">{{ $receivable->codInstitdrArrajPgto }}</td>
                                <td class="border px-2 py-1">
                                    {{ $receivable->dtPrevtLiquid?->format('d/m/Y') }}
                                </td>
                                <td class="border px-2 py-1">
                                    R$ {{ number_format($receivable->vlrTot, 2, ',', '.') }}
                                </td>
                                <td class="border px-2 py-1">
                                    R$ {{ number_format($receivable->vlrLivreUsuFinalRecbdr, 2, ',', '.') }}
                                </td>
                                <td class="border px-2 py-1">
                                    <a href="{{ route('receivables.show', $receivable->id) }}" class="text-blue-600 underline">
                                        Ver
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="border px-2 py-2 text-center text-gray-600">
                                    Ainda não há recebíveis
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <hr>

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
                                    <a href="{{ route('operations.show', $operation->id) }}" class="text-blue-600 underline">
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

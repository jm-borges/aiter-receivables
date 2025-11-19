<x-app-layout>

    <x-slot name="header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h1 class="text-2xl font-bold text-custom-blue-hover mb-6">Detalhes do Parceiro</h1>
            <a href="{{ route('business-partners.edit', $businessPartner) }}"
                class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white text-sm font-medium rounded-md shadow hover:bg-yellow-600">
                Editar
            </a>
            <a href="/business-partners" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition">
                Voltar
            </a>
        </div>
    </x-slot>

    {{-- Dados principais --}}
    <div class="bg-white shadow rounded-lg mb-8">
        <table class="min-w-full divide-y divide-gray-200">
            <tbody class="divide-y divide-gray-200">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Nome</th>
                    <td class="px-4 py-2 text-sm text-gray-900">{{ $businessPartner->name }}</td>
                </tr>
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Nome Fantasia</th>
                    <td class="px-4 py-2 text-sm text-gray-900">{{ $businessPartner->fantasy_name }}</td>
                </tr>
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Tipo</th>
                    <td class="px-4 py-2 text-sm text-gray-900">{{ $businessPartner->type->label() }}</td>
                </tr>
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Documento</th>
                    <td class="px-4 py-2 text-sm text-gray-900">{{ $businessPartner->document_number }}</td>
                </tr>
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Email</th>
                    <td class="px-4 py-2 text-sm text-gray-900">{{ $businessPartner->email }}</td>
                </tr>
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Telefone</th>
                    <td class="px-4 py-2 text-sm text-gray-900">{{ $businessPartner->phone }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Endereço --}}
    <h2 class="text-lg font-semibold text-gray-800 mb-3">Endereço</h2>
    <div class="bg-white shadow rounded-lg mb-8">
        <table class="min-w-full divide-y divide-gray-200">
            <tbody class="divide-y divide-gray-200">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">CEP</th>
                    <td class="px-4 py-2 text-sm text-gray-900">{{ $businessPartner->postal_code }}</td>
                </tr>
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Rua</th>
                    <td class="px-4 py-2 text-sm text-gray-900">{{ $businessPartner->address }}</td>
                </tr>
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Número</th>
                    <td class="px-4 py-2 text-sm text-gray-900">{{ $businessPartner->address_number }}</td>
                </tr>
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Complemento</th>
                    <td class="px-4 py-2 text-sm text-gray-900">{{ $businessPartner->address_complement }}
                    </td>
                </tr>
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Bairro</th>
                    <td class="px-4 py-2 text-sm text-gray-900">
                        {{ $businessPartner->address_neighborhood }}</td>
                </tr>
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Cidade</th>
                    <td class="px-4 py-2 text-sm text-gray-900">{{ $businessPartner->address_city }}</td>
                </tr>
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Estado</th>
                    <td class="px-4 py-2 text-sm text-gray-900">{{ $businessPartner->address_state }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Contratos --}}
    <h2 class="text-lg font-semibold text-gray-800 mb-3">Contratos</h2>
    @if (
        $businessPartner->clientContracts->isEmpty() &&
            $businessPartner->supplierContracts->isEmpty() &&
            $businessPartner->acquirerContracts->isEmpty())
        <p class="text-sm text-gray-500">Nenhum contrato registrado.</p>
    @else
        <div class="overflow-x-auto bg-white shadow rounded-lg mb-8">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">ID</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Cliente</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Fornecedor</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Valor</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Início</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Fim</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @php
                        $contracts = match ($businessPartner->type) {
                            \App\Enums\BusinessPartnerType::CLIENT => $businessPartner->clientContracts,
                            \App\Enums\BusinessPartnerType::SUPPLIER => $businessPartner->supplierContracts,
                            \App\Enums\BusinessPartnerType::ACQUIRER => $businessPartner->acquirerContracts,
                        };
                    @endphp

                    @foreach ($contracts as $contract)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $contract->id }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $contract->client->name ?? '-' }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $contract->supplier->name ?? '-' }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $contract->value }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $contract->start_date }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $contract->end_date }}</td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    @endif

    {{-- Recebíveis --}}
    <h2 class="text-lg font-semibold text-gray-800 mb-3">Recebíveis</h2>
    @if ($businessPartner->clientReceivables->isEmpty() && $businessPartner->acquirerReceivables->isEmpty())
        <p class="text-sm text-gray-500">Nenhum recebível registrado.</p>
    @else
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">ID</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Descrição</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Contrato</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Data</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Valor</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Status</th>
                    </tr>
                </thead>
                @php
                    $receivables = match ($businessPartner->type) {
                        \App\Enums\BusinessPartnerType::CLIENT => $businessPartner->clientReceivables,
                        \App\Enums\BusinessPartnerType::ACQUIRER => $businessPartner->acquirerReceivables,
                        default => collect(),
                    };
                @endphp

                <tbody class="divide-y divide-gray-200">
                    @foreach ($receivables as $receivable)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $receivable->id }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $receivable->tpObj }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $receivable->contract->id ?? '—' }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $receivable->dtPrevtLiquid }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $receivable->vlrTot }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $receivable->status }}</td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    @endif
</x-app-layout>

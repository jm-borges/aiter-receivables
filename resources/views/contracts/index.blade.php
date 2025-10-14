<x-app-layout>

    <x-slot name="header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold mb-6">Contratos</h1>

            <div class="mb-4">
                <a href="{{ route('contracts.create') }}"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                    Novo Contrato
                </a>
            </div>
        </div>
    </x-slot>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 border border-green-300 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if ($contracts->isEmpty())
        <p class="text-gray-600">Nenhum contrato registrado.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 bg-white rounded shadow">
                <thead class="bg-gray-100 text-left text-sm font-medium text-gray-700">
                    <tr>
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">Cliente</th>
                        <th class="px-4 py-2 border">Fornecedor</th>
                        <th class="px-4 py-2 border">Adquirentes</th>
                        <th class="px-4 py-2 border">Valor</th>
                        <th class="px-4 py-2 border">Início</th>
                        <th class="px-4 py-2 border">Fim</th>
                        <th class="px-4 py-2 border text-center">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    @foreach ($contracts as $contract)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border">{{ $contract->id }}</td>
                            <td class="px-4 py-2 border">{{ $contract->client?->name ?? '—' }}</td>
                            <td class="px-4 py-2 border">{{ $contract->supplier?->name ?? '—' }}</td>
                            <td class="px-4 py-2 border">
                                @if ($contract->acquirers->isEmpty())
                                    —
                                @else
                                    {{ $contract->acquirers->pluck('name')->join(', ') }}
                                @endif
                            </td>
                            <td class="px-4 py-2 border">{{ $contract->value }}</td>
                            <td class="px-4 py-2 border">{{ $contract->start_date }}</td>
                            <td class="px-4 py-2 border">{{ $contract->end_date }}</td>
                            <td class="px-4 py-2 border text-center space-x-2">
                                <a href="{{ route('contracts.show', $contract) }}"
                                    class="px-3 py-1 bg-blue-600 text-white rounded text-xs hover:bg-blue-700 transition">
                                    Ver
                                </a>
                                <a href="{{ route('contracts.edit', $contract) }}"
                                    class="px-3 py-1 bg-yellow-500 text-white rounded text-xs hover:bg-yellow-600 transition">
                                    Editar
                                </a>
                                <form action="{{ route('contracts.destroy', $contract) }}" method="POST"
                                    class="inline"
                                    onsubmit="return confirm('Tem certeza que deseja excluir este contrato?');">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        class="px-3 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700 transition">
                                        Excluir
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Paginação --}}
        <div class="mt-4">
            {{ $contracts->links() }}
        </div>
    @endif
</x-app-layout>

<x-app-layout>

    <x-slot name="header">
        <div class="max-w-7xl  px-4 sm:px-6 lg:px-8 py-6" style="display: flex">
            <h1 class="font-bold text-white mb-2" style="font-size: 32px">Pagamento</h1>
            <a href="{{ route('contract-payments.create') }}" style="height: 35px; margin-left:15px;margin-top: 8px"
                class="inline-flex items-center px-4 bg-[#69549F] border border-transparent rounded-md
                          font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700
                          focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                Novo usuário
            </a>
        </div>
    </x-slot>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 border border-green-300 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if ($contractPayments->isEmpty())
        <p class="text-white">Nenhum pagamento registrado.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 bg-white rounded shadow">
                <thead class="bg-gray-100 text-left text-sm font-medium text-gray-700">
                    <tr>
                        <th class="px-4 py-2 border">ID</th>

                        <th class="px-4 py-2 border text-center">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    @foreach ($contractPayments as $payment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border">{{ $payment->id }}</td>

                            <td class="px-4 py-2 border text-center space-x-2">
                                <a href="{{ route('contract-payments.show', $payment) }}"
                                    class="px-3 py-1 bg-blue-600 text-white rounded text-xs hover:bg-blue-700 transition">
                                    Ver
                                </a>
                                <a href="{{ route('contract-payments.edit', $payment) }}"
                                    class="px-3 py-1 bg-yellow-500 text-white rounded text-xs hover:bg-yellow-600 transition">
                                    Editar
                                </a>
                                <form action="{{ route('contract-payments.destroy', $payment) }}" method="POST"
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
            {{ $contractPayments->links() }}
        </div>
    @endif
</x-app-layout>

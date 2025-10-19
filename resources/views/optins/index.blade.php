<x-app-layout>

    <x-slot name="header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Opt-Ins</h1>
        </div>
    </x-slot>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="w-full border border-gray-200">
            <thead class="bg-gray-100 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Identificador</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">CNPJ do EC</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">CNPJ do Adquirente</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Arranjo de Pagamento</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Status</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-700">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($optIns as $optIn)
                    <tr>
                        <td class="px-4 py-3">{{ $optIn->unique_identifier ?? $optIn->id }}</td>
                        <td class="px-4 py-3">{{ $optIn->client?->document_number ?? '—' }}</td>
                        <td class="px-4 py-3">{{ $optIn->acquirer?->document_number ?? '—' }}</td>
                        <td class="px-4 py-3">{{ $optIn->paymentArrangement?->code ?? '—' }}</td>
                        <td class="px-4 py-3">
                            <span
                                class="
                                        @if ($optIn->status === \App\Enums\OptInStatus::ACTIVE) text-green-600 font-semibold
                                        @elseif($optIn->status === \App\Enums\OptInStatus::OPTED_OUT) text-red-600 font-semibold
                                        @elseif($optIn->status === \App\Enums\OptInStatus::PENDING) text-yellow-600 font-semibold
                                        @else text-gray-600 @endif
                                    ">
                                {{ $optIn->status->label() }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <a href="{{ route('opt-ins.show', $optIn->id) }}"
                                class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">
                                Visualizar
                            </a>
                            @if ($optIn->status === \App\Enums\OptInStatus::ACTIVE)
                                <form action="{{-- {{ route('opt-ins.opt-out', $optIn->id) }} --}}" method="post"
                                    onsubmit="return confirm('Tem certeza que deseja cancelar este Opt-In?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition">
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
                        <td colspan="6" class="px-4 py-4 text-center text-gray-500">
                            Ainda não foram registrados Opt-Ins
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $optIns->links() }}
    </div>

</x-app-layout>

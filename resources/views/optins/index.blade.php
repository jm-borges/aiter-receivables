@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-6">
        <h1 class="text-2xl font-bold mb-4">Opt-Ins</h1>

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
                        <td class="border px-2 py-1">{{ $optIn->unique_identifier ?? $optIn->id }}</td>
                        <td class="border px-2 py-1">{{ $optIn->client?->document_number ?? '—' }}</td>
                        <td class="border px-2 py-1">{{ $optIn->acquirer?->document_number ?? '—' }}</td>
                        <td class="border px-2 py-1">{{ $optIn->paymentArrangement?->code ?? '—' }}</td>
                        <td class="border px-2 py-1">
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
                        <td class="border px-2 py-1 text-center">
                            @if ($optIn->status === \App\Enums\OptInStatus::ACTIVE)
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

        <div class="mt-4">
            {{ $optIns->links() }}
        </div>
    </div>
@endsection

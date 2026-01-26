@props(['partners'])

<div class="flex flex-col gap-2.5">

    {{-- Header --}}
    <div class="grid grid-cols-[2.5fr_2fr_2fr_2fr_0.7fr] text-[13px] text-[#bfb8d9] px-2.5">
        <div>Empresa/CNPJ</div>
        <div>Total de recebíveis performados coletados</div>
        <div>Recebíveis a performar</div>
        <div>Total da operação</div>
        <div>Agenda</div>
    </div>

    @forelse ($partners as $partner)
        @php
            $name = $partner->fantasy_name ?: $partner->name;
            $doc = $partner->document_number;

            $summary = $partner->receivables_summary ?? [];

            // iniciais do nome
            $initials = collect(explode(' ', $name))
                ->filter()
                ->take(2)
                ->map(fn($p) => mb_strtoupper(mb_substr($p, 0, 1)))
                ->implode('');
        @endphp

        <div class="grid grid-cols-[2.5fr_2fr_2fr_2fr_0.7fr] bg-[#efedf4] rounded-lg px-2.5 py-3 items-center">

            {{-- Empresa --}}
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-md bg-[#dcd7ea] flex items-center justify-center font-bold text-[#3c2a7a]">
                    {{ $initials }}
                </div>
                <div>
                    <div class="font-semibold text-[#2b1d55]">{{ $name }}</div>
                    <div class="text-xs text-[#7a6fa3]">{{ format_document($doc) }}</div>
                </div>
            </div>

            {{-- Total de recebíveis performados coletados --}}
            <div class="flex flex-col">
                <div class="font-semibold text-[#2b1d55]">
                    {{ 'R$ ' . number_format($summary['locked_by_user'] ?? 0, 2, ',', '.') }}
                </div>
                <div class="text-xs text-[#7a6fa3]">período atual</div>
            </div>

            {{-- Recebíveis a performar --}}
            <div class="flex flex-col">
                <div class="font-semibold text-[#2b1d55]">
                    {{ 'R$ ' . number_format($summary['to_be_received'] ?? 0, 2, ',', '.') }}
                </div>
                <div class="text-xs text-[#7a6fa3]">Total</div>
            </div>

            {{-- Total da operação --}}
            <div class="flex flex-col">
                <div class="font-semibold text-[#2b1d55]">
                    {{ 'R$ ' . number_format($summary['total_operation'] ?? 0, 2, ',', '.') }}
                </div>
                <div class="text-xs text-[#7a6fa3]">Total</div>
            </div>

            {{-- Agenda --}}
            <div class="flex justify-center">
                <button class="conciliation-open-receivables-modal text-lg hover:scale-110 transition"
                    data-partner-id="{{ $partner->id }}" title="Ver agenda">
                    📅
                </button>
            </div>

        </div>

    @empty
        <div class="p-5 text-[#999]">
            Nenhuma empresa encontrada.
        </div>
    @endforelse

</div>

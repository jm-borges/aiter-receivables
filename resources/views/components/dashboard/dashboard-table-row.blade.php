@props(['partner'])
<div class="grid w-full grid-cols-[80px_2fr_1.2fr_1.5fr_1fr_80px] items-center bg-white h-[85px] rounded-[5px] mb-2.5">
    <div class="mx-2.5">
        <img src="/assets/images/placeholder_logo.png" width="60">
    </div>

    <div class="mx-2.5">
        <p class="text-[16px] font-semibold leading-[1.2]">
            {{ $partner->fantasy_name ?? $partner->name }}
        </p>
        <p class="text-[14px] leading-[1.2]">
            {{ format_document($partner->document_number) }}
        </p>
    </div>

    <div class="mx-2.5">
        <p class="text-[16px] font-semibold leading-[1.2]">
            R$ {{ number_format($partner->receivables_summary['locked_by_user'] ?? 0, 2, ',', '.') }}
        </p>
        <p class="text-[14px] leading-[1.2]">período atual</p>
    </div>

    <div class="mx-2.5">
        <p class="text-[16px] font-semibold leading-[1.2]">
            R$ {{ number_format(0, 2, ',', '.') }}
        </p>
        <p class="text-[14px] leading-[1.2]">Total</p>
    </div>

    <div class="mx-2.5">
        <x-dashboard.monitoring-cell :monitoring="$partner->monitoring ?? null" />
    </div>

    <div class="mx-2.5 relative">
        <div class="flex items-center gap-5">
            <img src="/assets/images/pin.png" alt="Fixar" width="20" class="cursor-pointer">
            <button id="options-btn-{{ $partner->id }}" class="relative">
                <img src="/assets/images/options.png" alt="Opções" width="6" class="cursor-pointer">
            </button>
        </div>

        <!-- Menu popup -->
        <div id="options-menu-{{ $partner->id }}"
            class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
            <ul class="flex flex-col py-1 text-[14px]">
                <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Análise de crédito</li>
                <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Status de inadimplência</li>
                <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Conciliação de recebíveis</li>
            </ul>
        </div>
    </div>
</div>

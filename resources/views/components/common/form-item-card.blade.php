@props([
    'icon',
    'title',
    'value',
    'id' => null,
    'class' => '',
    'iconWidth' => 21,
    'iconHeight' => 21,
    'infoWidth' => 21,
    'infoHeight' => 21,

    // Botão opcional
    'buttonId' => null,
    'buttonText' => null,
    'buttonIcon' => null,
])

<div {{ isset($id) ? 'id=' . $id : '' }}
    class="p-4 bg-white rounded-md inline-block min-w-[260px] max-w-[360px] {{ $class }}">

    {{-- Header --}}
    <div class="flex justify-between items-center">
        <div class="flex items-center">
            <img src="{{ $icon }}" width="{{ $iconWidth }}" height="{{ $iconHeight }}">
            <div class="form-item-title ml-2">{{ $title }}</div>
        </div>

        <img src="/assets/images/InfoCircle.png" width="{{ $infoWidth }}" height="{{ $infoHeight }}">
    </div>

    {{-- Valor --}}
    <div class="form-item-value text-[#211748] text-xl font-semibold">
        {{ $value }}
    </div>

    {{-- Divisor --}}
    <hr class="border-0 border-t-2 border-[#211748]/30 my-2">

    {{-- Rodapé: Botão (opcional) + Data --}}
    <div class="flex justify-between items-center">
        {{-- Botão --}}
        @if ($buttonText && $buttonIcon)
            <button type="button" {{ $buttonId ? 'id=' . $buttonId : '' }}
                class="inline-flex items-start justify-start text-left gap-2 px-3 py-1.5 text-white text-sm rounded-[5px] bg-[#69549F] hover:brightness-110 transition max-w-max">
                <img src="{{ $buttonIcon }}" width="16" height="16">
                <span>{{ $buttonText }}</span>
            </button>
        @else
            <div></div>
        @endif

        {{-- Data --}}
        <x-common.form-date-text />
    </div>
</div>

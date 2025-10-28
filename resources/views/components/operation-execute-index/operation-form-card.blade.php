@props([
    'icon',
    'title',
    'value',
    'showInput' => false,
    'iconWidth' => 21,
    'iconHeight' => 21,
    'infoWidth' => 21,
    'infoHeight' => 21,
])

<div class="standard-container" style="width:382px">
    <div class="flex justify-between items-center">
        <div class="flex items-center">
            <img src="{{ $icon }}" width="{{ $iconWidth }}" height="{{ $iconHeight }}">
            <div class="operation-form-item-title ml-2">{{ $title }}</div>
        </div>

        <img src="/assets/images/InfoCircle.png" width="{{ $infoWidth }}" height="{{ $infoHeight }}">
    </div>

    <div class="operation-form-item-value standard-container-title">
        {{ $value }}
    </div>

    <hr class="operation-form-divider">

    <x-operation-execute-index.operation-form-date-text />

    @if ($showInput)
        <div class="operation-form-label mt-5">
            Valor como garantia
        </div>
        <input type="text" placeholder="R$0,00" class="operation-form-text-field w-full">
    @endif
</div>

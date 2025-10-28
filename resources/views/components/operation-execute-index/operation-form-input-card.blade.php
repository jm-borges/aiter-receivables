@props([
    'title',
    'showInput' => true,
    'inputLabel' => 'Valor como garantia',
    'selectLabel' => 'Selecione o tipo de parcela',
    'width' => 512,
])

<div class="ml-2">
    <div class="operation-form-container-title">{{ $title }}</div>
    <hr class="operation-form-divider">

    <div class="standard-container" style="width: {{ $width }}px; margin-top:10px">
        @if ($showInput)
            <div class="operation-form-label">{{ $inputLabel }}</div>
            <div class="mt-1">
                <input type="text" placeholder="R$0,00" class="operation-form-text-field w-full">
            </div>
        @endif

        <div class="mt-4">
            <select class="operation-form-select">
                <option value="">{{ $selectLabel }}</option>
                <option value="single">Parcela única</option>
                <option value="multiple">Múltiplas parcelas</option>
            </select>
        </div>
    </div>
</div>

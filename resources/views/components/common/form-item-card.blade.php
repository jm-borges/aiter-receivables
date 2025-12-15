@props([
    'icon',
    'title',
    'value',
    'id' => null,
    'marginTop' => 0,
    'marginLeft' => 0,
    'width' => 382,
    'iconWidth' => 21,
    'iconHeight' => 21,
    'infoWidth' => 21,
    'infoHeight' => 21,
])

<div class="standard-container" {{ isset($id) ? 'id=' . $id : '' }}
    style="width:{{ $width }}px; margin-left: {{ $marginLeft }}px; margin-top: {{ $marginTop }}px">
    <div class="flex justify-between items-center">
        <div class="flex items-center">
            <img src="{{ $icon }}" width="{{ $iconWidth }}" height="{{ $iconHeight }}">
            <div class="form-item-title ml-2">{{ $title }}</div>
        </div>

        <img src="/assets/images/InfoCircle.png" width="{{ $infoWidth }}" height="{{ $infoHeight }}">
    </div>

    <div class="form-item-value standard-container-title">
        {{ $value }}
    </div>

    <hr class="form-section-divider">

    <x-common.form-date-text />
</div>

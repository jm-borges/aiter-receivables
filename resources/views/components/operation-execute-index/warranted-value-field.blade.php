@props([
    'inputLabel' => 'Valor como garantia',
])

<div class="form-label">
    {{ $inputLabel }}
</div>
<div class="mt-1">
    <input type="number" step="0.01" id="warranted-value-field" name="warranted_value" placeholder="R$ 0,00"
        class="form-text-field w-full">
</div>

@props([
    'inputLabel' => 'Valor como garantia',
])

<div class="text-[#211748] font-semibold text-sm">
    {{ $inputLabel }}
</div>
<div class="mt-1">
    <input type="number" step="0.01" id="warranted-value-field" name="warranted_value" placeholder="R$ 0,00"
        class="rounded-[5px] border border-[#211748] w-full">
</div>

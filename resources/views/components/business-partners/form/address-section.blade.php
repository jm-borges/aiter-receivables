@props(['partner' => null])
<h2 class="text-lg font-semibold text-gray-800 mt-8 mb-8">Endereço</h2>

<x-business-partners.form.postal-code-input :partner="$partner" />
<x-business-partners.form.address-input :partner="$partner" />

<div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
    <x-business-partners.form.address-number-input :partner="$partner" />
    <x-business-partners.form.address-complement-input :partner="$partner" />
    <x-business-partners.form.address-neighborhood-input :partner="$partner" />
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <x-business-partners.form.address-city-input :partner="$partner" />
    <x-business-partners.form.address-state-input :partner="$partner" />
</div>

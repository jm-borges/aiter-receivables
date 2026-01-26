@props([
    'partner' => null,
    'types',
])

<form action="{{ isset($partner) ? '/business-partners/' . $partner->id : '/business-partners' }}" method="POST">
    @csrf
    @if (isset($partner))
        @method('PUT')
    @endif

    @php
        $editing = isset($partner->pivot) && ($partner->pivot->opt_in_start_date || $partner->pivot->opt_in_end_date);
    @endphp

    <x-business-partners.form.name-document-row :partner="$partner" />
    <x-business-partners.form.fantasy-phone-row :partner="$partner" />
    <x-business-partners.form.email-type-row :partner="$partner" :types="$types" />

    <hr>

    <x-business-partners.form.address-section :partner="$partner" />

    <hr>

    <x-business-partners.form.opt-in-input :partner="$partner" :editing="$editing" />
    <x-business-partners.form.opt-in-dates-input :partner="$partner" :editing="$editing" />

    <x-common.forms.action-buttons cancelRoute="/business-partners" />
</form>

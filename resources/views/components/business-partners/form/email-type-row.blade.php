@props(['partner' => null, 'types'])

<div class="mb-4 flex gap-4">
    <div class="flex-[7]">
        <x-business-partners.form.email-input :partner="$partner" :inline="true" />
    </div>
    <div class="flex-[3]">
        <x-business-partners.form.type-input :partner="$partner" :types="$types" :inline="true" />
    </div>
</div>

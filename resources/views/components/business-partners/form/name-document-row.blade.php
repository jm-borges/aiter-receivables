@props(['partner' => null])

<div class="mb-4 flex gap-4">
    <div class="flex-[7]">
        <x-business-partners.form.name-input :partner="$partner" :inline="true" />
    </div>
    <div class="flex-[3]">
        <x-business-partners.form.document-input :partner="$partner" :inline="true" />
    </div>
</div>

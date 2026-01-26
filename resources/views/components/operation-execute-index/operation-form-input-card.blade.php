@props(['title', 'width' => 512])

<div class="ml-2">
    <div class="text-2xl font-semibold text-white mt-10 mb-[5px]">{{ $title }}</div>
    <hr class="border-0 border-t-2 border-white">

    <div class="p-4 bg-white rounded-md" style="width: {{ $width }}px; margin-top:10px">
        <x-operation-execute-index.warranted-value-field />

        <x-operation-execute-index.negotiation-type-field />

        <x-operation-execute-index.installment-type-field />

        <x-operation-execute-index.single-installment-container />

        <x-operation-execute-index.multiple-installment-container />

        <x-operation-execute-index.submit-button-container />
    </div>

</div>

@props(['title', 'width' => 512])

<div class="ml-2">
    <div class="form-section-title">{{ $title }}</div>
    <hr class="form-section-divider">

    <div class="standard-container" style="width: {{ $width }}px; margin-top:10px">
        <x-operation-execute-index.warranted-value-field />

        <x-operation-execute-index.installment-type-field />

        <x-operation-execute-index.single-installment-container />

        <x-operation-execute-index.multiple-installment-container />

        <x-operation-execute-index.submit-button-container />
    </div>

</div>

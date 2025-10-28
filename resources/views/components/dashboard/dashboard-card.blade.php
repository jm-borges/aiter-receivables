<div {{ $attributes->merge(['class' => 'standard-container cursor-pointer shadow']) }} style="width: 350px">
    <div>
        <img src="{{ $icon }}" class="w-6">
    </div>

    <div>
        <p class="standard-container-title">{{ $title }}</p>
    </div>

    <div>
        <p class="text-sm text-custom-blue-hover font-normal">{{ $description }}</p>
    </div>

    <div class="flex justify-between px-4">
        <div class="mt-6">
            <p class="text-sm text-custom-blue-hover font-semibold">Detalhe</p>
        </div>
        <div class="mt-6">
            <img src="/assets/images/ArrowUpRightSquareFill.png" class="w-6">
        </div>
    </div>

</div>

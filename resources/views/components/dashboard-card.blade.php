<div {{ $attributes->merge(['class' => 'bg-white mr-4 cursor-pointer shadow rounded']) }} style="width: 350px">
    <div class="ml-4 mt-6 mb-4">
        <img src="{{ $icon }}" class="w-6">
    </div>

    <div class="ml-4">
        <p class="text-lg text-custom-blue-hover font-semibold">{{ $title }}</p>
    </div>

    <div class="ml-4">
        <p class="text-sm text-custom-blue-hover font-normal">{{ $description }}</p>
    </div>

    <div class="flex justify-between mb-4 px-4">
        <div class="mt-6">
            <p class="text-sm text-custom-blue-hover font-semibold">Detalhe</p>
        </div>
        <div class="mt-6">
            <img src="/assets/images/ArrowUpRightSquareFill.png" class="w-6">
        </div>
    </div>

</div>

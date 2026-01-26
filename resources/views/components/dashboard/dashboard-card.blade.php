<div {{ $attributes->merge(['class' => 'p-4 bg-white rounded-md cursor-pointer shadow w-[350px]']) }}>
    <div>
        <img src="{{ $icon }}" class="w-6">
    </div>

    <div>
        <p class="text-[#211748] text-xl font-semibold">{{ $title }}</p>
    </div>

    <div>
        <p class="text-sm text-custom-blue-hover font-normal">{{ $description }}</p>
    </div>

    <div class="flex justify-between px-4 mt-6">
        <p class="text-sm text-custom-blue-hover font-semibold">Detalhe</p>
        <img src="/assets/images/ArrowUpRightSquareFill.png" class="w-6">
    </div>
</div>

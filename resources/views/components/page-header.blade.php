@props(['title', 'subtitle' => null])

<div class="max-w-7xl  px-4 sm:px-6 lg:px-8 py-6">
    <h1 class="font-bold text-custom-blue-hover mb-2" style="font-size: 32px">{{ $title }}</h1>

    @if ($subtitle)
        <p class="text-custom-blue-hover font-normal" style="font-size: 14px">{{ $subtitle }}</p>
    @endif
</div>

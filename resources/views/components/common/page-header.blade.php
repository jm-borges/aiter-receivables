@props(['title', 'subtitle' => null])

<div class="max-w-7xl px-4 sm:px-6 lg:px-8 py-6">
    <h1 class="font-bold text-white mb-2 text-[32px]">
        {{ $title }}
    </h1>

    @if ($subtitle)
        <p class="text-white font-normal text-sm">
            {{ $subtitle }}
        </p>
    @endif
</div>

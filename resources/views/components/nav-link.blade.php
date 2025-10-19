@props([
    'active' => false,
    'icon' => null,
])

@php
    $classes = $active
        ? 'flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-md bg-custom-blue-hover text-white'
        : 'flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-md text-white hover:bg-custom-blue-hover';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    @if ($icon)
        <span class="material-icons text-lg">{{ $icon }}</span>
    @endif
    <span>{{ $slot }}</span>
</a>

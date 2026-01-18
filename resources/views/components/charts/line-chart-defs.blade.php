@props(['series'])

<defs>
    @foreach ($series as $s)
        <linearGradient id="grad-{{ $s['key'] }}" x1="0" y1="0" x2="0" y2="1">
            <stop offset="0%" stop-color="{{ $s['color'] }}" stop-opacity="0.25" />
            <stop offset="100%" stop-color="{{ $s['color'] }}" stop-opacity="0" />
        </linearGradient>
    @endforeach
</defs>

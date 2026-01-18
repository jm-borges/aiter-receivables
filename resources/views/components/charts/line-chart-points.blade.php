@props(['values', 'color', 'maxValue', 'paddingLeft', 'paddingTop', 'chartHeight', 'stepX'])

@foreach ($values as $i => $v)
    @php
        $x = $paddingLeft + $i * $stepX;
        $y = $paddingTop + ($chartHeight - ($v / max(1, $maxValue)) * $chartHeight);
    @endphp

    <circle cx="{{ $x }}" cy="{{ $y }}" r="4" fill="{{ $color }}" />

    <text x="{{ $x }}" y="{{ $y - 8 }}" text-anchor="middle" font-size="12" fill="{{ $color }}">
        {{ $v }}k
    </text>
@endforeach

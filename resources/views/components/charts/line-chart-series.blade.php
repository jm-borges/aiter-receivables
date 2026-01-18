@props(['values', 'color', 'seriesKey', 'maxValue', 'paddingLeft', 'paddingTop', 'chartHeight', 'stepX', 'count'])


@php
    $path = '';

    foreach ($values as $i => $v) {
        $x = $paddingLeft + $i * $stepX;
        $y = $paddingTop + ($chartHeight - ($v / max(1, $maxValue)) * $chartHeight);
        $path .= ($i === 0 ? 'M' : 'L') . "$x $y ";
    }

    $baseY = $paddingTop + $chartHeight;
    $endX = $paddingLeft + ($count - 1) * $stepX;
@endphp

<path d="{{ $path }} L {{ $endX }} {{ $baseY }} L {{ $paddingLeft }} {{ $baseY }} Z"
    fill="url(#grad-{{ $seriesKey }})" />


<path d="{{ $path }}" fill="none" stroke="{{ $color }}" stroke-width="3" />

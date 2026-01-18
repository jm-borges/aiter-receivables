@props(['labels', 'series', 'maxValue', 'height' => 240])

@php
    $viewWidth = 800;

    $paddingLeft = 40;
    $paddingTop = 20;
    $paddingBottom = 40;

    $width = $viewWidth - $paddingLeft - 20;
    $chartHeight = $height - $paddingTop - $paddingBottom;

    $count = count($labels);
    $stepX = $width / max(1, $count - 1);

    function chartY($value, $max, $height, $top)
    {
        return $top + ($height - ($value / max(1, $max)) * $height);
    }
@endphp

<div class="relative">
    <svg viewBox="0 0 {{ $viewWidth }} {{ $height }}" class="w-full h-56">

        <x-charts.line-chart-defs :series="$series" />

        {{-- Áreas + linhas --}}
        @foreach ($series as $s)
            <x-charts.line-chart-series :values="$s['values']" :color="$s['color']" :series-key="$s['key']" :max-value="$maxValue"
                :padding-left="$paddingLeft" :padding-top="$paddingTop" :chart-height="$chartHeight" :step-x="$stepX" :count="$count" />
        @endforeach


        {{-- Pontos + valores --}}
        @foreach ($series as $s)
            <x-charts.line-chart-points :values="$s['values']" :color="$s['color']" :max-value="$maxValue" :padding-left="$paddingLeft"
                :padding-top="$paddingTop" :chart-height="$chartHeight" :step-x="$stepX" />
        @endforeach

    </svg>

    <x-charts.line-chart-x-labels :labels="$labels" />

    <x-charts.line-chart-legend :series="$series" />
</div>

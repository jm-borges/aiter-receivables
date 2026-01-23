@props(['monitoring'])

@if ($monitoring)
    @php
        /** @var \App\Enums\MonitoringStatus $status */
        $status = $monitoring['status'];
        $variation = $monitoring['variation_percent'] ?? 0;
    @endphp

    <div class="monitoring">
        <div class="gradient-circle {{ $status->color() }}-gradient-circle"></div>

        <div>
            <p class="dashboard-main-text">
                {{ $status->title() }}
            </p>
            <p class="dashboard-sub-text">
                {{ $status->subtitle($variation) }}
            </p>
        </div>
    </div>
@else
    {{-- Fallback --}}
    <div class="monitoring">
        <div class="gray-gradient-circle"></div>
        <p class="dashboard-main-text">
            Sem dados
        </p>
    </div>
@endif

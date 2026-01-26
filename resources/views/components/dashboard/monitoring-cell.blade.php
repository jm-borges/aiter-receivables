@props(['monitoring'])

@if ($monitoring)
    @php
        /** @var \App\Enums\MonitoringStatus $status */
        $status = $monitoring['status'];
        $variation = $monitoring['variation_percent'] ?? 0;
    @endphp

    <div class="flex items-start gap-2 max-w-full">
        <div class="w-6 h-6 min-w-6 min-h-6 rounded-full shrink-0 bg-gradient-{{ $status->color() }}"></div>

        <div>
            <p class="text-[16px] font-semibold leading-[1.1]">
                {{ $status->title() }}
            </p>
            <p class="text-[14px] leading-[1.1]">
                {{ $status->subtitle($variation) }}
            </p>
        </div>
    </div>
@else
    {{-- Fallback --}}
    <div class="flex items-start gap-2 max-w-full">
        <div class="gray-w-6 h-6 min-w-6 min-h-6 rounded-full shrink-0 bg-gradient-gray"></div>
        <p class="text-[16px] font-semibold leading-[1.1]">
            Sem dados
        </p>
    </div>
@endif

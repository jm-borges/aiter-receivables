@props(['series'])

<div class="flex gap-6 mt-2 text-sm text-[#2d1b69]">
    @foreach ($series as $s)
        <div class="flex items-center gap-2">
            <span class="inline-block w-6 h-1 rounded" style="background: {{ $s['color'] }}"></span>
            <span>{{ $s['label'] }}</span>
        </div>
    @endforeach
</div>

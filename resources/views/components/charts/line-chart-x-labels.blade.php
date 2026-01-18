@props(['labels'])

<div class="flex justify-between text-xs text-[#2d1b69] mt-2 px-2">
    @foreach ($labels as $label)
        <div class="text-center">
            {!! nl2br(e(str_replace(' ', "\n", $label))) !!}
        </div>
    @endforeach
</div>

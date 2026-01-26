@props(['id', 'title' => 'Agenda'])

@php
    $modalId = $id . '-calendar-modal';
@endphp

<div id="{{ $modalId }}-overlay"
    class="fixed inset-0 bg-[rgba(20,10,40,0.6)] flex items-center justify-center z-[9999] hidden">

    <div class="bg-[#f3f1f8] rounded-xl w-[90%] max-w-[800px] max-h-[85vh] flex flex-col overflow-hidden">

        {{-- Header --}}
        <div class="px-5 py-4 bg-[#2b1d55] text-white flex justify-between items-center">
            <span id="{{ $modalId }}-title">{{ $title }}</span>
            <button id="{{ $modalId }}-close" class="text-white text-xl hover:opacity-80 transition">✕</button>
        </div>

        {{-- Body --}}
        <div class="p-5 overflow-auto" id="{{ $modalId }}-body">
            <x-common.calendar id="{{ $id }}" />
        </div>

    </div>
</div>

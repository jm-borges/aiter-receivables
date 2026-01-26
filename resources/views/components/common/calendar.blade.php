@props(['id'])

<div class="w-full max-w-[1000px] bg-white rounded-2xl p-5" id="{{ $id }}-calendar-root">

    <div class="flex items-center justify-center gap-3 relative mb-4">
        <button id="{{ $id }}-calendar-prev-month"
            class="bg-transparent text-xl cursor-pointer select-none px-2 hover:opacity-70">
            ◀
        </button>

        <h2 id="{{ $id }}-calendar-title" class="text-2xl font-bold text-[#1e144f]">
            Mês
        </h2>

        <button id="{{ $id }}-calendar-next-month"
            class="bg-transparent text-xl cursor-pointer select-none px-2 hover:opacity-70">
            ▶
        </button>
    </div>

    <div class="relative">
        {{-- Loading --}}
        <div id="{{ $id }}-calendar-loading"
            class="absolute inset-0 flex flex-col items-center justify-center bg-white/70 z-10 hidden gap-2">
            {{-- Spinner --}}
            <div class="w-8 h-8 border-4 border-t-[#2b1d55] border-gray-300 rounded-full animate-spin"></div>

            {{-- Texto --}}
            <div class="text-[#2b1d55] font-semibold">
                Carregando agenda...
            </div>
        </div>


        {{-- Grid --}}
        <div id="{{ $id }}-calendar-grid"
            class="grid grid-cols-7 gap-[2px] bg-[#ddd] rounded-xl overflow-hidden min-h-[280px]">
        </div>
    </div>

</div>

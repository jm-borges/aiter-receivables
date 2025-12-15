@props([
    'partner' => null,
    'editing',
])


{{-- Campos de datas — começam ocultos se não estiver editando --}}
<div id="opt_in_dates" class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-3 {{ $editing ? '' : 'hidden' }}">

    {{-- Data Início --}}
    <div>
        <label for="start_date" class="block text-sm font-medium text-gray-700">Data Início do Opt-in</label>
        <input type="date" name="opt_in_start_date" id="start_date"
            value="{{ $partner->pivot->opt_in_start_date ?? old('opt_in_start_date') }}"
            class="mt-1 block w-full rounded border-gray-300 shadow-sm
                focus:border-indigo-500 focus:ring-indigo-500"
            {{ $editing ? '' : 'disabled' }}>
    </div>

    {{-- Data Fim --}}
    <div>
        <label for="end_date" class="block text-sm font-medium text-gray-700">Data Fim do Opt-in</label>
        <input type="date" name="opt_in_end_date" id="end_date"
            value="{{ $partner->pivot->opt_in_end_date ?? old('opt_in_end_date') }}"
            class="mt-1 block w-full rounded border-gray-300 shadow-sm
                focus:border-indigo-500 focus:ring-indigo-500"
            {{ $editing ? '' : 'disabled' }}>
    </div>
</div>

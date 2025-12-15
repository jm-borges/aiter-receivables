@props([
    'partner' => null,
    'types',
    'inline' => false,
])

@if (Auth::user()->isSuperAdmin())
    {{-- Tipo (visível para super admin) --}}
    <div @class(['mb-4' => !$inline])>
        <label for="type" class="block text-sm font-medium text-gray-700">Tipo</label>
        <select name="type" id="type" required
            class="mt-1 block w-full rounded-md border-gray-300 bg-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            <option value="">Selecione</option>
            @foreach ($types as $type)
                <option value="{{ $type->value }}"
                    {{ old('type', $partner->type?->value) === $type->value ? 'selected' : '' }}>
                    {{ $type->label() }}
                </option>
            @endforeach
        </select>
    </div>
@else
    {{-- Tipo (oculto e fixo como client) --}}
    <div class="hidden">
        <select name="type" id="type" readonly>
            <option value="client" selected>Client</option>
        </select>
    </div>
@endif

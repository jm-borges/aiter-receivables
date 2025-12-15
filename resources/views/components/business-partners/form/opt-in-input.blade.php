@props([
    'partner' => null,
    'editing',
])



<div class="mt-4">
    <label class="inline-flex items-center">
        <input type="checkbox" id="toggle_opt_in" name="enable_opt_in"
            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
            {{ $editing ? 'checked' : '' }}>
        <span class="ml-2 text-gray-700">
            {{ $editing ? 'Atualizar Opt-in' : 'Realizar Opt-in' }}
        </span>
    </label>
    <p class="text-xs text-gray-500 mt-1 ml-6">
        (marcando essa opção, será feita solicitação de anuência para visualização dos recebíveis desse CNPJ)
    </p>
</div>

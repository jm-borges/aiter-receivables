<div class="text-[#211748] font-semibold text-sm">
    Tipo de operação:
</div>
<div class="mt-2">
    <div>
        <label>
            <input type="checkbox" name="type" value="{{ \App\Enums\ContractOperationType::RECUPERACAO_INADIMPLENCIA }}"
                class="mr-1">
            Recuperação de inadimplência
        </label>
    </div>
    <div>
        <label>
            <input type="checkbox" name="type" value="{{ \App\Enums\ContractOperationType::COLATERAL }}" class="mr-1">
            Colateral com recebiveis a performar
        </label>
    </div>

</div>

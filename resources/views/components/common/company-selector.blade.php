<div class="standard-container" style="width: 513px;">
    <div class="standard-container-title">
        {{ $title ?? 'Selecionar empresa' }}
    </div>

    <div class="form-label" style="margin-top: 5px">
        {{ $searchLabel ?? 'Buscar por CNPJ ou Razão Social' }}
    </div>

    <div>
        <input class="form-text-field form-search-text-field" type="text"
            placeholder="{{ $searchPlaceholder ?? 'Digite o CNPJ ou razão social...' }}" style="width: 100%">
    </div>

    <div class="form-label" style="margin-top: 20px">
        {{ $selectLabel ?? 'Empresa' }}
    </div>

    <div>
        <select class="form-select" disabled>
            <option value="">Carregando empresas...</option>
        </select>
    </div>
</div>

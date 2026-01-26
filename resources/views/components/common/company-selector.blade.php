<div class="p-4 bg-white rounded-md w-[513px]">
    <div class="text-[#211748] text-xl font-semibold">
        {{ $title ?? 'Selecionar empresa' }}
    </div>

    <div class="text-[#211748] font-semibold text-sm mt-1">
        {{ $searchLabel ?? 'Buscar por CNPJ ou Razão Social' }}
    </div>

    <div class="relative mt-1">
        <img src="/assets/images/search.png"
            class="absolute left-2.5 top-1/2 -translate-y-1/2 w-4 h-4 opacity-60 pointer-events-none">

        <input data-company-search
            class="
            rounded-[5px]
            border border-[#211748]
            w-full
            pl-9
            h-9"
            type="text" placeholder="{{ $searchPlaceholder ?? 'Digite o CNPJ ou razão social...' }}">
    </div>


    <div class="text-[#211748] font-semibold text-sm mt-5">
        {{ $selectLabel ?? 'Empresa' }}
    </div>

    <div>
        <select data-company-select class=" w-full  rounded-[5px]  bg-[#69549F]  text-white" disabled>
            <option value="">Carregando empresas...</option>
        </select>
    </div>

</div>

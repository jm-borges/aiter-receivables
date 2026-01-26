<div id="defaults-section" class="block">
    <div class="text-2xl font-semibold text-white mt-10 mb-[5px] flex justify-between cursor-pointer"
        id="payment-default-toggle">
        <span>Operações de Inadimplentes</span>
        <span id="payment-default-arrow" class="transition-transform duration-200 text-white">
            <!-- seta pra baixo -->
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none">
                <path d="M6 9L12 15L18 9" stroke="white" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </span>
    </div>

    <hr class="border-0 border-t-2 border-white">

    {{-- Estado: nenhuma empresa selecionada --}}
    <div id="payment-default-empty" class="hidden mt-5">
        <x-receivables-query.general-defaults-table :partners="$partners" />
    </div>

    {{-- Estado: empresa selecionada --}}
    <div id="payment-default-content" class="hidden mt-5 flex">
        <x-common.form-item-card id="amount-due" icon="/assets/images/Cash.png" title="Valor devido" value="R$ 0,00" />
        <x-common.form-item-card id="amount-to-be-recovered" icon="/assets/images/Coin.png" title="Valor a recuperar"
            value="R$ 0,00" marginLeft="10" />
        <x-common.form-item-card id="amount-recovered" icon="/assets/images/Check2Square.png" title="Valor recuperado"
            value="R$ 0,00" marginLeft="10" />
    </div>
</div>

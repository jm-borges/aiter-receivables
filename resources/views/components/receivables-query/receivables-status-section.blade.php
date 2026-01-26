@props(['partners'])

<div id="receivables-section" class="block">
    <div class="text-2xl font-semibold text-white mt-10 mb-[5px] flex justify-between cursor-pointer"
        id="receivables-toggle">
        <span>Status de Operações</span>

        <span id="receivables-arrow" class="transition-transform duration-200 text-white">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none">
                <path d="M6 9L12 15L18 9" stroke="white" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </span>
    </div>

    <hr class="border-0 border-t-2 border-white">

    {{-- Estado: nenhuma empresa selecionada --}}
    <div id="receivables-empty" class="hidden mt-5">
        <x-receivables-query.general-receivables-table :partners="$partners" />
    </div>

    {{-- Estado: empresa selecionada --}}
    <div id="receivables-content" class="hidden mt-5 flex flex-wrap gap-4">
        <x-common.form-item-card id="locked-by-user-values" icon="/assets/images/PiggyBank.png"
            title="Total de recebíveis performados coletados" value="R$ 0,00" class="w-full md:w-[48%] lg:flex-1" />

        <x-common.form-item-card id="received-values" icon="/assets/images/CalendarCheck.png" title="Recebido"
            value="R$ 0,00" class="w-full md:w-[48%] lg:flex-1" />

        <x-common.form-item-card id="to-be-received-values" icon="/assets/images/CalendarMinus.png"
            title="Falta receber" value="R$ 0,00" class="w-full md:w-[48%] lg:flex-1" />
    </div>

</div>

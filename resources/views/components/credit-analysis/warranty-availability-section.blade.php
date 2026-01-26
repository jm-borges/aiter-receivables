<div>
    <div class="text-2xl font-semibold text-white mt-10 mb-[5px]">Disponibilidade de garantias</div>

    <hr class="border-0 border-t-2 border-white">

    <div class="mt-5 grid grid-cols-1 lg:grid-cols-4 gap-6 items-stretch auto-rows-fr">
        {{-- Gráfico de evolução --}}
        <div class="lg:col-span-1 flex h-full">
            <x-credit-analysis.warranty-evolution-chart />
        </div>

        {{-- Produção de garantias --}}
        <div class="lg:col-span-1 flex flex-col gap-2.5 h-full min-h-full">
            <div class="text-white font-semibold text-base">
                Produção de garantias do recebíveis
            </div>

            <div class="flex-1 flex flex-col">
                <div class="mt-2.5 space-y-3 flex flex-col items-start">
                    <x-common.form-item-card id="warranty-free" icon="/assets/images/lock_open.png" title="Livre"
                        value="R$ 15.989,00" buttonId="btn-warranty-free-schedule" buttonText="Agenda"
                        buttonIcon="/assets/images/calendar-white.png" />

                    <x-common.form-item-card id="warranty-receivable" icon="/assets/images/CalendarCheck.png"
                        title="Faturamento Mensal" value="R$ 547.327,54" buttonId="btn-warranty-cards-revenue-schedule"
                        buttonText="Agenda" buttonIcon="/assets/images/calendar-white.png" />

                    <x-common.form-item-card id="warranty-locked" icon="/assets/images/lock_closed.png"
                        title="Comprometido" value="R$ 752.354,27" />
                </div>
            </div>
        </div>

        {{-- Pagamentos x Faturamento --}}
        <div class="lg:col-span-2 flex flex-col h-full min-h-full">
            <div class="text-white font-semibold text-base mb-2">
                Pagamentos X Faturamento
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-2.5 mb-5">
                <x-common.form-item-card class="w-full max-w-none" id="payables-total" icon="/assets/images/Cash.png"
                    title="Pagamentos" value="R$ 100.000,00" />

                <x-common.form-item-card class="w-full max-w-none" id="receivables-total"
                    icon="/assets/images/CalendarCheck.png" title="Faturamento" value="R$ 150.000,00" />
            </div>

            <div class="flex-1">
                <x-credit-analysis.payments-vs-revenue-chart />
            </div>
        </div>
    </div>
</div>

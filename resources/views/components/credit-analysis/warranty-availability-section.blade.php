<div>
    <div class="text-2xl font-semibold text-white mt-10 mb-[5px]">Disponibilidade de garantias</div>
    <hr class="border-0 border-t-2 border-white">

    <div class="flex gap-2.5 mt-5">
        {{-- Gráfico de evolução --}}
        <x-credit-analysis.warranty-evolution-chart />

        {{-- Produção de garantias --}}
        <div>
            <div class="text-white font-semibold text-base">
                Produção de garantias do recebíveis
            </div>

            <div class="mt-2.5 space-y-2.5">
                <x-common.form-item-card id="warranty-free" icon="/assets/images/lock_open.png" title="Livre"
                    value="R$ 15.989,00" />

                <x-common.form-item-card id="warranty-receivable" icon="/assets/images/CalendarCheck.png"
                    title="A receber" value="R$ 547.327,54" />

                <x-common.form-item-card id="warranty-locked" icon="/assets/images/lock_closed.png" title="Comprometido"
                    value="R$ 752.354,27" />
            </div>
        </div>

        {{-- Pagamentos x Faturamento --}}
        <div>
            <div class="text-white font-semibold text-base">
                Pagamentos X Faturamento
            </div>

            <div class="flex justify-between mt-2.5 mb-2.5 gap-2.5">
                <x-common.form-item-card width="316" id="payables-total" icon="/assets/images/Cash.png"
                    title="Pagamentos" value="R$ 100.000,00" />

                <x-common.form-item-card width="316" id="receivables-total" icon="/assets/images/CalendarCheck.png"
                    title="Faturamento" value="R$ 150.000,00" />
            </div>

            <x-credit-analysis.payments-vs-revenue-chart />
        </div>
    </div>
</div>

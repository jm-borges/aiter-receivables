<div>
    <div class="form-section-title">Disponibilidade de garantias</div>
    <hr class="form-section-divider">

    <div style="display: flex; margin-top: 20px">
        <x-credit-analysis.warranty-evolution-chart />

        <div style="margin-left: 10px">
            <div style="color:white;font-weight: 600; font-size: 16px;">
                Produção de garantias do recebíveis
            </div>
            <div style="margin-top: 10px">
                <x-common.form-item-card id="warranty-free" icon="/assets/images/lock_open.png" title="Livre"
                    value="R$ 15.989,00" />
            </div>
            <div style="margin-top: 10px">
                <x-common.form-item-card id="warranty-receivable" icon="/assets/images/CalendarCheck.png"
                    title="A receber" value="R$ 547.327,54" />
            </div>
            <div style="margin-top: 10px">
                <x-common.form-item-card id="warranty-locked" icon="/assets/images/lock_closed.png" title="Comprometido"
                    value="R$ 752.354,27" />
            </div>
        </div>

        <div style="margin-left: 10px">
            <div style="color:white;font-weight: 600; font-size: 16px;">
                Pagamentos X Faturamento
            </div>
            <div style="display:flex;justify-content:space-between ;margin-top: 10px;margin-bottom:10px;">
                <x-common.form-item-card width="316" id="payables-total" icon="/assets/images/Cash.png"
                    title="Pagamentos" value="R$ 100.000,00" />
                <x-common.form-item-card width="316" id="receivables-total" icon="/assets/images/CalendarCheck.png"
                    title="Faturamento" value="R$ 150.000,00" marginLeft="10" />
            </div>
            <x-credit-analysis.payments-vs-revenue-chart />
        </div>
    </div>
</div>

<div>
    <div class="form-section-title">Disponibilidade de garantias</div>
    <hr class="form-section-divider">

    <div style="display: flex; margin-top: 20px">
        <div style="width: 513px; height: 405px;background-color: white">
        </div>
        <div style="margin-left: 10px">
            <div style="color:#211748;font-weight: 600; font-size: 16px;">
                Produção de garantias do recebíveis
            </div>
            <div style="margin-top: 10px">
                <x-form-item-card id="warranty-free" icon="/assets/images/lock_open.png" title="Livre"
                    value="R$ 15.989,00" />
            </div>
            <div style="margin-top: 10px">
                <x-form-item-card id="warranty-receivable" icon="/assets/images/CalendarCheck.png" title="A receber"
                    value="R$ 547.327,54" />
            </div>
            <div style="margin-top: 10px">
                <x-form-item-card id="warranty-locked" icon="/assets/images/lock_closed.png" title="Comprometido"
                    value="R$ 752.354,27" />
            </div>
        </div>
        <div style="margin-left: 10px">
            <div style="color:#211748;font-weight: 600; font-size: 16px;">
                Contas a pagar X Contas a receber
            </div>
            <div style="display:flex; margin-top: 10px;">
                <x-form-item-card width="316" id="payables-total" icon="/assets/images/Cash.png"
                    title="Contas a pagar" value="R$ 100.000,00" />
                <x-form-item-card width="316" id="receivables-total" icon="/assets/images/CalendarCheck.png"
                    title="Contas a receber" value="R$ 150.000,00" />
            </div>
            <div style="width: 644px; height: 243px;background-color: white; margin-top:10px">
            </div>
        </div>
    </div>
</div>

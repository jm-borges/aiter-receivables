<div>
    <div class="form-section-title">Dívidas Bancárias</div>
    <hr class="form-section-divider">

    <div style="display: flex;  margin-top: 20px;">
        <div>
            <div class="standard-container-sub-title">
                Limite de crédito bancário
            </div>

            <div style="margin-top: 10px">
                <x-common.form-item-card id="bank-limit-total" icon="/assets/images/PiggyBank.png" title="Total"
                    value="R$ 756.803.163,00" />
            </div>

            <div style="margin-top: 10px">
                <x-common.form-item-card id="bank-limit-used" icon="/assets/images/Flag.png" title="Tomadas"
                    value="R$ 54.707.356,54" />
            </div>

            <div style="margin-top: 10px">
                <x-common.form-item-card id="bank-limit-available" icon="/assets/images/lock_open.png"
                    title="Disponível" value="R$ 752.354,27" />
            </div>
        </div>

        <div style="margin-left: 10px">
            <x-credit-analysis.bank-debt-evolution-chart />
        </div>

        <div style="margin-left: 10px">
            <x-credit-analysis.bank-debt-profile-chart />
        </div>
    </div>
</div>

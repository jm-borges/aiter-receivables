<div>
    <div class="text-2xl font-semibold text-white mt-10 mb-[5px]">Dívidas Bancárias</div>
    <hr class="border-0 border-t-2 border-white">

    <div class="flex mt-5 gap-2.5">
        <div>
            <div class="text-white text-base font-semibold">
                Limite de crédito bancário
            </div>


            <div class="mt-2.5">
                <x-common.form-item-card id="bank-limit-total" icon="/assets/images/PiggyBank.png" title="Total"
                    value="R$ 756.803.163,00" />
            </div>

            <div class="mt-2.5">
                <x-common.form-item-card id="bank-limit-used" icon="/assets/images/Flag.png" title="Tomadas"
                    value="R$ 54.707.356,54" />
            </div>

            <div class="mt-2.5">
                <x-common.form-item-card id="bank-limit-available" icon="/assets/images/lock_open.png"
                    title="Disponível" value="R$ 752.354,27" />
            </div>
        </div>

        <div>
            <x-credit-analysis.bank-debt-evolution-chart />
        </div>

        <div>
            <x-credit-analysis.bank-debt-profile-chart />
        </div>
    </div>
</div>

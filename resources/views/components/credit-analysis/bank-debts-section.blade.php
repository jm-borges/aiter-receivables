<div>
    <div class="text-2xl font-semibold text-white mt-10 mb-[5px]">Dívidas Bancárias</div>
    <hr class="border-0 border-t-2 border-white">

    <div class="mt-5 grid grid-cols-1 lg:grid-cols-[1fr_1.8fr_0.95fr] gap-6 items-stretch auto-rows-fr">
        {{-- Coluna 1: Cards --}}
        <div class="flex flex-col gap-2.5 h-full min-h-full">
            <div class="text-white text-base font-semibold pb-3">
                Limite de crédito bancário
            </div>

            <div class="flex-1 flex flex-col">
                <div class="mt-2.5 space-y-4 flex flex-col items-start">
                    <x-common.form-item-card class="w-full max-w-none" id="bank-limit-total"
                        icon="/assets/images/PiggyBank.png" title="Total" value="R$ 756.803.163,00" />

                    <x-common.form-item-card class="w-full max-w-none" id="bank-limit-used"
                        icon="/assets/images/Flag.png" title="Tomadas" value="R$ 54.707.356,54" />

                    <x-common.form-item-card class="w-full max-w-none" id="bank-limit-available"
                        icon="/assets/images/lock_open.png" title="Disponível" value="R$ 752.354,27" />
                </div>

                {{-- Espaçador para alinhar com altura dos gráficos --}}
                <div class="flex-1"></div>
            </div>
        </div>

        {{-- Coluna 2: Evolução --}}
        <div class="flex h-full">
            <x-credit-analysis.bank-debt-evolution-chart />
        </div>

        {{-- Coluna 3: Perfil --}}
        <div class="flex h-full">
            <x-credit-analysis.bank-debt-profile-chart />
        </div>
    </div>
</div>

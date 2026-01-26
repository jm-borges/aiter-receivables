<div class="flex flex-col flex-1 bg-transparent">
    <div class="text-2xl font-semibold text-white mt-10 mb-[5px]">Agenda de Recebíveis</div>
    <hr class="border-0 border-t-2 border-white">

    <div class="mt-3 flex flex-col md:flex-row md:gap-4 flex-1">

        {{-- Coluna 1: Livre --}}
        <div class="flex-1 mb-2 md:mb-0">
            <x-common.form-item-card id="free-values" icon="/assets/images/lock_open.png" title="Livre" value="R$ 0"
                buttonId="btn-free-values-schedule" buttonText="Agenda" buttonIcon="/assets/images/calendar-white.png" />
        </div>

        {{-- Coluna 2: Faturamento e Comprometido --}}
        <div class="flex-1 flex flex-col gap-2.5">
            <x-common.form-item-card id="to-be-received-values" icon="/assets/images/CalendarCheck.png"
                title="Faturamento" value="R$ 0" />

            <x-common.form-item-card id="locked-by-others-values" icon="/assets/images/lock_closed.png" icon-width="18"
                title="Comprometido" value="R$ 0" />
        </div>

    </div>
</div>

<div id="multiple-installment-container" class="hidden mt-2.5">
    <div class="flex">
        <div class="mr-2.5">
            <select class=" w-full  rounded-[5px]  bg-[#69549F]  text-white" id="multiple-installments-days-field"
                name="multiple_installments_days">
                <option value="">Período</option>
                <option value="7">De 7 em 7 dias</option>
                <option value="14">De 14 em 14 dias</option>
                <option value="21">De 21 em 21 dias</option>
                <option value="28">De 28 em 28 dias</option>
            </select>
        </div>
        <div>
            <select class=" w-full  rounded-[5px]  bg-[#69549F]  text-white" id="inform-installments-select"
                name="installments_amount">
                <option value="">Quantas Parcelas</option>
                @for ($i = 1; $i < 36; $i++)
                    <option value="{{ $i + 1 }}">{{ $i + 1 }}x</option>
                @endfor
            </select>
        </div>
    </div>

    <div id="inform-installments-container" class="hidden mt-2.5">
        <div class="text-[#211748] font-semibold text-sm mt-2.5">
            Defina o percentual de cada parcela (%) abaixo
        </div>

        <div id="installments-container" class="mt-2.5">
        </div>
    </div>
</div>

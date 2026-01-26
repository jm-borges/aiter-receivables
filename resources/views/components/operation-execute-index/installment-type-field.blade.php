   @props([
       'selectLabel' => 'Selecione o tipo de parcela',
   ])

   <div class="mt-4">
       <select class=" w-full  rounded-[5px]  bg-[#69549F]  text-white" name="installments_type"
           id="installment-type-field" required>
           <option value="">{{ $selectLabel }}</option>
           <option value="single">Parcela única</option>
           <option value="multiple">Múltiplas parcelas</option>
       </select>
   </div>

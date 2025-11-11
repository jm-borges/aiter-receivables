 <div id="multiple-installment-container" style="display: none; margin-top: 10px">
     <div style="display: flex">
         <div style="margin-right: 10px">
             <select class="form-select" id="multiple-installments-days-field" name="multiple_installments_days">
                 <option value="">Período</option>
                 <option value="7">De 7 em 7 dias</option>
                 <option value="14">De 14 em 14 dias</option>
                 <option value="21">De 21 em 21 dias</option>
                 <option value="28">De 28 em 28 dias</option>
             </select>
         </div>
         <div>
             <select class="form-select" id="inform-installments-select" name="installments_amount">
                 <option value="">Quantas Parcelas</option>
                 @for ($i = 1; $i < 36; $i++)
                     <option value="{{ $i + 1 }}">{{ $i + 1 }}x</option>
                 @endfor
             </select>
         </div>
     </div>

     <div id="inform-installments-container" style="display: none">
         <div class="form-label" style="margin-top:10px">
             Defina o percentual de cada parcela (%) abaixo
         </div>

         <div style="margin-top:10px" id="installments-container">
         </div>
     </div>
 </div>

export const buildInstallmentTemplate = (index) => `
<div class="text-[#211748] font-semibold text-sm w-[80px] mr-2.5 mt-2.5">
        Parcela ${index + 1}
    </div>
    <div>
        <input class="rounded-[5px] border border-[#211748]" 
               name="installment_interest[${index + 1}]" 
               type="number" 
               placeholder="X%" 
               step="0.01" 
               min="0"
               required >
    </div>
`;

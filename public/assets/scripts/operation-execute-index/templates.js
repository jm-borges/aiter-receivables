export const buildInstallmentTemplate = (index) => `
    <div class="form-label" style="width: 80px; margin-right: 10px; margin-top:10px;">
        Parcela ${index + 1}
    </div>
    <div>
        <input class="form-text-field" 
               name="installment_interest[${index + 1}]" 
               type="number" 
               placeholder="X%" 
               step="0.01" 
               min="0"
               required >
    </div>
`;

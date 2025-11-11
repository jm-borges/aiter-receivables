import { installmentTypeField, submitButtonContainer } from "./main.js";
import { toggleInstallmentContainers, renderInstallments } from "./dom.js";

/**
 * Mostra/esconde o botão de envio conforme o tipo.
 */
const updateSubmitButtonVisibility = (type) => {
    submitButtonContainer.style.display = type ? 'block' : 'none';
};

/**
 * Remove o atributo "required" de todos os campos relacionados a parcelas.
 */
const clearRequiredAttributes = () => {
    const fields = [
        'single-installment-days-field',
        'multiple-installments-days-field',
        'inform-installments-select'
    ];

    fields.forEach(id => {
        const el = document.getElementById(id);
        if (el) el.removeAttribute('required');
    });
};

/**
 * Aplica "required" nos campos corretos de acordo com o tipo selecionado.
 */
const applyRequiredAttributes = (type) => {
    if (type === 'single') {
        document.getElementById('single-installment-days-field')?.setAttribute('required', 'true');
    } else if (type === 'multiple') {
        document.getElementById('multiple-installments-days-field')?.setAttribute('required', 'true');
        document.getElementById('inform-installments-select')?.setAttribute('required', 'true');
    }
};

/**
 * Lida com a mudança de tipo de parcela.
 */
export const handleInstallmentTypeFieldChange = () => {
    const type = installmentTypeField.value;

    toggleInstallmentContainers(type);
    updateSubmitButtonVisibility(type);

    clearRequiredAttributes();
    applyRequiredAttributes(type);
};

/**
 * Atualiza o número de parcelas renderizadas conforme o select.
 */
export const handleInstallmentsSelectChange = () => {
    const select = document.getElementById('inform-installments-select');
    const value = parseInt(select.value);
    renderInstallments(value);
};

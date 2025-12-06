import { installmentTypeField } from "./main.js";

/**
 * Retorna os campos obrigatórios conforme o tipo de parcela.
 */
const getRequiredFields = () => {
    const ids = [
        'cnpj-input',
        'negotiation-type-field',
        'warranted-value-field',
        'installment-type-field'
    ];

    const type = installmentTypeField.value;

    if (type === 'single') {
        ids.push('single-installment-days-field');
    } else if (type === 'multiple') {
        ids.push('multiple-installments-days-field', 'inform-installments-select');
    }

    return ids;
};

/**
 * Verifica se todos os campos obrigatórios têm valor preenchido.
 */
const isFormValid = () => {
    const requiredIds = getRequiredFields();

    for (const id of requiredIds) {
        const el = document.getElementById(id);
        if (!el || !el.value || el.value.trim() === '') return false;
    }

    if (installmentTypeField.value === 'multiple') {
        const installmentInputs = document.querySelectorAll('[name^="installment_interest["]');
        for (const input of installmentInputs) {
            if (!input.value || input.value.trim() === '') return false;
        }
    }

    return true;
};


/**
 * Atualiza a cor do botão conforme a validade do formulário.
 */
export const updateSubmitButtonState = () => {
    const button = document.getElementById('submit-button');
    if (!button) return;

    const valid = isFormValid();
    button.style.backgroundColor = valid ? '#69549F' : '#9E9E9E';
};

/**
 * Registra listeners para monitorar mudanças e validar dinamicamente.
 */
export const attachLiveValidation = () => {
    const form = document.getElementById('execute-operation-form');
    if (!form) return;

    // eventos comuns de mudança
    form.addEventListener('input', updateSubmitButtonState);
    form.addEventListener('change', updateSubmitButtonState);
};

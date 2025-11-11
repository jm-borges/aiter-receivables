import { showMessage } from "./dom.js";

const getOperationForm = () => document.getElementById('execute-operation-form');

const validateRequiredFields = (form) => {
    const requiredFields = form.querySelectorAll('[required]');
    const missing = [];

    requiredFields.forEach(field => {
        const isEmpty = !field.value || field.value.trim() === '';
        field.classList.toggle('field-error', isEmpty);
        if (isEmpty) missing.push(field);
    });

    return missing;
};

export const handleSubmitButtonClick = (event) => {
    event.preventDefault();

    const form = getOperationForm();
    if (!form) return;

    showMessage('');

    const missing = validateRequiredFields(form);
    if (missing.length > 0) {
        showMessage('Preencha todos os campos obrigatórios antes de enviar.');
        missing[0].focus();
        return;
    }

    form.submit();
};

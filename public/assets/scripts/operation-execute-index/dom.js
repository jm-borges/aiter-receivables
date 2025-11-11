import { formatCurrency } from "../common/utils.js";
import { buildInstallmentTemplate } from "./templates.js";

export const showMessage = (msg) => {
    const resultDiv = document.getElementById('cnpj-result');
    if (resultDiv) resultDiv.textContent = msg;
};

export const renderReceivables = (data) => {
    const map = {
        received: 'received-values',
        to_be_received: 'to-be-received-values',
        locked: 'locked-values',
        locked_by_others: 'locked-by-others-values',
        free: 'free-values',
    };

    Object.entries(map).forEach(([key, id]) => {
        const container = document.getElementById(id);
        const el = container?.querySelector('.form-item-value');
        if (el) el.textContent = formatCurrency(data[key]);
    });
};

export const toggleInstallmentContainers = (type) => {
    const single = document.getElementById('single-installment-container');
    const multiple = document.getElementById('multiple-installment-container');

    single.style.display = type === 'single' ? 'block' : 'none';
    multiple.style.display = type === 'multiple' ? 'block' : 'none';
};

export const renderInstallments = (count) => {
    const informContainer = document.getElementById('inform-installments-container');
    const installmentsContainer = document.getElementById('installments-container');

    installmentsContainer.innerHTML = '';
    if (!count || isNaN(count)) {
        informContainer.style.display = 'none';
        return;
    }

    informContainer.style.display = 'block';
    for (let i = 0; i < count; i++) {
        const div = document.createElement('div');
        div.style.display = 'flex';
        div.style.marginTop = '10px';
        div.innerHTML = buildInstallmentTemplate(i);
        installmentsContainer.appendChild(div);
    }
};

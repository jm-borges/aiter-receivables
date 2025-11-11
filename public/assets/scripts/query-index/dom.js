import { formatCurrency } from "../common/utils.js";

export const input = document.querySelector('.form-search-text-field');
export const select = document.querySelector('.form-select');
export const receivablesSection = document.getElementById('receivables-section');
export const defaultsSection = document.getElementById('defaults-section');

export const toggleSections = (visible) => {
    [receivablesSection, defaultsSection].forEach(sec => {
        if (sec) sec.style.display = visible ? '' : 'none';
    });
};

export const renderOptions = (partners) => {
    select.innerHTML = '<option value="">Selecione uma empresa</option>';
    partners.forEach(p => {
        const o = document.createElement('option');
        o.value = p.id;
        o.textContent = p.name || p.business_name;
        select.appendChild(o);
    });
};

export const setLoading = (loading) => {
    document.getElementById('loading-message')?.remove();
    if (loading)
        select.insertAdjacentHTML(
            'afterend',
            '<div id="loading-message" style="margin-top:10px;">Carregando dados...</div>'
        );
};

const updateContainerValue = (containerId, value) => {
    const container = document.getElementById(containerId);
    if (!container) return;

    const valueEl = container.querySelector('.form-item-value');
    if (valueEl) valueEl.textContent = formatCurrency(value);
};

export const renderReceivables = (data) => {
    const map = {
        received: 'received-values',
        to_be_received: 'to-be-received-values',
        locked_by_user: 'locked-by-user-values',
        locked: 'locked-values',
        free: 'free-values',
    };

    Object.entries(map).forEach(([key, id]) => {
        updateContainerValue(id, data[key]);
    });
};

export const renderDefaultInfo = (data) => {
    const map = {
        amount_due: 'amount-due',
        amount_to_be_recovered: 'amount-to-be-recovered',
        amount_recovered: 'amount-recovered',
    };

    Object.entries(map).forEach(([key, id]) => {
        updateContainerValue(id, data[key]);
    });
};

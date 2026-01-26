import { formatCurrency, formatCnpj } from "../common/utils.js";

export const searchInput = document.querySelector('[data-company-search]');
export const selectField = document.querySelector('[data-company-select]');

export const receivablesSection = document.getElementById('receivables-section');
export const defaultsSection = document.getElementById('defaults-section');

export const receivablesContent = document.getElementById('receivables-content');
export const receivablesEmpty = document.getElementById('receivables-empty');

export const setReceivablesMode = (hasCompany) => {
    if (!receivablesContent || !receivablesEmpty) return;

    receivablesContent.style.display = hasCompany ? 'flex' : 'none';
    receivablesEmpty.style.display = hasCompany ? 'none' : 'block';
};

export const setDefaultsMode = (hasCompany) => {
    const content = document.getElementById('payment-default-content');
    const empty = document.getElementById('payment-default-empty');

    if (!content || !empty) return;

    content.style.display = hasCompany ? 'flex' : 'none';
    empty.style.display = hasCompany ? 'none' : 'block';
};


export const toggleSections = (visible) => {
    [receivablesSection, defaultsSection].forEach(sec => {
        if (sec) sec.style.display = visible ? '' : 'none';
    });
};

export const renderOptions = (partners) => {
    if (!selectField) return;

    selectField.innerHTML = '<option value="">Selecione uma empresa</option>';

    partners.forEach(p => {
        const o = document.createElement('option');
        o.value = p.id;

        const name = p.name || p.business_name || '—';
        const cnpjFormatted = formatCnpj(p.document_number);

        if (cnpjFormatted) {
            o.textContent = `${name} — ${cnpjFormatted}`;
        } else {
            o.textContent = name;
        }

        selectField.appendChild(o);
    });
};

export const setLoading = (loading) => {
    document.getElementById('loading-message')?.remove();

    if (loading && selectField) {
        selectField.insertAdjacentHTML(
            'afterend',
            '<div id="loading-message" class="conciliation-loading-message">Carregando dados...</div>'
        );
    }
};

export const setPartnersLoading = (isLoading) => {
    if (!selectField) return;

    selectField.disabled = isLoading;

    if (isLoading) {
        selectField.innerHTML = `<option value="">Carregando empresas...</option>`;
    }
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

import { debounce } from './utils.js';

export const initCompanySelector = ({
    fetchList,
    onSelect,
    formatOption
}) => {
    const searchInput = document.querySelector('[data-company-search]');
    const selectField = document.querySelector('[data-company-select]');

    if (!searchInput || !selectField) return;

    const setLoading = (isLoading) => {
        selectField.disabled = isLoading;
        if (isLoading) {
            selectField.innerHTML = `<option value="">Carregando...</option>`;
        }
    };

    const renderOptions = (items) => {
        selectField.innerHTML = `<option value="">Selecione...</option>`;

        items.forEach(item => {
            const o = document.createElement('option');
            o.value = item.id;
            o.textContent = formatOption(item);
            selectField.appendChild(o);
        });
    };

    const load = async (q = '') => {
        try {
            setLoading(true);
            const { data } = await fetchList(q);
            renderOptions(data);
        } finally {
            setLoading(false);
        }
    };

    const handleInput = debounce(async ({ target }) => {
        await load(target.value.trim());
    }, 400);

    const handleSelect = async ({ target }) => {
        const id = target.value;
        if (!id) return;
        await onSelect(id);
    };

    searchInput.addEventListener('input', handleInput);
    selectField.addEventListener('change', handleSelect);

    // carga inicial
    load();
};

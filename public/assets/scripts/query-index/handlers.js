
import { debounce } from '../common/utils.js';
import { fetchPartners, fetchPartnerReceivablesDetails, fetchPartnerContractsPaymentsDetails } from './api.js';
import { input, select, toggleSections, renderOptions, setLoading, renderReceivables, renderDefaultInfo } from './dom.js';

const handleInput = debounce(async ({ target }) => {
    const q = target.value.trim();
    if (!q) return;
    try {
        const { data } = await fetchPartners(q);
        renderOptions(data);
    } catch (e) {
        console.error(e);
    }
}, 400);

const handleSelect = async ({ target }) => {
    const id = target.value;
    if (!id) return toggleSections(false);
    try {
        setLoading(true);
        const receivablesData = await fetchPartnerReceivablesDetails(id);
        const contractsPaymentsData = await fetchPartnerContractsPaymentsDetails(id);
        setLoading(false);
        console.log('Dados recebidos:', receivablesData);
        console.log('Dados recebidos:', contractsPaymentsData);
        renderReceivables(receivablesData);
        renderDefaultInfo(contractsPaymentsData);
        toggleSections(true);
    } catch (e) {
        setLoading(false);
        console.error(e);
    }
};

export const registerEventHandlers = () => {
    toggleSections(false);
    if (input && select) {
        input.addEventListener('input', handleInput);
        select.addEventListener('change', handleSelect);
    }

};

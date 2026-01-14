
import { debounce } from '../common/utils.js';
import { fetchPartners, fetchPartnerReceivablesDetails, fetchPartnerContractsPaymentsDetails } from './api.js';
import { input, select, toggleSections, renderOptions, setLoading, renderReceivables, renderDefaultInfo, setReceivablesMode } from './dom.js';

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

    // Nenhuma empresa selecionada
    if (!id) {
        toggleSections(true);
        setReceivablesMode(false);   // modo "empty" da seção de status
        setDefaultsMode(false);      // modo "empty" da seção de inadimplência
        return;
    }

    try {
        setLoading(true);

        const receivablesData = await fetchPartnerReceivablesDetails(id);
        const contractsPaymentsData = await fetchPartnerContractsPaymentsDetails(id);

        setLoading(false);

        // se empresa selecionada:
        renderReceivables(receivablesData);
        renderDefaultInfo(contractsPaymentsData);

        toggleSections(true);
        setReceivablesMode(true); // modo "com empresa"
        setDefaultsMode(true);    // modo "com empresa"

    } catch (e) {
        setLoading(false);
        console.error(e);
    }
};


export const registerEventHandlers = () => {
    if (input && select) {
        input.addEventListener('input', handleInput);
        select.addEventListener('change', handleSelect);
    }

};

import { initCompanySelector } from '../common/company-selector.js';
import { formatCnpj } from '../common/utils.js';
import { fetchPartners, fetchPartnerReceivablesDetails, fetchPartnerContractsPaymentsDetails } from './api.js';
import {
    toggleSections,
    setLoading,
    renderReceivables,
    renderDefaultInfo,
    setReceivablesMode,
    setDefaultsMode,
} from './dom.js';

export const registerEventHandlers = () => {
    initCompanySelector({
        fetchList: fetchPartners,

        formatOption: (p) => {
            const name = p.name || p.business_name || '—';
            const cnpj = formatCnpj(p.document_number);;
            return cnpj ? `${name} | ${cnpj}` : name;
        },

        onSelect: async (id) => {
            setReceivablesMode(false);
            setDefaultsMode(false);
            toggleSections(false);

            setLoading(true);

            const receivablesData = await fetchPartnerReceivablesDetails(id);
            const contractsPaymentsData = await fetchPartnerContractsPaymentsDetails(id);

            renderReceivables(receivablesData);
            renderDefaultInfo(contractsPaymentsData);

            setLoading(false);

            setReceivablesMode(true);
            setDefaultsMode(true);
            toggleSections(true);
        }
    });
};

setReceivablesMode(false);
setDefaultsMode(false);
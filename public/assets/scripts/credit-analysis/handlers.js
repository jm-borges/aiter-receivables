import { initCompanySelector } from '../common/company-selector.js';
import { formatCnpj } from '../common/utils.js';
import { fetchPartners } from '../conciliation/api.js';
import { fetchCreditAnalysis } from './api.js';

import {
    renderBankDebtEvolutionChart,
    renderBankDebtProfileChart,
    renderBankDebts,
    renderBasicInfo,
    renderPaymentsVsRevenueChart,
    renderWarrantyAvailability,
    renderWarrantyEvolutionChart
} from './renderers/index.js';

export const registerEventHandlers = () => {
    const container = document.getElementById('credit-analysis-data-container');
    const resultBox = document.getElementById('cnpj-result');

    initCompanySelector({
        fetchList: fetchPartners,

        formatOption: (p) => {
            const name = p.name || p.business_name || '—';
            const cnpj = formatCnpj(p.document_number);;
            return cnpj ? `${name} | ${cnpj}` : name;
        },

        onSelect: async (id) => {
            container.classList.add('hidden');

            if (window.receivablesCalendar) {
                window.receivablesCalendar.reset();
            }

            const response = await fetchCreditAnalysis(id);

            renderBasicInfo(resultBox, response);
            renderWarrantyAvailability(response);
            renderBankDebts(response);
            renderWarrantyEvolutionChart(response);
            renderPaymentsVsRevenueChart(response);
            renderBankDebtEvolutionChart(response);
            renderBankDebtProfileChart(response);

            container.classList.remove('hidden');
        }
    });
};

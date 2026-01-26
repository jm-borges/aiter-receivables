import { initCompanySelector } from "../common/company-selector.js";
import { formatCnpj } from "../common/utils.js";
import { fetchPartners } from "../conciliation/api.js";
import { fetchReceivables } from "./api.js";
import { renderReceivables, showMessage } from "./dom.js";

export const initOperationCompanySelector = () => {
    initCompanySelector({
        fetchList: fetchPartners,

        formatOption: (p) => {
            const name = p.name || p.business_name || '—';
            const cnpj = formatCnpj(p.document_number);;
            return cnpj ? `${name} | ${cnpj}` : name;
        },

        onSelect: async (id) => {
            showMessage('Buscando...');

            try {
                if (window.receivablesCalendar) {
                    window.receivablesCalendar.reset();
                }

                const data = await fetchReceivables(id);

                document.getElementById('operation-info-fields-container').style.display = 'flex';
                showMessage('');
                renderReceivables(data);

            } catch (err) {
                console.error(err);
                showMessage('Erro ao buscar informações.');
            }
        }
    });
};

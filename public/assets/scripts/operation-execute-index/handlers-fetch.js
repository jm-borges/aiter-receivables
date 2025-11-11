import { fetchReceivablesByCnpj } from "./api.js";
import { renderReceivables, showMessage } from "./dom.js";

export const handleFetchCnpj = async () => {
    const cnpj = document.getElementById('cnpj-input')?.value.trim();
    if (!cnpj) return showMessage('Informe um CNPJ válido.');

    showMessage('Buscando...');
    try {
        const data = await fetchReceivablesByCnpj(cnpj);
        document.getElementById('operation-info-fields-container').style.display = 'flex';
        showMessage('');
        renderReceivables(data);
    } catch (err) {
        console.error(err);
        showMessage('Erro ao buscar informações.');
    }
};

import { fetchCreditAnalysisByCnpj } from './api.js';
import {
    renderBasicInfo,
    renderWarrantyAvailability,
    renderBankDebts
} from './renderers.js';


export const registerEventHandlers = () => {
    const input = document.getElementById('credit-analysis-cnpj-input');
    const button = document.getElementById('credit-analysis-fetch-cnpj');
    const resultBox = document.getElementById('cnpj-result');
    const container = document.getElementById('credit-analysis-data-container');

    if (!button) return;

    button.addEventListener('click', () =>
        handleButtonClick(input, resultBox, container)
    );
};

/* ---------------------- FUNÇÕES AUXILIARES ---------------------- */

function handleButtonClick(input, resultBox, container) {
    const cnpj = input.value.trim();

    clearUI(resultBox, container);

    if (!cnpj) {
        showError(resultBox, 'Digite um CNPJ válido.');
        return;
    }

    loadCreditAnalysis(cnpj, resultBox, container);
}

function clearUI(resultBox, container) {
    resultBox.innerHTML = '';
    container.classList.add('hidden');
}

function showError(resultBox, message) {
    resultBox.innerHTML = `<div style="color:#b00">${message}</div>`;
}

async function loadCreditAnalysis(cnpj, resultBox, container) {
    resultBox.innerHTML = `Buscando…`;

    try {
        const response = await fetchCreditAnalysisByCnpj(cnpj);
        console.log("RESULTADO DA API", response);

        renderBasicInfo(resultBox, response);
        renderWarrantyAvailability(response);
        renderBankDebts(response);

        container.classList.remove('hidden');

    } catch (error) {
        console.error(error);
        showError(resultBox, "Erro ao buscar dados. Tente novamente.");
    }
}


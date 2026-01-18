import { renderLineChart } from "./lineChart.js";


export function renderBankDebtEvolutionChart(data) {
    const chartData = data.bank_debt_evolution;
    if (!chartData) return;

    const container = document.getElementById('bank-debt-evolution-chart-container');
    if (!container) return;

    const { labels, series } = chartData;

    if (!Array.isArray(labels) || !Array.isArray(series)) {
        container.innerHTML = `<div class="text-sm text-gray-500">Dados inválidos para o gráfico.</div>`;
        return;
    }

    renderLineChart(container, {
        labels,
        series,
        height: 240,
        valueFormatter: v => {
            if (v >= 1000) return (v / 1000).toFixed(0) + 'k';
            return String(v);
        }
    });

}


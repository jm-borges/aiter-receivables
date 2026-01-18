import { renderLineChart } from "./lineChart.js";

export function renderPaymentsVsRevenueChart(data) {
    const chartData = data.payments_vs_revenue;
    if (!chartData) return;

    const container = document.getElementById('payments-vs-revenue-chart-container');
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
        valueFormatter: v => `${v}k`
    });

}

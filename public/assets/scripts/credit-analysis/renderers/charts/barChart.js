export function renderBarChart({
    containerId,
    items,
    valueFormatter,
    labelFormatter,
    heightCalculator, // (item, max) => percent
    barColor,
    barWidthClass = "w-6",
    showEmptyMessage = "Sem dados para exibir."
}) {
    const chartEl = document.getElementById(containerId);
    if (!chartEl) return;

    if (!Array.isArray(items) || items.length === 0) {
        chartEl.innerHTML = `<div class="text-sm text-gray-500">${showEmptyMessage}</div>`;
        return;
    }

    chartEl.innerHTML = "";

    const max = Math.max(...items.map(i => Number(i.value) || 0));

    for (const item of items) {
        const value = Number(item.value) || 0;
        const heightPercent = heightCalculator(value, max, item);

        const barWrapper = document.createElement("div");
        barWrapper.className = "flex flex-col items-center justify-end h-full flex-1";

        const valueEl = document.createElement("div");
        valueEl.className = "text-xs font-semibold mb-1";
        valueEl.textContent = valueFormatter(value, item);

        const barEl = document.createElement("div");
        barEl.className = `${barWidthClass} rounded-full transition-all`;
        barEl.style.height = `${heightPercent}%`;
        barEl.style.background = typeof barColor === "function" ? barColor(item) : barColor;

        const labelEl = document.createElement("div");
        labelEl.className = "text-xs mt-2 text-center leading-tight text-gray-600";
        labelEl.innerHTML = labelFormatter(item);

        barWrapper.appendChild(valueEl);
        barWrapper.appendChild(barEl);
        barWrapper.appendChild(labelEl);

        chartEl.appendChild(barWrapper);
    }
}

import { renderBarChart } from "./barChart.js";

export function renderBankDebtProfileChart(data) {
    const profile = data.bank_debt_profile;

    renderBarChart({
        containerId: "bank-debt-profile-chart",
        items: profile,
        barWidthClass: "w-full max-w-[32px]",
        barColor: "#6b57b5",

        valueFormatter: (value) => `${Math.round(value)}%`,

        labelFormatter: (item) => item.label || "",

        heightCalculator: (value) =>
            Math.max(0, Math.min(100, value))
    });
}

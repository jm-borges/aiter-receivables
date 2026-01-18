import { formatCompact } from "../../utils/format.js";
import { renderBarChart } from "./barChart.js";

export function renderWarrantyEvolutionChart(data) {
    const history = data.warranty_history;

    renderBarChart({
        containerId: "warranty-evolution-chart",
        items: history,
        barWidthClass: "w-6",
        barColor: (item) => item.is_today ? "#1b0f3b" : "#6b57b5",

        valueFormatter: (value) => formatCompact(value),

        labelFormatter: (item) =>
            (item.label || "").replace(" ", "<br>"),

        heightCalculator: (value, max) =>
            max > 0 ? (value / max) * 100 : 0
    });

    // Rodapé
    const updatedAtEl = document.getElementById("warranty-evolution-updated-at");
    if (updatedAtEl) {
        const now = new Date();
        updatedAtEl.textContent =
            "Última atualização " +
            now.toLocaleDateString("pt-BR") +
            " às " +
            now.toLocaleTimeString("pt-BR", { hour: "2-digit", minute: "2-digit" });
    }
}

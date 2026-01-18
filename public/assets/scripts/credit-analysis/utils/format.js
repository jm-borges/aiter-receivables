
export function formatCurrency(value) {
    if (value == null) return "R$ 0,00";

    return Number(value).toLocaleString("pt-BR", {
        style: "currency",
        currency: "BRL"
    });
}

export function formatCompact(value) {
    if (value >= 1000000) return (value / 1000000).toFixed(1).replace(".", ",") + "M";
    if (value >= 1000) return Math.round(value / 1000) + "k";
    return String(value);
}

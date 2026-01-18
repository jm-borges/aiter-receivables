import { setValue } from "../utils/dom.js";

export function renderMetricMap(map, dataRoot) {
    for (const [id, path] of Object.entries(map)) {
        setValue(id, path.split(".").reduce((o, k) => o?.[k], dataRoot));
    }
}

export function renderWarrantyAvailability(data) {
    renderMetricMap({
        "warranty-free": "warranty.free",
        "warranty-receivable": "warranty.receivable",
        "warranty-locked": "warranty.locked",
        "payables-total": "payables.total",
        "receivables-total": "receivables.total",
    }, data);
}

export function renderBankDebts(data) {
    renderMetricMap({
        "bank-limit-total": "bank.limit_total",
        "bank-limit-used": "bank.limit_used",
        "bank-limit-available": "bank.limit_available",
    }, data);
}


import { formatCurrency } from "./format.js";

export function setValue(id, value) {
    const el = document.querySelector(`#${id} .form-item-value`);
    if (el) el.textContent = formatCurrency(value);
}

export function renderBasicInfo(resultBox, data) {
    resultBox.innerHTML = `
        <div style="margin-top: 10px; color:#211748;">
            <strong>Razão Social:</strong> ${data.company_name ?? '—'}<br>
        </div>
    `;
}

export function renderWarrantyAvailability(data) {
    setValue("warranty-free", data.warranty?.free);
    setValue("warranty-receivable", data.warranty?.receivable);
    setValue("warranty-locked", data.warranty?.locked);

    setValue("payables-total", data.payables?.total);
    setValue("receivables-total", data.receivables?.total);
}

export function renderBankDebts(data) {
    setValue("bank-limit-total", data.bank?.limit_total);
    setValue("bank-limit-used", data.bank?.limit_used);
    setValue("bank-limit-available", data.bank?.limit_available);
}

/* Util */
function setValue(id, value) {
    const el = document.querySelector(`#${id} .form-item-value`);
    if (el) el.textContent = formatCurrency(value);
}

function formatCurrency(value) {
    if (value == null) return "R$ 0,00";

    return Number(value).toLocaleString("pt-BR", {
        style: "currency",
        currency: "BRL"
    });
}

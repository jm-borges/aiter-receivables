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

    setupWarrantyCalendarButtons(data);
}

export function renderBankDebts(data) {
    renderMetricMap({
        "bank-limit-total": "bank.limit_total",
        "bank-limit-used": "bank.limit_used",
        "bank-limit-available": "bank.limit_available",
    }, data);
}

function setupWarrantyCalendarButtons(data) {
    const companyId = data.company_id || data.company?.id || data.id;
    if (!companyId) return;

    const buttons = [
        { id: 'btn-warranty-free-schedule', calendarId: 'receivables', type: 'free' },
        { id: 'btn-warranty-cards-revenue-schedule', calendarId: 'cards-revenue', type: 'receivable' }
    ];

    for (const btnCfg of buttons) {
        const btn = document.getElementById(btnCfg.id);
        if (!btn) continue;

        btn.dataset.openCalendar = btnCfg.calendarId;
        btn.dataset.calendarContext = JSON.stringify({
            partnerId: companyId,
            type: btnCfg.type
        });
    }
}

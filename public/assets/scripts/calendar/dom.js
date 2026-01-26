export function getDomRefs() {
    const dom = {
        overlay: document.getElementById('receivables-modal-overlay'),
        closeBtn: document.getElementById('receivables-modal-close'),
        grid: document.getElementById('receivables-calendar-grid'),
        title: document.getElementById('receivables-calendar-title'),
        prevBtn: document.getElementById('calendar-prev-month'),
        nextBtn: document.getElementById('calendar-next-month'),
    };

    if (Object.values(dom).some(v => !v)) return null;

    return dom;
}

export function bindCalendarModal({ id, calendar }) {

    const overlay = document.getElementById(`${id}-calendar-modal-overlay`);
    const closeBtn = document.getElementById(`${id}-calendar-modal-close`);

    if (!overlay) return;

    document.addEventListener('click', async (e) => {
        const btn = e.target.closest(`[data-open-calendar="${id}"]`);
        if (!btn) return;

        const context = JSON.parse(btn.dataset.calendarContext || '{}');

        overlay.style.display = 'flex';

        await calendar.reload(context);
    });

    closeBtn.addEventListener('click', () => {
        overlay.style.display = 'none';
    });

    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) {
            overlay.style.display = 'none';
        }
    });
}

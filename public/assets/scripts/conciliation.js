function initReceivablesModal() {
    const overlay = document.getElementById('receivables-modal-overlay');
    const closeBtn = document.getElementById('receivables-modal-close');

    if (!overlay || !closeBtn) return;

    // Abrir modal (delegação de evento)
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.conciliation-open-receivables-modal');
        if (!btn) return;

        const partnerId = btn.dataset.partnerId;
        console.log('Abrir modal para partner:', partnerId);

        overlay.classList.remove('hidden');
        overlay.classList.add('flex');
    });

    function closeModal() {
        overlay.classList.add('hidden');
        overlay.classList.remove('flex');
    }

    // Fechar no X
    closeBtn.addEventListener('click', closeModal);

    // Fechar clicando fora
    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) {
            closeModal();
        }
    });
}

function initCollapsibleSection(prefix) {
    const toggle = document.getElementById(`${prefix}-toggle`);
    const content = document.getElementById(`${prefix}-content`);
    const empty = document.getElementById(`${prefix}-empty`);
    const arrow = document.getElementById(`${prefix}-arrow`);

    if (!toggle || !content || !empty || !arrow) return;

    // 🔒 FORÇA COMEÇAR FECHADO
    content.style.display = 'none';
    empty.style.display = 'none';
    arrow.classList.remove('rotate-180');

    toggle.addEventListener('click', () => {
        const contentVisible = content.style.display !== 'none';
        const emptyVisible = empty.style.display !== 'none';

        const isOpen = contentVisible || emptyVisible;

        // Fecha ambos
        content.style.display = 'none';
        empty.style.display = 'none';

        if (!isOpen) {
            // Decide o que reabrir baseado no "modo" atual
            const shouldShowContent = content.dataset.active === '1';

            if (shouldShowContent) {
                content.style.display = 'flex';
            } else {
                empty.style.display = 'block';
            }
        }

        arrow.classList.toggle('rotate-180', !isOpen);
    });
}



document.addEventListener('DOMContentLoaded', () => {
    initReceivablesModal();

    initCollapsibleSection('receivables');
    initCollapsibleSection('payment-default');
});

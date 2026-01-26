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

        // depois vamos usar esse ID pra carregar dados

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

    toggle.addEventListener('click', () => {
        const contentIsVisible = !content.classList.contains('hidden');
        const emptyIsVisible = !empty.classList.contains('hidden');

        const isOpen = contentIsVisible || emptyIsVisible;

        content.classList.add('hidden');
        empty.classList.add('hidden');

        if (!isOpen) {
            const elToOpen =
                contentIsVisible || (!contentIsVisible && !emptyIsVisible)
                    ? content
                    : empty;

            elToOpen.classList.remove('hidden');
        }

        arrow.classList.toggle('rotate-180', !isOpen);
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initReceivablesModal();

    initCollapsibleSection('receivables');
    initCollapsibleSection('payment-default');
});

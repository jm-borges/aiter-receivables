import { state } from './state.js';

export function createModal(dom, dataLoader) {
    return {
        async open(partnerId) {
            dom.overlay.style.display = 'flex';
            state.currentPartnerId = partnerId;
            await dataLoader.load(partnerId);
        },

        close() {
            dom.overlay.style.display = 'none';
        },

        bind() {
            document.addEventListener('click', async (e) => {
                const btn = e.target.closest('.open-receivables-modal');
                if (!btn) return;

                await this.open(btn.dataset.partnerId);
            });

            dom.closeBtn.addEventListener('click', () => this.close());

            dom.overlay.addEventListener('click', (e) => {
                if (e.target === dom.overlay) this.close();
            });
        }
    };
}

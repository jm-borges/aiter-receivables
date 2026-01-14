<div id="defaults-section" style="display: block">
    <div class="form-section-title" style="display: flex; justify-content: space-between; cursor: pointer;"
        id="payment-default-toggle">
        <span>Operações de Inadimplentes</span>
        <span id="payment-default-arrow" style="transition: transform 0.2s ease;color:white">
            <!-- seta pra baixo -->
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none">
                <path d="M6 9L12 15L18 9" stroke="white" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </span>
    </div>

    <hr class="form-section-divider">

    {{-- Estado: nenhuma empresa selecionada --}}
    <div id="payment-default-empty" style="display: none; margin-top: 20px;">
        <x-receivables-query.general-defaults-table :partners="$partners" />
    </div>

    {{-- Estado: empresa selecionada --}}
    <div id="payment-default-content" style="display: none; margin-top: 20px;">
        <x-common.form-item-card id="amount-due" icon="/assets/images/Cash.png" title="Valor devido" value="R$ 0,00" />
        <x-common.form-item-card id="amount-to-be-recovered" icon="/assets/images/Coin.png" title="Valor a recuperar"
            value="R$ 0,00" marginLeft="10" />
        <x-common.form-item-card id="amount-recovered" icon="/assets/images/Check2Square.png" title="Valor recuperado"
            value="R$ 0,00" marginLeft="10" />
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toggle = document.getElementById('payment-default-toggle');
        const content = document.getElementById('payment-default-content');
        const arrow = document.getElementById('payment-default-arrow');
        const empty = document.getElementById('payment-default-empty');

        if (!toggle || !content || !arrow) return;

        toggle.addEventListener('click', () => {
            const contentEl = content.style.display !== 'none' ? content : empty;
            if (!contentEl) return;

            const isOpen = contentEl.style.display !== 'none';

            content.style.display = 'none';
            empty.style.display = 'none';

            if (!isOpen) {
                contentEl.style.display = contentEl === content ? 'flex' : 'block';
            }

            arrow.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
        });
    });
</script>

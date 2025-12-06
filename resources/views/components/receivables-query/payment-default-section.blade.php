<div id="defaults-section" style="display: none">
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

    <div id="payment-default-content" style="display: none; ;margin-top: 20px">
        <x-form-item-card id="amount-due" icon="/assets/images/Cash.png" title="Valor devido" value="R$ 547.327,54" />
        <x-form-item-card id="amount-to-be-recovered" icon="/assets/images/Coin.png" title="Valor a recuperar"
            value="R$ 752.354,27" marginLeft="10" />
        <x-form-item-card id="amount-recovered" icon="/assets/images/Check2Square.png" title="Valor recuperado"
            value="R$ 752.354,27" marginLeft="10" />
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toggle = document.getElementById('payment-default-toggle');
        const content = document.getElementById('payment-default-content');
        const arrow = document.getElementById('payment-default-arrow');

        if (!toggle || !content || !arrow) return;

        toggle.addEventListener('click', () => {
            const isOpen = content.style.display === 'flex';

            content.style.display = isOpen ? 'none' : 'flex';

            // gira a seta
            arrow.style.transform = isOpen ?
                'rotate(0deg)' :
                'rotate(180deg)';
        });
    });
</script>

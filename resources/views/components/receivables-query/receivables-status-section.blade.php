<div id="receivables-section" style="display:none">
    <div class="form-section-title" style="display: flex; justify-content: space-between; cursor: pointer;"
        id="receivables-toggle">
        <span>Status de Operações</span>

        <span id="receivables-arrow" style="transition: transform 0.2s ease;color:white">
            <!-- seta pra baixo -->
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none">
                <path d="M6 9L12 15L18 9" stroke="white" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </span>
    </div>

    <hr class="form-section-divider">

    <div id="receivables-content" style="display: none; margin-top: 20px;">
        <x-common.form-item-card id="locked-by-user-values" width="513" icon="/assets/images/PiggyBank.png"
            title="Total de recebíveis performados coletados" value="R$ 0,00" />
        <x-common.form-item-card id="received-values" icon="/assets/images/CalendarCheck.png" title="Recebido"
            value="R$ 0,00" marginLeft="10" />
        <x-common.form-item-card id="to-be-received-values" icon="/assets/images/CalendarMinus.png"
            title="Falta receber" value="R$ 0,00" marginLeft="10" />
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toggle = document.getElementById('receivables-toggle');
        const content = document.getElementById('receivables-content');
        const arrow = document.getElementById('receivables-arrow');

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

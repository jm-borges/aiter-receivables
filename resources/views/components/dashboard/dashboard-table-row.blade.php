@props(['partner'])
<div class="dashboard-table-row">
    <div class="dashboard-cell">
        <img src="/assets/images/placeholder_logo.png" width="60">
    </div>

    <div class="dashboard-cell">
        <p class="dashboard-main-text">{{ $partner->fantasy_name ?? $partner->name }}</p>
        <p class="dashboard-sub-text">{{ format_document($partner->document_number) }}</p>
    </div>

    <!-- Período atual (usando locked_by_user como garantia) -->
    <div class="dashboard-cell">
        <p class="dashboard-main-text">
            R$ {{ number_format($partner->receivables_summary['locked_by_user'] ?? 0, 2, ',', '.') }}
        </p>
        <p class="dashboard-sub-text">período atual</p>
    </div>

    <!-- Total (total_operation) -->
    <div class="dashboard-cell">
        <p class="dashboard-main-text">
            R$ {{ number_format(0, 2, ',', '.') }}
        </p>
        <p class="dashboard-sub-text">Total</p>
    </div>

    <!-- Monitoring -->
    <div class="dashboard-cell">
        <x-dashboard.monitoring-cell :monitoring="$partner->monitoring ?? null" />
    </div>

    <div class="dashboard-cell relative">
        <div class="dashboard-actions flex items-center gap-2">
            <img src="/assets/images/pin.png" alt="Fixar" width="20" class="cursor-pointer">
            <button id="options-btn-{{ $partner->id }}" class="relative">
                <img src="/assets/images/options.png" alt="Opções" width="6" class="cursor-pointer">
            </button>
        </div>

        <!-- Menu popup -->
        <div id="options-menu-{{ $partner->id }}"
            class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
            <ul class="flex flex-col py-1">
                <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
                    onclick="window.location.href='/credit-analysis'">Análise de crédito</li>
                <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
                    onclick="window.location.href='/receivables/query'">Status de inadimplência</li>
                <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
                    onclick="window.location.href='/receivables/query'">Conciliação de recebíveis</li>
            </ul>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Toggle menu
        document.querySelectorAll('[id^="options-btn-"]').forEach(btn => {
            const partnerId = btn.id.replace('options-btn-', '');
            const menu = document.getElementById(`options-menu-${partnerId}`);
            if (!menu) return;

            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                menu.classList.toggle('hidden');
            });
        });

        // Fechar ao clicar fora
        document.addEventListener('click', () => {
            document.querySelectorAll('[id^="options-menu-"]').forEach(menu => {
                menu.classList.add('hidden');
            });
        });

        // Evitar fechar ao clicar dentro do menu
        document.querySelectorAll('[id^="options-menu-"]').forEach(menu => {
            menu.addEventListener('click', (e) => e.stopPropagation());
        });
    });
</script>

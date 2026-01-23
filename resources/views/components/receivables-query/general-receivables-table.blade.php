@props(['partners'])

<div class="receivables-table">

    <div class="receivables-table-header">
        <div>Empresa/CNPJ</div>
        <div>Total de recebíveis performados coletados</div>
        <div>Recebíveis a performar</div>
        <div>Total da operação</div>
        <div>Agenda</div>
    </div>

    @forelse ($partners as $partner)
        @php
            $name = $partner->fantasy_name ?: $partner->name;
            $doc = $partner->document_number;

            $summary = $partner->receivables_summary ?? [];

            // iniciais do nome
            $initials = collect(explode(' ', $name))
                ->filter()
                ->take(2)
                ->map(fn($p) => mb_strtoupper(mb_substr($p, 0, 1)))
                ->implode('');
        @endphp

        <div class="receivables-table-row">
            <div class="company-cell">
                <div class="company-avatar">{{ $initials }}</div>
                <div>
                    <div class="company-name">{{ $name }}</div>
                    <div class="company-doc">{{ format_document($doc) }}</div>
                </div>
            </div>

            {{-- Total de recebíveis performados coletados --}}
            <div class="money-cell">
                <div class="money-value">
                    {{ 'R$ ' . number_format($summary['locked_by_user'] ?? 0, 2, ',', '.') }}
                </div>
                <div class="money-sub">período atual</div>
            </div>

            {{-- Recebíveis a performar --}}
            <div class="money-cell">
                <div class="money-value">
                    {{ 'R$ ' . number_format($summary['to_be_received'] ?? 0, 2, ',', '.') }}
                </div>
                <div class="money-sub">Total</div>
            </div>

            {{-- Total da operação --}}
            <div class="money-cell">
                <div class="money-value">
                    {{ 'R$ ' . number_format($summary['total_operation'] ?? 0, 2, ',', '.') }}
                </div>
                <div class="money-sub">Total</div>
            </div>

            <button class="calendar-btn open-receivables-modal" data-partner-id="{{ $partner->id }}"
                title="Ver agenda">
                📅
            </button>

        </div>

    @empty
        <div style="padding: 20px; color: #999;">
            Nenhuma empresa encontrada.
        </div>
    @endforelse

</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const overlay = document.getElementById('receivables-modal-overlay');
        const closeBtn = document.getElementById('receivables-modal-close');

        if (!overlay || !closeBtn) return;

        // Abrir modal
        document.addEventListener('click', (e) => {
            const btn = e.target.closest('.open-receivables-modal');
            if (!btn) return;

            const partnerId = btn.dataset.partnerId;
            console.log('Abrir modal para partner:', partnerId);

            // depois vamos usar esse ID pra carregar dados

            overlay.style.display = 'flex';
        });

        // Fechar no X
        closeBtn.addEventListener('click', () => {
            overlay.style.display = 'none';
        });

        // Fechar clicando fora
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                overlay.style.display = 'none';
            }
        });
    });
</script>


<style>
    .receivables-table {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .receivables-table-header {
        display: grid;
        grid-template-columns: 2.5fr 2fr 2fr 2fr 0.7fr;
        color: #bfb8d9;
        font-size: 13px;
        padding: 0 10px;
    }

    .receivables-table-row {
        display: grid;
        grid-template-columns: 2.5fr 2fr 2fr 2fr 0.7fr;
        background: #efedf4;
        border-radius: 8px;
        padding: 12px 10px;
        align-items: center;
    }

    .company-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .company-avatar {
        width: 36px;
        height: 36px;
        border-radius: 6px;
        background: #dcd7ea;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: #3c2a7a;
    }

    .company-name {
        font-weight: 600;
        color: #2b1d55;
    }

    .company-doc {
        font-size: 12px;
        color: #7a6fa3;
    }

    .money-cell {
        display: flex;
        flex-direction: column;
    }

    .money-value {
        font-weight: 600;
        color: #2b1d55;
    }

    .money-sub {
        font-size: 12px;
        color: #7a6fa3;
    }

    .action-cell {
        display: flex;
        justify-content: center;
    }

    .calendar-btn {
        background: #6d5bd0;
        border: none;
        border-radius: 6px;
        color: white;
        width: 36px;
        height: 36px;
        cursor: pointer;
    }



    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(20, 10, 40, 0.6);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }

    .modal-container {
        background: #f3f1f8;
        border-radius: 12px;
        width: 90%;
        max-width: 800px;
        max-height: 85vh;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .modal-header {
        padding: 16px 20px;
        background: #2b1d55;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-body {
        padding: 20px;
        overflow: auto;
    }

    .modal-close-btn {
        background: transparent;
        border: none;
        color: white;
        font-size: 20px;
        cursor: pointer;
    }
</style>

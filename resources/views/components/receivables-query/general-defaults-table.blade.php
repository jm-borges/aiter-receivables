@props(['partners'])

<div class="defaults-table">

    <div class="defaults-table-header">
        <div>Empresa/CNPJ</div>
        <div>Valor devido</div>
        <div>Valor a recuperar</div>
        <div>Valor recuperado</div>
    </div>

    @forelse ($partners as $partner)
        @php
            $name = $partner->fantasy_name ?: $partner->name;
            $doc = $partner->document_number;

            $summary = $partner->defaults_summary ?? [];

            // iniciais do nome
            $initials = collect(explode(' ', $name))
                ->filter()
                ->take(2)
                ->map(fn($p) => mb_strtoupper(mb_substr($p, 0, 1)))
                ->implode('');
        @endphp

        <div class="defaults-table-row">
            <div class="company-cell">
                <div class="company-avatar">{{ $initials }}</div>
                <div>
                    <div class="company-name">{{ $name }}</div>
                    <div class="company-doc">{{ $doc }}</div>
                </div>
            </div>

            {{-- Valor devido --}}
            <div class="money-cell">
                <div class="money-value">
                    {{ $summary['amount_due'] ?? 0 }}
                </div>
                <div class="money-sub">Total</div>
            </div>

            {{-- Valor a recuperar --}}
            <div class="money-cell">
                <div class="money-value">
                    {{ $summary['amount_to_be_recovered'] ?? 0 }}
                </div>
                <div class="money-sub">Total</div>
            </div>

            {{-- Valor recuperado --}}
            <div class="money-cell">
                <div class="money-value">
                    {{ $summary['amount_recovered'] ?? 0 }}
                </div>
                <div class="money-sub">Total</div>
            </div>
        </div>

    @empty
        <div style="padding: 20px; color: #999;">
            Nenhuma empresa encontrada.
        </div>
    @endforelse

</div>

<style>
    .defaults-table {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .defaults-table-header {
        display: grid;
        grid-template-columns: 2.5fr 2fr 2fr 2fr;
        color: #bfb8d9;
        font-size: 13px;
        padding: 0 10px;
    }

    .defaults-table-row {
        display: grid;
        grid-template-columns: 2.5fr 2fr 2fr 2fr;
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
</style>

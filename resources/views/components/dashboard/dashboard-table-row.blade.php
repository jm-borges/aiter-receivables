@props(['partner'])
<div class="dashboard-table-row">
    <div class="dashboard-cell">
        <img src="/assets/images/placeholder_logo.png" width="60">
    </div>

    <div class="dashboard-cell">
        <p class="dashboard-main-text">{{ $partner->fantasy_name ?? $partner->name }}</p>
        <p class="dashboard-sub-text">{{ $partner->document_number }}</p>
    </div>

    <div class="dashboard-cell">
        <p class="dashboard-main-text">R$ 0,00</p>
        <p class="dashboard-sub-text">período atual</p>
    </div>

    <div class="dashboard-cell">
        <p class="dashboard-main-text">R$ 0,00</p>
        <p class="dashboard-sub-text">Total</p>
    </div>

    <div class="dashboard-cell">
        <div class="monitoring">
            <div class="gray-gradient-circle"></div>
            <p class="dashboard-main-text">0.0</p>
        </div>

        @php
            $hasOptIn = $partner->pivot?->opt_in_start_date && $partner->pivot?->opt_in_end_date;
        @endphp

        @if ($hasOptIn)
            <p class="dashboard-sub-text" style="margin-left: 30px;">
                Anuência ativa
            </p>
        @else
            <p class="dashboard-sub-text" style="margin-left: 30px;">
                Sem anuência
            </p>
        @endif
    </div>

    <div class="dashboard-cell">
        <div class="dashboard-actions">
            <img src="/assets/images/pin.png" alt="Fixar" width="20">
            <img src="/assets/images/options.png" alt="Opções" width="6">
        </div>
    </div>
</div>

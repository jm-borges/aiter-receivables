@props(['partners'])

<div class="dashboard-main-table">
    @if ($partners->isNotEmpty())
        <div class="dashboard-table-header">
            <p class="dashboard-header-text">Logo</p>
            <p class="dashboard-header-text">Empresa/CNPJ</p>
            <p class="dashboard-header-text">Garantia disponível</p>
            <p class="dashboard-header-text">Dívidas bancárias tomadas</p>
            <p class="dashboard-header-text">Monitoramento</p>
            <p class="dashboard-header-text">Ação</p>
        </div>
    @endif

    @forelse ($partners as $partner)
        <x-dashboard.dashboard-table-row :partner="$partner" />
    @empty
        <div class="text-white text-center">Nenhum parceiro</div>
    @endforelse

</div>

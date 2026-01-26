@props(['partners'])

<div class="mt-10 w-full overflow-x-auto">
    @if ($partners->isNotEmpty())
        <div class="grid grid-cols-[80px_2fr_1.2fr_1.5fr_1fr_80px] items-center mb-2.5">
            <p class="font-medium text-base text-white mx-2">Logo</p>
            <p class="font-medium text-base text-white mx-2">Empresa/CNPJ</p>
            <p class="font-medium text-base text-white mx-2">Garantia disponível</p>
            <p class="font-medium text-base text-white mx-2">Dívidas bancárias tomadas</p>
            <p class="font-medium text-base text-white mx-2">Monitoramento</p>
            <p class="font-medium text-base text-white mx-2">Ação</p>
        </div>
    @endif

    @forelse ($partners as $partner)
        <x-dashboard.dashboard-table-row :partner="$partner" />
    @empty
        <div class="text-white text-center">Nenhum parceiro</div>
    @endforelse

</div>

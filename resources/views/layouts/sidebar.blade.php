<aside class="w-64 bg-custom-blue text-white border-r border-white flex flex-col">
    <div class="p-6 flex items-center justify-center border-b border-white">
        <a href="{{ route('dashboard') }}">
            <x-application-logo width="140" />
        </a>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-2">
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="dashboard">
            {{ __('Início') }}
        </x-nav-link>

        <x-nav-link :href="route('operations.execute')" :active="request()->routeIs('operations.execute')" icon="play_circle">
            {{ __('Executar operação') }}
        </x-nav-link>

        <x-nav-link :href="route('receivables.query')" :active="request()->routeIs('receivables.query')" icon="search">
            {{ __('Consulta de recebíveis') }}
        </x-nav-link>

        <x-nav-link :href="route('credit-analysis.index')" :active="request()->routeIs('credit-analysis.*')" icon="analytics">
            {{ __('Análise de crédito') }}
        </x-nav-link>

        <hr class="border-white">

        <x-nav-link :href="'/business-partners'" :active="request()->routeIs('business-partners.*')" icon="groups">
            {{ __('Parceiros') }}
        </x-nav-link>

        <x-nav-link :href="'/contracts'" :active="request()->routeIs('contracts.*')" icon="description">
            {{ __('Contratos') }}
        </x-nav-link>

        <x-nav-link :href="'/contract-payments'" :active="request()->routeIs('contracts-payments.*')" icon="payment">
            {{ __('Pagamentos') }}
        </x-nav-link>

        <x-nav-link :href="'/operations'" :active="request()->routeIs('operations.*')" icon="sync_alt">
            {{ __('Operações') }}
        </x-nav-link>
    </nav>

    <div class="p-4 border-t border-white">
        <x-nav-link :href="'/settings'" :active="request()->routeIs('settings.*')" icon="settings">
            {{ __('Configurações') }}
        </x-nav-link>

        @if (Auth::user()->isSuperAdmin())
            <x-nav-link :href="'/users'" :active="request()->routeIs('users.*')" icon="person">
                {{ __('Usuários') }}
            </x-nav-link>
        @endif

        <x-nav-link :href="route('profile.edit')" icon="account_circle" :active="request()->routeIs('profile.*')">
            {{ __('Perfil') }}
        </x-nav-link>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();"
                icon="logout">
                {{ __('Sair') }}
            </x-nav-link>
        </form>
    </div>
</aside>

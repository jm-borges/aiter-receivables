<aside class="w-64 bg-sidebar-bg text-white border-r border-white flex flex-col">
    <div class="p-8 flex items-center justify-center border-b border-page-bg">
        <a href="{{ route('dashboard') }}">
            <x-common.application-logo width="250" />
        </a>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-2">
        <x-common.nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="dashboard">
            {{ __('Início') }}
        </x-common.nav-link>

        <x-common.nav-link :href="route('operations.execute')" :active="request()->routeIs('operations.execute')" icon="play_circle">
            {{ __('Executar operação') }}
        </x-common.nav-link>

        <x-common.nav-link :href="route('receivables.query')" :active="request()->routeIs('receivables.query')" icon="search">
            {{ __('Conciliação de Operações') }}
        </x-common.nav-link>

        <x-common.nav-link :href="route('credit-analysis.index')" :active="request()->routeIs('credit-analysis.*')" icon="analytics">
            {{ __('Análise de crédito') }}
        </x-common.nav-link>

        {{--  <hr class="border-page-bg">

        <x-common.nav-link :href="'/business-partners'" :active="request()->routeIs('business-partners.*')" icon="groups">
            {{ __('Parceiros') }}
        </x-common.nav-link>

        <x-common.nav-link :href="'/contracts'" :active="request()->routeIs('contracts.*')" icon="description">
            {{ __('Contratos') }}
        </x-common.nav-link>

        <x-common.nav-link :href="'/contract-payments'" :active="request()->routeIs('contracts-payments.*')" icon="payment">
            {{ __('Pagamentos') }}
        </x-common.nav-link>

        <x-common.nav-link :href="'/operations'" :active="request()->routeIs('operations.*')" icon="sync_alt">
            {{ __('Operações') }}
        </x-common.nav-link>

        <x-common.nav-link :href="'/opt-ins'" :active="request()->routeIs('opt-ins.*')" icon="assignment_turned_in">
            {{ __('Anuências') }}
        </x-common.nav-link> --}}
    </nav>

    <div class="p-4 border-t border-page-bg">
        <x-common.nav-link :href="'/settings'" :active="request()->routeIs('settings.*')" icon="settings">
            {{ __('Configurações') }}
        </x-common.nav-link>

        @if (Auth::user()->isSuperAdmin())
            <x-common.nav-link :href="'/users'" :active="request()->routeIs('users.*')" icon="person">
                {{ __('Usuários') }}
            </x-common.nav-link>
        @endif

        <x-common.nav-link :href="route('profile.edit')" icon="account_circle" :active="request()->routeIs('profile.*')">
            {{ __('Perfil') }}
        </x-common.nav-link>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-common.nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();"
                icon="logout">
                {{ __('Sair') }}
            </x-common.nav-link>
        </form>
    </div>
</aside>

<x-app-layout>
    <x-slot name="header">
        <x-common.page-header title="Configurações" />
    </x-slot>

    <div class="py-6">
        <form method="POST" action="/settings">
            @csrf

            <div class="mb-4">
                <h1 class="text-white">
                    Nenhuma configuração disponível
                </h1>
            </div>

            <div class="mt-4">
                <x-common.primary-button>Salvar</x-common.primary-button>
            </div>
        </form>

        @if (session('status'))
            <div class="mt-4 text-green-600">
                {{ session('status') }}
            </div>
        @endif
    </div>
</x-app-layout>

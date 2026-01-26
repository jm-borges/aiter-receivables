<x-app-layout>

    <x-slot name="header">
        <div class="max-w-7xl px-4 sm:px-6 lg:px-8 py-6 flex">
            <h1 class="font-bold text-white mb-2 text-[32px]">Pagamento</h1>

            <a href="{{ route('contract-payments.create') }}"
                class="inline-flex items-center h-[35px] ml-[15px] mt-2 px-4 bg-[#69549F] border border-transparent rounded-md
                       font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700
                       focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                Novo pagamento
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-common.error-message />
            <x-common.success-message />
            <x-contract-payments.table :payments="$payments" />
        </div>
    </div>

</x-app-layout>

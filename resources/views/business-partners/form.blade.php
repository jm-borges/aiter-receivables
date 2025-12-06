<x-app-layout>

    <x-slot name="header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h1 class="text-2xl font-bold text-white mb-6">
                {{ $partner->exists ? 'Editar Parceiro' : 'Novo Parceiro' }}</h1>
            <a href="/business-partners" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition">
                Voltar
            </a>
        </div>
    </x-slot>

    {{-- Errors --}}
    @if ($errors->any())
        <div class="mb-6 rounded-md bg-red-50 p-4">
            <h2 class="text-sm font-semibold text-red-800 mb-2">Ocorreram erros:</h2>
            <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ $partner->exists ? '/business-partners/' . $partner->id : '/business-partners' }}" method="POST"
        class="space-y-6 bg-white p-6 shadow rounded-lg">
        @csrf
        @if ($partner->exists)
            @method('PUT')
        @endif

        {{-- Nome --}}
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
            <input type="text" name="name" id="name" value="{{ old('name', $partner->name) }}" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        </div>

        {{-- Nome Fantasia --}}
        <div>
            <label for="fantasy_name" class="block text-sm font-medium text-gray-700">Nome Fantasia</label>
            <input type="text" name="fantasy_name" id="fantasy_name"
                value="{{ old('fantasy_name', $partner->fantasy_name) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        </div>

        @if (Auth::user()->isSuperAdmin())
            {{-- Tipo (visível para super admin) --}}
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700">Tipo</label>
                <select name="type" id="type" required
                    class="mt-1 block w-full rounded-md border-gray-300 bg-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">Selecione</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->value }}"
                            {{ old('type', $partner->type?->value) === $type->value ? 'selected' : '' }}>
                            {{ $type->label() }}
                        </option>
                    @endforeach
                </select>
            </div>
        @else
            {{-- Tipo (oculto e fixo como client) --}}
            <div class="hidden">
                <select name="type" id="type" readonly>
                    <option value="client" selected>Client</option>
                </select>
            </div>
        @endif

        {{-- Documento --}}
        <div>
            <label for="document_number" class="block text-sm font-medium text-gray-700">Documento</label>
            <input type="text" name="document_number" id="document_number"
                value="{{ old('document_number', $partner->document_number) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $partner->email) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        </div>

        {{-- Telefone --}}
        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700">Telefone</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone', $partner->phone) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        </div>

        {{-- Endereço --}}
        <h2 class="text-lg font-semibold text-gray-800 mt-8">Endereço</h2>

        <div>
            <label for="postal_code" class="block text-sm font-medium text-gray-700">CEP</label>
            <input type="text" name="postal_code" id="postal_code"
                value="{{ old('postal_code', $partner->postal_code) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        </div>

        <div>
            <label for="address" class="block text-sm font-medium text-gray-700">Rua</label>
            <input type="text" name="address" id="address" value="{{ old('address', $partner->address) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label for="address_number" class="block text-sm font-medium text-gray-700">Número</label>
                <input type="text" name="address_number" id="address_number"
                    value="{{ old('address_number', $partner->address_number) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="address_complement" class="block text-sm font-medium text-gray-700">Complemento</label>
                <input type="text" name="address_complement" id="address_complement"
                    value="{{ old('address_complement', $partner->address_complement) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="address_neighborhood" class="block text-sm font-medium text-gray-700">Bairro</label>
                <input type="text" name="address_neighborhood" id="address_neighborhood"
                    value="{{ old('address_neighborhood', $partner->address_neighborhood) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="address_city" class="block text-sm font-medium text-gray-700">Cidade</label>
                <input type="text" name="address_city" id="address_city"
                    value="{{ old('address_city', $partner->address_city) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="address_state" class="block text-sm font-medium text-gray-700">Estado</label>
                <input type="text" name="address_state" id="address_state"
                    value="{{ old('address_state', $partner->address_state) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
        </div>

        <hr>

        @php
            $editing =
                isset($partner->pivot) && ($partner->pivot->opt_in_start_date || $partner->pivot->opt_in_end_date);
        @endphp

        <div class="mt-4">
            <label class="inline-flex items-center">
                <input type="checkbox" id="toggle_opt_in" name="enable_opt_in"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                    {{ $editing ? 'checked' : '' }}>
                <span class="ml-2 text-gray-700">
                    {{ $editing ? 'Atualizar Opt-in' : 'Realizar Opt-in' }}
                </span>
            </label>
            <p class="text-xs text-gray-500 mt-1 ml-6">
                (marcando essa opção, será feita solicitação de anuência para visualização dos recebíveis desse CNPJ)
            </p>
        </div>

        {{-- Campos de datas — começam ocultos se não estiver editando --}}
        <div id="opt_in_dates" class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-3 {{ $editing ? '' : 'hidden' }}">

            {{-- Data Início --}}
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700">Data Início do Opt-in</label>
                <input type="date" name="opt_in_start_date" id="start_date"
                    value="{{ $partner->pivot->opt_in_start_date ?? old('opt_in_start_date') }}"
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm
                focus:border-indigo-500 focus:ring-indigo-500"
                    {{ $editing ? '' : 'disabled' }}>
            </div>

            {{-- Data Fim --}}
            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700">Data Fim do Opt-in</label>
                <input type="date" name="opt_in_end_date" id="end_date"
                    value="{{ $partner->pivot->opt_in_end_date ?? old('opt_in_end_date') }}"
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm
                focus:border-indigo-500 focus:ring-indigo-500"
                    {{ $editing ? '' : 'disabled' }}>
            </div>
        </div>


        {{-- Ações --}}
        <div class="flex items-center space-x-3 pt-4">
            <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md shadow hover:bg-green-700">
                {{ $partner->exists ? 'Atualizar' : 'Cadastrar' }}
            </button>
            <a href="{{ route('business-partners.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-md shadow hover:bg-gray-300">
                Cancelar
            </a>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggle = document.getElementById('toggle_opt_in');
            const wrapper = document.getElementById('opt_in_dates');
            const inputs = wrapper.querySelectorAll('input');

            const updateState = () => {
                const checked = toggle.checked;

                // mostra/oculta container
                if (checked) {
                    wrapper.classList.remove('hidden');
                } else {
                    wrapper.classList.add('hidden');
                }

                // habilita/desabilita inputs
                inputs.forEach(input => {
                    input.disabled = !checked;
                });
            };

            toggle.addEventListener('change', updateState);

            updateState(); // inicial
        });
    </script>


</x-app-layout>

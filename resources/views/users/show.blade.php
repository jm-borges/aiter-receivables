<x-app-layout>
    <x-slot name="header">
        <x-common.page-header title="Detalhes do usuário" />
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6 space-y-6">

                {{-- Informações básicas --}}
                <div>
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Informações básicas</h2>
                    <dl class="divide-y divide-gray-200">
                        <div class="py-3 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">Nome</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{ $user->name }}</dd>
                        </div>

                        <div class="py-3 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{ $user->email }}</dd>
                        </div>

                        <div class="py-3 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">Telefone</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{ $user->phone ?? '—' }}</dd>
                        </div>

                        <div class="py-3 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">Data de nascimento</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{ $user->birth_date ?? '—' }}</dd>
                        </div>

                        <div class="py-3 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">Gênero</dt>
                            <dd class="text-sm text-gray-900 col-span-2">
                                @if ($user->gender === 'male')
                                    Masculino
                                @elseif ($user->gender === 'female')
                                    Feminino
                                @else
                                    —
                                @endif
                            </dd>
                        </div>

                        <div class="py-3 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">Super Admin</dt>
                            <dd class="text-sm text-gray-900 col-span-2">
                                {{ $user->is_super_admin ? 'Sim' : 'Não' }}
                            </dd>
                        </div>
                    </dl>
                </div>

                {{-- Fornecedor associado --}}
                <div>
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Fornecedor</h2>
                    @php
                        $supplier = $user
                            ->businessPartners()
                            ->where('type', \App\Enums\BusinessPartnerType::SUPPLIER)
                            ->first();
                    @endphp
                    <p class="text-sm text-gray-900">
                        {{ $supplier?->name ?? 'Nenhum fornecedor associado' }}
                    </p>
                </div>

                {{-- Metadados --}}
                <div>
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Outras preferências</h2>
                    <dl class="divide-y divide-gray-200">
                        <div class="py-3 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">Idioma</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{ $user->preferred_language ?? '—' }}</dd>
                        </div>

                        <div class="py-3 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">Fuso horário</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{ $user->timezone ?? '—' }}</dd>
                        </div>

                        <div class="py-3 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">Data de criação</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{ $user->created_at?->format('d/m/Y H:i') }}
                            </dd>
                        </div>
                    </dl>
                </div>

                {{-- Ações --}}
                <div class="pt-4 border-t border-gray-200 flex justify-end space-x-3">
                    <a href="{{ route('users.edit', $user) }}"
                        class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md
                               font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600
                               focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2 transition">
                        Editar
                    </a>
                    <a href="{{ route('users.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md
                               font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300
                               focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 transition">
                        Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

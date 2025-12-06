<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl  px-4 sm:px-6 lg:px-8 py-6" style="display: flex">
            <h1 class="font-bold text-white mb-2" style="font-size: 32px">Usuários</h1>
            <a href="{{ route('users.create') }}" style="height: 35px; margin-left:15px;margin-top: 8px"
                class="inline-flex items-center px-4 bg-[#69549F] border border-transparent rounded-md
                          font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700
                          focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                Novo usuário
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Mensagem de sucesso --}}
            @if (session('success'))
                <div class="mb-4 p-4 rounded-md bg-green-100 border border-green-200 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow sm:rounded-lg overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Usuário
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nome</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Email</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Telefone</th>

                                <th
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($users as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $user->phone ?? '—' }}
                                    </td>

                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex gap-3 justify-end">

                                        {{-- VER --}}
                                        <a href="{{ route('users.show', $user) }}"
                                            class="action-button bg-[#69549F] hover:bg-[#33236a]" title="Ver usuário">
                                            <img src="/assets/images/EyeFill.png" alt="Ver">
                                        </a>

                                        {{-- EDITAR --}}
                                        <a href="{{ route('users.edit', $user) }}"
                                            class="action-button bg-yellow-500 hover:bg-yellow-600"
                                            title="Editar usuário">
                                            <img src="/assets/images/Edit.png" alt="Editar">
                                        </a>

                                        {{-- REMOVER --}}
                                        <form action="{{ route('users.destroy', $user) }}" method="POST"
                                            onsubmit="return confirm('Tem certeza que deseja remover este usuário?');"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-button bg-red-600 hover:bg-red-700"
                                                title="Remover usuário">
                                                <img src="/assets/images/TrashFill.png" alt="Excluir">
                                            </button>
                                        </form>

                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                        Nenhum usuário encontrado.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="px-6 py-4 bg-gray-50">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    .action-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        /* largura fixa */
        height: 36px;
        /* altura fixa */
        padding: 4px;
        /* espaço para os ícones respirarem */
        border-radius: 6px;
        transition: 0.15s ease-in-out;
        cursor: pointer;
    }

    .action-button img {
        width: 20px;
        height: 20px;
        pointer-events: none;
    }
</style>

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Parceiros de Negócio') }}
            </h2>
            <a href="{{ route('business-partners.create') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                {{ __('Novo Parceiro') }}
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-50 p-4">
                    <p class="text-sm text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            <div class="overflow-x-auto bg-white shadow sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Nome</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Nome Fantasia</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Tipo</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Documento</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Email</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Telefone</th>
                            <th class="px-4 py-2 text-center text-sm font-semibold text-gray-700 w-44">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($partners as $partner)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $partner->name }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $partner->fantasy_name }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ ucfirst($partner->type->label()) }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $partner->document_number }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $partner->email }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $partner->phone }}</td>
                                <td class="px-4 py-2 text-center space-x-2">
                                    <a href="{{ route('business-partners.show', $partner) }}"
                                        class="inline-flex items-center px-2 py-1 text-xs font-medium rounded bg-blue-100 text-blue-800 hover:bg-blue-200">
                                        Ver
                                    </a>
                                    <a href="{{ route('business-partners.edit', $partner) }}"
                                        class="inline-flex items-center px-2 py-1 text-xs font-medium rounded bg-yellow-100 text-yellow-800 hover:bg-yellow-200">
                                        Editar
                                    </a>
                                    <form action="{{ route('business-partners.destroy', $partner) }}" method="POST"
                                        class="inline-block"
                                        onsubmit="return confirm('Tem certeza que deseja excluir este parceiro?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center px-2 py-1 text-xs font-medium rounded bg-red-100 text-red-800 hover:bg-red-200">
                                            Excluir
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-6 text-center text-gray-500 text-sm">
                                    Nenhum parceiro cadastrado.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex justify-center">
                {{ $partners->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

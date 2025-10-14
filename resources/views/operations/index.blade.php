<x-app-layout>

    <x-slot name="header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Operações</h1>
        </div>
    </x-slot>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="w-full border border-gray-200">
            <thead class="bg-gray-100 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700"></th>

                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($operations as $operation)
                    <tr>
                        <td class="px-4 py-3"></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-4 text-center text-gray-500">
                            Ainda não foram registradas Operações
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $operations->links() }}
    </div>


</x-app-layout>

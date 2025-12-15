@props(['contracts'])

<tbody class="bg-white divide-y divide-gray-200">
    @forelse ($contracts as $contract)
        <x-contracts.table-row :contract="$contract" />
    @empty
        <tr>
            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                Nenhum contrato encontrado.
            </td>
        </tr>
    @endforelse
</tbody>

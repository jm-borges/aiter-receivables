@props(['operations'])

<tbody class="bg-white divide-y divide-gray-200">
    @forelse ($operations as $operation)
        <x-operations.table-row :operation="$operation" />
    @empty
        <tr>
            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                Nenhuma operação encontrada.
            </td>
        </tr>
    @endforelse
</tbody>

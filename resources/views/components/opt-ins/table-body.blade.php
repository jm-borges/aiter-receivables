@props(['optins'])

<tbody class="bg-white divide-y divide-gray-200">
    @forelse ($optins as $optin)
        <x-opt-ins.table-row :optin="$optin" />
    @empty
        <tr>
            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                Nenhuma anuência encontrada.
            </td>
        </tr>
    @endforelse
</tbody>

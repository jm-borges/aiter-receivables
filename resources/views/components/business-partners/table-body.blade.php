@props(['partners'])

<tbody class="bg-white divide-y divide-gray-200">
    @forelse ($partners as $partner)
        <x-business-partners.table-row :partner="$partner" />
    @empty
        <tr>
            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                Nenhum parceiro encontrado.
            </td>
        </tr>
    @endforelse
</tbody>

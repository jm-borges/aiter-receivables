@props(['partner'])

<tr>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        {{ $partner->name }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
        {{ $partner->fantasy_name }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        {{ ucfirst($partner->type->label()) }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        {{ format_document($partner->document_number) }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        {{ $partner->email }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        {{ $partner->phone }}
    </td>

    <x-common.table-row-actions :model="$partner" modelTitle="parceiro" modelName="business-partners" />

</tr>

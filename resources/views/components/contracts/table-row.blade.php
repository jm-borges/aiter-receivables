@props(['contract'])

<tr>

    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
        {{ $contract->client?->name ?? '—' }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        {{ $contract->supplier?->name ?? '—' }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        {{ $contract->value }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        {{ $contract->start_date }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        {{ $contract->end_date }}
    </td>

    <x-common.table-row-actions :model="$contract" modelTitle="contrato" modelName="contracts" :showEdit="false"
        :showDelete="false" />

</tr>

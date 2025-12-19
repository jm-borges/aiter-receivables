@props(['operation'])

<tr>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
        {{ $operation->client?->name ?? '—' }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        {{ $operation->contract?->id ?? '—' }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm">
        <span class="{{ $operation->status->cssClass() }}">
            {{ $operation->status->label() }}
        </span>
    </td>

    <x-common.table-row-actions :model="$operation" modelTitle="Operation" modelName="operations" :showEdit="false"
        :showDelete="false" />
</tr>

@props(['payment'])

<tr>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        {{ $payment->name }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
        {{ $payment->fantasy_name }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        {{ ucfirst($payment->type->label()) }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        {{ format_document($payment->document_number) }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        {{ $payment->email }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        {{ $payment->phone }}
    </td>

    <x-common.table-row-actions :model="$payment" modelTitle="pagamento" modelName="'contract-payments'" />

</tr>

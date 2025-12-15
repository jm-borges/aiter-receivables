@props(['payments'])

<tbody class="bg-white divide-y divide-gray-200">
    @forelse ($payments as $payment)
        <x-contract-payments.table-row :payment="$payment" />
    @empty
        <tr>
            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                Nenhum pagamento encontrado.
            </td>
        </tr>
    @endforelse
</tbody>

@props(['optin'])

<tr>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        {{ $optin->unique_identifier ?? $optin->id }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        {{ $optin->client?->document_number ?? '—' }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        {{ $optin->acquirer?->document_number ?? '—' }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        {{ $optin->paymentArrangement ? $optin->paymentArrangement->name . '(' . $optin->paymentArrangement->code . ')' : '—' }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm">
        <span class="{{ $optin->status->cssClass() }}">
            {{ $optin->status->label() }}
        </span>
    </td>

    <x-common.table-row-actions :model="$optin" modelTitle="Opt-In" modelName="opt-ins" :showEdit="false"
        :showDelete="$optin->status === \App\Enums\OptInStatus::ACTIVE" />

</tr>

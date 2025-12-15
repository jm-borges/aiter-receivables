@props(['user'])

<tr>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        {{ $user->id }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
        {{ $user->name }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        {{ $user->email }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        {{ $user->phone ?? '—' }}
    </td>

    <x-common.table-row-actions :model="$user" modelTitle="usuário" modelName="users" />

</tr>

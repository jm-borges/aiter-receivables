@props(['users'])

<tbody class="bg-white divide-y divide-gray-200">
    @forelse ($users as $user)
        <x-users.table-row :user="$user" />
    @empty
        <tr>
            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                Nenhum usuário encontrado.
            </td>
        </tr>
    @endforelse
</tbody>

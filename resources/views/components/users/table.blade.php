@props(['users'])

<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white shadow sm:rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <x-users.table-head />
            <x-users.table-body :users="$users" />
        </table>

        <div class="px-6 py-4 bg-gray-50">
            {{ $users->links() }}
        </div>
    </div>
</div>

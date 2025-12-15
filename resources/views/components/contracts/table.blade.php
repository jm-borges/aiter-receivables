@props(['contracts'])

<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white shadow sm:rounded-lg">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <x-contracts.table-head />
                <x-contracts.table-body :contracts="$contracts" />
            </table>
        </div>

        <div class="px-6 py-4 bg-gray-50">
            {{ $contracts->links() }}
        </div>
    </div>
</div>

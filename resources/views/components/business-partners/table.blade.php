@props(['partners'])

<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white shadow sm:rounded-lg ">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <x-business-partners.table-head />
                <x-business-partners.table-body :partners="$partners" />
            </table>
        </div>

        <div class="px-6 py-4 bg-gray-50">
            {{ $partners->links() }}
        </div>
    </div>
</div>

@props(['errors'])

{{-- Errors --}}
@if ($errors->any())
    <div class="mb-6 rounded-md bg-red-50 p-4">
        <h2 class="text-sm font-semibold text-red-800 mb-2">Ocorreram erros:</h2>
        <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

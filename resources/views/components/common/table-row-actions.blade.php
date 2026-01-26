@props(['modelName', 'modelTitle', 'model', 'showView' => true, 'showEdit' => true, 'showDelete' => true])

<td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex gap-3 justify-end">
    {{-- VER --}}
    @if ($showView)
        <a href="/{{ $modelName }}/{{ $model->id }}"
            class="inline-flex items-center justify-center w-9 h-9 p-1 rounded-md transition cursor-pointer bg-[#69549F] hover:bg-[#33236a]"
            title="Ver {{ $modelTitle }}">
            <img src="/assets/images/EyeFill.png" alt="Ver" class="w-5 h-5 pointer-events-none">
        </a>
    @endif

    {{-- EDITAR --}}
    @if ($showEdit)
        <a href="/{{ $modelName }}/{{ $model->id }}/edit"
            class="inline-flex items-center justify-center w-9 h-9 p-1 rounded-md transition cursor-pointer bg-yellow-500 hover:bg-yellow-600"
            title="Editar {{ $modelTitle }}">
            <img src="/assets/images/Edit.png" alt="Editar" class="w-5 h-5 pointer-events-none">
        </a>
    @endif

    {{-- REMOVER --}}
    @if ($showDelete)
        <form action="/{{ $modelName }}/{{ $model->id }}" method="POST"
            onsubmit="return confirm('Tem certeza que deseja remover este registro?');" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="inline-flex items-center justify-center w-9 h-9 p-1 rounded-md transition cursor-pointer bg-red-600 hover:bg-red-700"
                title="Remover {{ $modelTitle }}">
                <img src="/assets/images/TrashFill.png" alt="Excluir" class="w-5 h-5 pointer-events-none">
            </button>
        </form>
    @endif
</td>

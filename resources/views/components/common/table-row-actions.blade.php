@props(['modelName', 'modelTitle', 'model', 'showView' => true, 'showEdit' => true, 'showDelete' => true])

<td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex gap-3 justify-end">
    {{-- VER --}}
    @if ($showView)
        <a href="/{{ $modelName }}/{{ $model->id }}" class="action-button bg-[#69549F] hover:bg-[#33236a]"
            title="Ver {{ $modelTitle }}">
            <img src="/assets/images/EyeFill.png" alt="Ver">
        </a>
    @endif

    {{-- EDITAR --}}
    @if ($showEdit)
        <a href="/{{ $modelName }}/{{ $model->id }}/edit" class="action-button bg-yellow-500 hover:bg-yellow-600"
            title="Editar {{ $modelTitle }}">
            <img src="/assets/images/Edit.png" alt="Editar">
        </a>
    @endif

    {{-- REMOVER --}}
    @if ($showDelete)
        <form action="/{{ $modelName }}/{{ $model->id }}" method="POST"
            onsubmit="return confirm('Tem certeza que deseja remover este registro?');" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="action-button bg-red-600 hover:bg-red-700"
                title="Remover {{ $modelTitle }}">
                <img src="/assets/images/TrashFill.png" alt="Excluir">
            </button>
        </form>
    @endif
</td>

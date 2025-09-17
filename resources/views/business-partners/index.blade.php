@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Parceiros de Negócio</h1>
            <a href="{{ route('business-partners.create') }}" class="btn btn-primary">
                Novo Parceiro
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Nome Fantasia</th>
                    <th>Tipo</th>
                    <th>Documento</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th class="text-center" style="width: 180px;">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($partners as $partner)
                    <tr>
                        <td>{{ $partner->name }}</td>
                        <td>{{ $partner->fantasy_name }}</td>
                        <td>{{ ucfirst($partner->type->label) }}</td>
                        <td>{{ $partner->document_number }}</td>
                        <td>{{ $partner->email }}</td>
                        <td>{{ $partner->phone }}</td>
                        <td class="text-center">
                            <a href="{{ route('business-partners.show', $partner) }}" class="btn btn-sm btn-info">Ver</a>
                            <a href="{{ route('business-partners.edit', $partner) }}"
                                class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('business-partners.destroy', $partner) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Tem certeza que deseja excluir este parceiro?')">
                                    Excluir
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Nenhum parceiro cadastrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $partners->links() }}
        </div>
    </div>
@endsection

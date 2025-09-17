{{-- resources/views/business-partners/form.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $partner->exists ? 'Editar Parceiro' : 'Novo Parceiro' }}</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            action="{{ $partner->exists ? route('business-partners.update', $partner) : route('business-partners.store') }}"
            method="POST">
            @csrf
            @if ($partner->exists)
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="name" class="form-label">Nome</label>
                <input type="text" name="name" id="name" class="form-control"
                    value="{{ old('name', $partner->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="fantasy_name" class="form-label">Nome Fantasia</label>
                <input type="text" name="fantasy_name" id="fantasy_name" class="form-control"
                    value="{{ old('fantasy_name', $partner->fantasy_name) }}">
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Tipo</label>
                <select name="type" id="type" class="form-select" required>
                    <option value="">Selecione</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->value }}"
                            {{ old('type', $partner->type?->value) === $type->value ? 'selected' : '' }}>
                            {{ $type->label() }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="document_number" class="form-label">Documento</label>
                <input type="text" name="document_number" id="document_number" class="form-control"
                    value="{{ old('document_number', $partner->document_number) }}">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control"
                    value="{{ old('email', $partner->email) }}">
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Telefone</label>
                <input type="text" name="phone" id="phone" class="form-control"
                    value="{{ old('phone', $partner->phone) }}">
            </div>

            {{-- Endereço --}}
            <h5 class="mt-4">Endereço</h5>

            <div class="mb-3">
                <label for="postal_code" class="form-label">CEP</label>
                <input type="text" name="postal_code" id="postal_code" class="form-control"
                    value="{{ old('postal_code', $partner->postal_code) }}">
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Rua</label>
                <input type="text" name="address" id="address" class="form-control"
                    value="{{ old('address', $partner->address) }}">
            </div>

            <div class="mb-3">
                <label for="address_number" class="form-label">Número</label>
                <input type="text" name="address_number" id="address_number" class="form-control"
                    value="{{ old('address_number', $partner->address_number) }}">
            </div>

            <div class="mb-3">
                <label for="address_complement" class="form-label">Complemento</label>
                <input type="text" name="address_complement" id="address_complement" class="form-control"
                    value="{{ old('address_complement', $partner->address_complement) }}">
            </div>

            <div class="mb-3">
                <label for="address_neighborhood" class="form-label">Bairro</label>
                <input type="text" name="address_neighborhood" id="address_neighborhood" class="form-control"
                    value="{{ old('address_neighborhood', $partner->address_neighborhood) }}">
            </div>

            <div class="mb-3">
                <label for="address_city" class="form-label">Cidade</label>
                <input type="text" name="address_city" id="address_city" class="form-control"
                    value="{{ old('address_city', $partner->address_city) }}">
            </div>

            <div class="mb-3">
                <label for="address_state" class="form-label">Estado</label>
                <input type="text" name="address_state" id="address_state" class="form-control"
                    value="{{ old('address_state', $partner->address_state) }}">
            </div>

            <button type="submit" class="btn btn-success">
                {{ $partner->exists ? 'Atualizar' : 'Cadastrar' }}
            </button>
            <a href="{{ route('business-partners.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection

{{-- resources/views/contracts/form.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ isset($contract) ? 'Editar Contrato' : 'Novo Contrato' }}</h1>

        <div class="mb-3">
            <a href="{{ route('contracts.index') }}" class="btn btn-secondary">Voltar</a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ isset($contract) ? route('contracts.update', $contract) : route('contracts.store') }}"
            method="POST">
            @csrf
            @if (isset($contract))
                @method('PUT')
            @endif

            {{-- Cliente --}}
            <div class="mb-3">
                <label for="client_id" class="form-label">Cliente</label>
                <select name="client_id" id="client_id" class="form-select" required>
                    <option value="">Selecione o cliente</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}"
                            {{ isset($contract) && $contract->client_id == $client->id ? 'selected' : '' }}>
                            {{ $client->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Fornecedor --}}
            <div class="mb-3">
                <label for="supplier_id" class="form-label">Fornecedor</label>
                <select name="supplier_id" id="supplier_id" class="form-select" required>
                    <option value="">Selecione o fornecedor</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}"
                            {{ isset($contract) && $contract->supplier_id == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Adquirentes --}}
            <div class="mb-3">
                <label for="acquirers" class="form-label">Adquirentes</label>
                <select name="acquirers[]" id="acquirers" class="form-select" multiple>
                    @foreach ($acquirers as $acquirer)
                        <option value="{{ $acquirer->id }}"
                            {{ isset($contract) && $contract->acquirers->contains($acquirer->id) ? 'selected' : '' }}>
                            {{ $acquirer->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Arranjos de Pagamento --}}
            <div class="mb-3">
                <label class="form-label">Arranjos de Pagamento</label>
                <div>
                    @foreach ($paymentArrangements as $arrangement)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="payment_arrangements[]"
                                value="{{ $arrangement->id }}"
                                {{ isset($contract) && $contract->paymentArrangements->contains($arrangement->id) ? 'checked' : '' }}>
                            <label class="form-check-label">{{ $arrangement->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Valor --}}
            <div class="mb-3">
                <label for="value" class="form-label">Valor</label>
                <input type="number" name="value" id="value" class="form-control" step="0.01"
                    value="{{ $contract->value ?? old('value') }}" required>
            </div>

            {{-- Datas --}}
            <div class="mb-3">
                <label for="start_date" class="form-label">Data Início</label>
                <input type="date" name="start_date" id="start_date" class="form-control"
                    value="{{ $contract->start_date ?? old('start_date') }}" required>
            </div>

            <div class="mb-3">
                <label for="end_date" class="form-label">Data Fim</label>
                <input type="date" name="end_date" id="end_date" class="form-control"
                    value="{{ $contract->end_date ?? old('end_date') }}">
            </div>

            <button type="submit" class="btn btn-primary">{{ isset($contract) ? 'Atualizar' : 'Salvar' }}</button>
        </form>
    </div>
@endsection

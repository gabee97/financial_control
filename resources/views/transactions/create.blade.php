@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Transaction</h1>

    {{-- Exibir erros de validação --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulário para criar transação --}}
    <form id="create_transaction" action="{{ route('transactions.store') }}" method="POST">
        @csrf {{-- Token de segurança --}}
        
        {{-- Valor da transação --}}
        <div class="mb-3">
            <label for="amount" class="form-label">Amount</label>
            <input type="text" class="form-control" id="amount" name="amount" value="{{ old('amount') }}" required>
        </div>

        {{-- Data da transação --}}
        <div class="mb-3">
            <label for="transaction_date" class="form-label">Transaction Date</label>
            <input type="date" class="form-control" id="transaction_date" name="transaction_date" value="{{ old('transaction_date') }}" required>
        </div>

        {{-- Categoria --}}
        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select class="form-control select2" id="category_id" name="category_id" required>
                <option value="">Select a Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Método de pagamento --}}
        <div class="mb-3">
            <label for="payment_method" class="form-label">Payment Method</label>
            <select class="form-control" id="payment_method" name="payment_method" required>
                <option value="D" {{ old('payment_method') == 'D' ? 'selected' : '' }}>Debit</option>
                <option value="C" {{ old('payment_method') == 'C' ? 'selected' : '' }}>Credit</option>
            </select>
        </div>

        {{-- Descrição --}}
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
        </div>

        {{-- Botões de ação --}}
        <button type="submit" class="btn btn-primary">Create Transaction</button>
        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Back to List</a>
    </form>
</div>
@endsection

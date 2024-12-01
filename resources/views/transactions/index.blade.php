{{-- resources/views/transactions/index.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Transactions</h1>

    {{-- Mensagem de sucesso --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Link para criar nova transação --}}
    <div class="mb-3">
        <a href="{{ route('transactions.create') }}" class="btn btn-primary">Add New Transaction</a>
    </div>

    {{-- Tabela de transações --}}
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Date</th>
                <th>Amount</th>
                <th>Category</th>
                <th>Payment Method</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->transaction_date }}</td>
                    <td>{{ number_format($transaction->amount, 2) }}</td>
                    <td>{{ $transaction->category->name ?? 'N/A' }}</td>
                    <td>{{ $transaction->payment_method == 'C' ? 'Credit' : 'Debit' }}</td>
                    <td>{{ $transaction->description ?? '-' }}</td>
                    <td>
                        {{-- Link para editar --}}
                        <a href="{{ route('transactions.edit', $transaction->id) }}" class="btn btn-warning btn-sm">Edit</a>

                         {{-- Botão para excluir --}}
                        <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this transaction?')">
                                Delete
                            </button>
                        </form>

                        {{-- Botão para restaurar (apenas se for soft delete) --}}
                        @if ($transaction->trashed())
                            <form action="{{ route('transactions.restore', $transaction->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success btn-sm">Restore</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No transactions found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

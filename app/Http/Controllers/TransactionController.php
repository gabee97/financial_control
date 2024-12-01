<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Exibe apenas as transações ativas (não deletadas)
        $transactions = Transaction::where('user_id', Auth::id())->get();

        return view('transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Pega as categorias disponíveis para o usuário logado
        $categories = Category::where('user_id', Auth::id())->get();

        return view('transactions.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'payment_method' => 'required|in:C,D', // C = Credit, D = Debit
        ]);

        Transaction::create([
            'amount' => $request->amount,
            'transaction_date' => $request->transaction_date,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'user_id' => Auth::id(),
            'payment_method' => $request->payment_method,
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaction created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Mostra os detalhes de uma transação específica
        $transaction = Transaction::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $transaction = Transaction::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $categories = Category::where('user_id', Auth::id())->get();

        return view('transactions.edit', compact('transaction', 'categories'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'payment_method' => 'required|in:C,D',
        ]);

        $transaction = Transaction::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $transaction->update([
            'amount' => $request->amount,
            'transaction_date' => $request->transaction_date,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'payment_method' => $request->payment_method,
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Busca a transação pelo ID e usuário autenticado
        $transaction = Transaction::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // Realiza o soft delete
        $transaction->delete();

        // Redireciona para a lista com uma mensagem de sucesso
        return redirect()->route('transactions.index')->with('success', 'Transaction deleted successfully.');
    }
    
    /**
     * Restore a logically deleted transaction.
     */
    public function restore(string $id)
    {
        $transaction = Transaction::onlyTrashed()
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $transaction->restore();

        return redirect()->route('transactions.index')->with('success', 'Transaction restored successfully.');
    }
}

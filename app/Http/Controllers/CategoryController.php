<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::where('user_id', Auth::id())->get(); // Apenas registros não deletados
        return view('categories.index', compact('categories'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create'); // Retorna a view do formulário
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:fixed,variable'
        ]);

        Category::create([
            'name' => $request->name,
            'type' => $request->type,
            'user_id' => Auth::id() // Atribui a categoria ao usuário logado
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('categories.edit', compact('category'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:fixed,variable'
        ]);

        $category = Category::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $category->update([
            'name' => $request->name,
            'type' => $request->type
        ]);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $category->delete(); // Isso agora marca como excluído logicamente

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }

}

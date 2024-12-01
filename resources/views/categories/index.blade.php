{{-- resources/views/categories/index.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Categories</h1>

    {{-- Mensagem de sucesso --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Link para criar nova categoria --}}
    <div class="mb-3">
        <a href="{{ route('categories.create') }}" class="btn btn-primary">Add New Category</a>
    </div>

    {{-- Tabela de categorias --}}
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>{{ ucfirst($category->type) }}</td>
                    <td>
                        {{-- Link para editar categoria --}}
                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        {{-- Botão para excluir categoria --}}
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No categories found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

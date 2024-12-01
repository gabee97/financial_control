{{-- resources/views/categories/create.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Category</h1>

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

    {{-- Formulário para criar categoria --}}
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf {{-- Token de segurança do Laravel --}}
        
        <div class="mb-3">
            <label for="name" class="form-label">Category Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Category Type</label>
            <select class="form-control" id="type" name="type" required>
                <option value="">Select Type</option>
                <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Fixed</option>
                <option value="variable" {{ old('type') == 'variable' ? 'selected' : '' }}>Variable</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Create Category</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Back to List</a>
    </form>
</div>
@endsection

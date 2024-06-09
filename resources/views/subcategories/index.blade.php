@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Lista de Subcategorias</div>

                <div class="card-body">
                    <a href="{{ route('subcategories.create') }}" class="btn btn-primary mb-3">Criar Nova Subcategoria</a>

                    <form method="GET" action="{{ route('subcategories.index') }}" class="mb-3">
                        <div class="input-group">
                            <select name="category_id" class="form-control">
                                <option value="">-- Selecione uma Categoria --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary ms-2">Buscar</button>
                            </div>
                        </div>
                    </form>

                    @if ($subcategories->isEmpty())
                        <p>Nenhuma subcategoria encontrada.</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Categoria</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subcategories as $subcategory)
                                    <tr>
                                        <td>{{ $subcategory->id }}</td>
                                        <td>{{ $subcategory->name }}</td>
                                        <td>{{ $subcategory->category->name }}</td>
                                        <td>
                                            <a href="{{ route('subcategories.edit', $subcategory->id) }}" class="btn btn-sm btn-primary">Editar</a>
                                            <form action="{{ route('subcategories.destroy', $subcategory->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger " onclick="return confirm('Tem certeza que deseja excluir esta subcategoria?')">Excluir</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

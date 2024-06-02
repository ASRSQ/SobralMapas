@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Lista de Categorias</h1>

        <!-- Link para criar nova categoria -->
        <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Criar Nova Categoria</a>

        <!-- Tabela de categorias -->
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                            <!-- Botões de editar e excluir -->
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-primary">Editar</a>
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta categoria?')">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

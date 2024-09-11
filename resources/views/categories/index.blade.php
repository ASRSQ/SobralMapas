@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Lista de Categorias</h1>

        <!-- Link para criar nova categoria -->
        <a href="{{ route('categories.createPage') }}" class="btn btn-primary mb-3">Criar Nova Categoria</a>

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
                        <td>{{ $category->getId() }}</td>
                        <td>{{ $category->getName() }}</td>
                        <td>
                            <!-- Botões de editar e excluir -->
                            <a href="{{ route('categories.editPage', $category->getId()) }}" class="btn btn-sm btn-primary">Editar</a>
                            <form action="{{ route('categories.delete', $category->getId()) }}" method="POST" class="d-inline">
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

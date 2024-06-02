@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Lista de Layers</div>

                <div class="card-body">
                    <a href="{{ route('layers.create') }}" class="btn btn-primary mb-3">Criar Novo Layer</a>

                    @if ($layers->isEmpty())
                    <p>Nenhum layer encontrado.</p>
                    @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Layer</th>
                                <th>Descrição</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($layers as $layer)
                            <tr>
                                <td>{{ $layer->id }}</td>
                                <td>{{ $layer->name }}</td>
                                <td>{{ $layer->layer }}</td>
                                <td>{{ $layer->description }}</td>
                                <td>
                                    <a href="{{ route('layers.edit', $layer->id) }}" class="btn btn-sm btn-primary">Editar</a>
                                    <form action="{{ route('layers.destroy', $layer->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este layer?')">Excluir</button>
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

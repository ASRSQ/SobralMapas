@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Editar Categoria</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('categories.update', $category->getId()) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Nome da Categoria:</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ $category->getName() }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">Atualizar Categoria</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

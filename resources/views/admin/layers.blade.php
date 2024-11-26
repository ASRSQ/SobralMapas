@extends('adminlte::page')

@section('title', 'Camadas')

@section('adminlte::meta_tags')
    <!-- Adiciona o CSRF Token no head -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content_header')
    <h1>Camadas</h1>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <!-- Card de criação de camada -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Criar Nova Camada</h3>
                </div>
                <div class="card-body">
                    <!-- Formulário para criar camada -->
                    <form id="layer-form" action="{{ route('admin.layers.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nome da Camada</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="form-group">
                            <label for="layer_name">Nome da Camada (Layer)</label>
                            <input type="text" class="form-control" id="layer_name" name="layer_name" required>
                        </div>

                       

                        <div class="form-group">
                            <label for="description">Descrição</label>
                            <textarea class="form-control" id="description" name="description"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="image_path">Caminho da Imagem</label>
                            <input type="text" class="form-control" id="image_path" name="image_path">
                        </div>

                        <div class="form-group">
                            <label for="max_scale">Escala Máxima</label>
                            <input type="number" class="form-control" id="max_scale" name="max_scale">
                        </div>

                        <div class="form-group">
                            <label for="symbol">Símbolo</label>
                            <input type="text" class="form-control" id="symbol" name="symbol">
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Criar Camada</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Card de lista de camadas -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lista de Camadas</h3>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                    @foreach($layers as $layer)
                    <li class="list-group-item d-flex justify-content-between align-items-center" id="layer-{{ $layer->id }}">
                        <span class="layer-name" data-id="{{ $layer->id }}" data-name="{{ $layer->name }}" data-subcategory-id="{{ $layer->subcategory_id }}">
                            {{ $layer->name }} ({{ $layer->subcategory->name }}) <!-- Use o método getSubcategory() -->
                        </span>
                        <div>
                            <a href="{{ route('admin.layers.edit', $layer->id) }}" class="btn btn-warning btn-sm mx-1">Editar</a>
                            <!-- Formulário de exclusão -->
                            <form action="{{ route('admin.layers.destroy', $layer->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                            </form>
                        </div>
                    </li>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para edição -->
<div class="modal fade" id="editLayerModal" tabindex="-1" role="dialog" aria-labelledby="editLayerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editLayerModalLabel">Editar Camada</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Alerta para exibir mensagens de erro -->
                <div id="error-alert" class="alert alert-danger d-none"></div>
                <div id="success-alert" class="alert alert-success d-none"></div>

                <!-- Formulário de edição de camada -->
                <form id="edit-layer-form" method="POST" action="{{ route('admin.layers.update', ':id') }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="edit-name">Nome da Camada</label>
                        <input type="text" class="form-control" id="edit-name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="edit-layer_name">Nome da Camada (Layer)</label>
                        <input type="text" class="form-control" id="edit-layer_name" name="layer_name" required>
                    </div>

                    

                    <div class="form-group">
                        <label for="edit-description">Descrição</label>
                        <textarea class="form-control" id="edit-description" name="description"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="edit-image_path">Caminho da Imagem</label>
                        <input type="text" class="form-control" id="edit-image_path" name="image_path">
                    </div>

                    <div class="form-group">
                        <label for="edit-max_scale">Escala Máxima</label>
                        <input type="number" class="form-control" id="edit-max_scale" name="max_scale">
                    </div>

                    <div class="form-group">
                        <label for="edit-symbol">Símbolo</label>
                        <input type="text" class="form-control" id="edit-symbol" name="symbol">
                    </div>

                    <input type="hidden" id="edit-layer-id" name="layer_id">
                    <button type="submit" class="btn btn-primary mt-3">Atualizar Camada</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

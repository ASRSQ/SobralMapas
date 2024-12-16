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
                    <form id="layer-form" action="{{ route('admin.layers.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="form-group">
                            <label for="name">Nome da Camada</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="form-group">
                            <label for="subcategory">Subcategoria</label>
                            <select class="form-control" id="subcategory" name="subcategory" required>
                                <option value="">Selecione uma Subcategoria</option>
                                @foreach($subcategories as $subcategory)
                                    <option value="{{ $subcategory->getId() }}">{{ $subcategory->getName() }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="wms_link_id">Selecione o Link WMS</label>
                            <select class="form-control" id="wms_link_id" name="wms_link_id" required>
                                <option value="">Selecione um Link WMS</option>
                                @foreach($wmsLinks as $link)
                                    <option value="{{ $link->id }}">{{ $link->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="layers-select">Camada</label>
                            <select id="layers-select" class="form-control">
                                <option value="">Selecione um geoserver primeiro</option>
                            </select>
                        </div>
                        <input type="hidden" id="layer_name" name="layer_name">


                        <div class="form-group">
                            <label for="crs">CRS:</label>
                            <input type="text" class="form-control" id="crs" name="crs" placeholder="CRS da Camada" readonly>
                        </div>

                        <div class="form-group">
                            <label for="formats">Formats:</label>
                            <input type="text" class="form-control" id="formats" name="formats" placeholder="Formats disponíveis" readonly>
                        </div>

                        <div class="form-group">
                            <label for="legend_url">Legend URL:</label>
                            <input type="text" class="form-control" id="legend_url" name="legend_url" placeholder="URL da Legenda">
                        </div>

                        <div class="form-group">
                            <label for="use_legend">Usar Legend URL?</label>
                            <select class="form-control" id="use_legend" name="use_legend">
                                <option value="yes">Sim</option>
                                <option value="no">Não</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="description">Descrição</label>
                            <textarea class="form-control" id="description" name="description"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="image">Imagem</label>
                            <input type="file" class="form-control" id="image" name="image">
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
                        <li class="list-group-item d-flex justify-content-between align-items-center" id="layer-{{ $layer->getId() }}">
                            <span class="layer-name" data-id="{{ $layer->getId() }}" data-name="{{ $layer->getName() }}" data-subcategory-id="{{ $layer->getSubcategory()}}">
                                {{ $layer->getName() }} ({{ $layer->getSubcategory() }})
                            </span>
                            <div>
                                <a href="{{ route('admin.layers.edit', $layer->getid()) }}" class="btn btn-warning btn-sm mx-1">Editar</a>
                                <!-- Formulário de exclusão -->
                                <form action="{{ route('admin.layers.destroy', $layer->getId()) }}" method="POST" style="display:inline;">
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

<script>
    document.getElementById('wms_link_id').addEventListener('change', function () {
    const wmsLinkId = this.value;
    const layersSelect = document.getElementById('layers-select');

    // Limpa as opções do select de camadas
    layersSelect.innerHTML = '<option value="">Carregando...</option>';

    if (wmsLinkId) {
        fetch(`/sobralmapas/public/admin/wms/${wmsLinkId}/layers`)
            .then(response => response.json())
            .then(data => {
                layersSelect.innerHTML = '<option value="">Selecione uma camada</option>';

                if (data.error) {
                    alert(data.error);
                    return;
                }

                data.forEach(layer => {
                    const option = document.createElement('option');
                    option.value = layer.id;
                    option.textContent = layer.layer_name; // Nome da camada visível
                    option.dataset.crs = layer.crs || ''; // Atributo CRS
                    option.dataset.formats = layer.formats || ''; // Atributo Formats
                    option.dataset.description = layer.description || ''; // Atributo Description
                    layersSelect.appendChild(option);
                });
            })
            .catch(error => {
                layersSelect.innerHTML = '<option value="">Erro ao carregar camadas</option>';
                console.error('Erro:', error);
            });
    } else {
        layersSelect.innerHTML = '<option value="">Selecione um WMS Link primeiro</option>';
    }
});

// Evento acionado ao selecionar uma camada
document.getElementById('layers-select').addEventListener('change', function () {
        const selectedLayer = this.options[this.selectedIndex]; // Get the selected layer

        // Get the layer_name and update the hidden input field
        const layerNameField = document.getElementById('layer_name');
        if (selectedLayer) {
            // Set the layer_name value
            layerNameField.value = selectedLayer.textContent;

            // Fill in the other fields with data from the selected layer
            document.getElementById('crs').value = selectedLayer.dataset.crs || '';
            document.getElementById('formats').value = selectedLayer.dataset.formats || '';
            document.getElementById('legend_url').value = selectedLayer.dataset.description || '';
        } else {
            // Clear the fields if no layer is selected
            layerNameField.value = ''; // Clear layer_name
            document.getElementById('crs').value = '';
            document.getElementById('formats').value = '';
            document.getElementById('legend_url').value = '';
        }
    });

// Controle do campo legend_url via select box
document.getElementById('use_legend').addEventListener('change', function () {
    const legendUrlField = document.getElementById('legend_url');

    if (this.value === 'yes') {
        // Habilitar legend_url e preencher com a descrição atual
        legendUrlField.disabled = false;
    } else {
        // Desabilitar legend_url e limpar o campo
        legendUrlField.disabled = true;
        legendUrlField.value = '';
    }
});
document.getElementById('layer-form').addEventListener('submit', function (e) {
    // Remove wms_link_id before submitting the form
    const wmsLinkField = document.getElementById('wms_link_id');
    if (wmsLinkField) {
        wmsLinkField.remove(); // Remove the WMS link field
    }

    // Remove use_legend field before submitting the form
    const useLegendField = document.getElementById('use_legend');
    if (useLegendField) {
        useLegendField.remove(); // Remove the 'use_legend' field
    }
});


</script>
@endsection

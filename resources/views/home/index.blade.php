<!DOCTYPE html>
<html>
<head>
    <title>Mapa com OpenLayers e GeoServer</title>
    <!-- Incluir os arquivos do OpenLayers -->
    <link rel="stylesheet" href="https://openlayers.org/en/v6.13.0/css/ol.css" type="text/css">
    <script src="https://openlayers.org/en/v6.13.0/build/ol.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <meta http-equiv="Content-Security-Policy">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <header>
        <div class="header-left">
            <img src="{{ asset('img/Logo_Sobral.png') }}" alt="Logo Sobral">
        </div>

        <div class="header-center">
            <h2>Sobral em Mapas</h2>
        </div>
        
        <div class="header-right">
            <nav>
                <button>TUTORIAL</button>
                <button>SOBRE</button>
                <button>CONTATO</button>
            </nav>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <!-- Div para a caixa de seleção -->
            <div class="col-md-3">
                <div class="search-container">
                    <button type="button" class="search-button"><i class="fas fa-search"></i></button>
                    <input type="text" id="searchInput" placeholder="Pesquisar por mapas...">
                </div>
                <h3>Selecione um mapa para ter visualização:</h3>
                <div id="layerCheckboxList">
                    <!-- Iterar sobre as categorias -->
                    @foreach($categories as $category)
                    <details>
                        <summary>{{ $category->name }}</summary>
                        <!-- Iterar sobre as camadas da categoria -->
                        @foreach($layers as $layer)
                        @if($layer->category_id == $category->id)
                        <div class="layer-category">
                            <input type="checkbox" id="{{ $layer->layer }}" name="{{ $layer->name }}">
                            <label for="{{ $layer->layer }}">{{ $layer->name }}</label>
                        </div>
                        @endif
                        @endforeach
                    </details>
                    @endforeach
                    <div id="collapseDragDropMaps" class="container drag-drop-body p-0 collapse show" style="">
                        <div class="drag-drop-list">
                            <!-- Outros mapas ativos existentes -->

                            <!-- Dropdown para o mapa personalizado -->
                            <div class="dropdown">
                                <hr>
                                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    Mapa Personalizado
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="customMapDropdown">
                                    <!-- Camadas selecionadas serão adicionadas aqui dinamicamente -->
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
               
            </div>
            <!-- Div para o mapa -->
            <div class="col-md-9">
                <div id="map" class="map"></div>
                <div id="legend" class="card">
                <div id="legend_heading" class="card-header p-0">
                    <span class="btn d-flex justify-content-between">Legenda</span>
                </div>
                <div id="legend_body" class="card-body">
                    <!-- Aqui será inserida a legenda dinamicamente -->
                </div>
            </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    var layersData = @json($layers);
    </script>
    <script type="module" src="{{ asset('js/home.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>

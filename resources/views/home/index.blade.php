<!DOCTYPE html>
<html>
<head>
    <title>Sobral em Mapas - Mapa com OpenLayers e GeoServer</title>
    <!-- Incluir os arquivos do OpenLayers -->
    <link rel="stylesheet" href="https://openlayers.org/en/v6.13.0/css/ol.css" type="text/css">
    <script src="https://openlayers.org/en/v6.13.0/build/ol.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <link href="{{ asset('css/chat.css') }}" rel="stylesheet">
    <meta http-equiv="Content-Security-Policy">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <!-- jsPDF CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <!-- html2canvas CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <!-- Proj4 CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.7.6/proj4.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/html2canvas-pro@1.5.8/dist/html2canvas-pro.min.js"></script>
    <style>
        /* Estilos da visualização normal */
        #map {
            width: 800px; /* Tamanho fixo para visualização normal */
            height: 600px;
        }

        /* Estilos de impressão */
        @media print {
            @page {
                size: landscape; /* Forçar o modo paisagem */
                margin: 0;
            }

            body, html {
                margin: 0;
                padding: 0;
                width: 100%;
                height: 100%;
            }

            #map {
                width: 100vw; /* Largura total da janela de visualização da impressão */
                height: 100vh; /* Altura total da janela de visualização da impressão */
                margin: 0;
                padding: 0;
                object-fit: cover; /* Garantir que o mapa cubra a área de impressão */
            }
        }
    </style>
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
                <button><i class="fas fa-book"></i>  TUTORIAL</button>
                <button><i class="fas fa-info-circle"></i>  SOBRE</button>
                <button><i class="fas fa-envelope"></i> CONTATO</button>
            </nav>
        </div>
    </header>

    <!-- Botão para abrir o modal de impressão -->
<div class="tool-menu-dropdown" style="position: absolute; top: 60px; right: 10px; z-index: 1000;">
    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
        Ferramentas
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <li>
            <label for="lineColorPicker" class="dropdown-item">Escolher Cor da Linha</label>
            <input type="color" id="lineColorPicker" class="dropdown-item" value="#ffcc33" onchange="updateLineColor(this.value)">
        </li>
        <li><a class="dropdown-item" href="#" onclick="setDrawType('LineString')">Desenhar Linha</a></li>
        <li><a class="dropdown-item" href="#" onclick="setDrawType('Polygon')">Desenhar Polígono</a></li>
        <li><a class="dropdown-item" href="#" onclick="clearDrawings()">Limpar Desenhos</a></li>
        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#printModal">Opções de Impressão</a></li>
    </ul>
</div>

<!-- Modal para as opções de impressão -->
<div class="modal fade" id="printModal" tabindex="-1" aria-labelledby="printModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="printModalLabel">Opções de Impressão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="format" class="form-label">Formato:</label>
                    <select id="format" class="form-select">
                        <option value="a4">A4</option>
                        <option value="a3">A3</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="resolution" class="form-label">Resolução (dpi):</label>
                    <input id="resolution" type="number" class="form-control" value="150">
                </div>
                <div class="mb-3">
                    <label for="scale" class="form-label">Escala:</label>
                    <input id="scale" type="number" class="form-control" value="10000">
                </div>
            </div>
            <div class="modal-footer">
                <button id="print-direct" class="btn btn-primary">Imprimir</button>
                <button id="export-pdf" class="btn btn-secondary">Exportar para PDF</button>
            </div>
        </div>
    </div>
</div>


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
                    @foreach($categories as $category)
                        <details class="category">
                            <summary>{{ $category->getName() }}</summary>
                            @foreach($category->getSubcategories() as $subcategory)
                                <details class="subcategory">
                                    <summary>{{ $subcategory->getName() }}</summary>
                                    @foreach($subcategory->getLayers() as $layer)
                                        <div class="layer-category">
                                            <input type="checkbox" id="{{ $layer->getLayer() }}" name="{{ $layer->getName() }}">
                                            <label for="{{ $layer->getLayer() }}">{{ $layer->getName() }}</label>
                                        </div>
                                    @endforeach
                                </details>
                            @endforeach
                        </details>
                    @endforeach

                    <div id="collapseDragDropMaps" class="drag-drop-body p-0 collapse show">
                        <div class="drag-drop-list">
                            <!-- Outros mapas ativos existentes -->
                            <!-- Dropdown para o mapa personalizado -->
                            <div class="dropdown">
                                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    Mapas Ativos
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
            </div>
        </div>
    </div>

    <div id="legend" class="card">
        <div id="legend_heading" class="card-header p-0">
            <button class="btn d-flex justify-content-between collapse-legend" data-bs-toggle="collapse" data-bs-target="#legend_body" aria-expanded="true">
                <h4>
                    <i class="fas fa-circle"></i>
                    Legenda - SobralMapas
                </h4> 
                <span class="fas fa-caret-down"></span>
            </button>
        </div>
        <div id="legend_body" class="collapse">
                <!-- Conteúdo da legenda alocado dinamicamente -->
        </div>
    </div>

    <!-- Botão para mostrar o chat -->
    <button id="show-chat-button"><i class="fas fa-comment"></i>  Chat - SobralMapas </button>

    <!-- Contêiner do chat -->
    <div id="chat-container">
        <div class="chat-header">
            <div class="chat-title">
                <i class="fas fa-comment"></i>
                Chat - SobralMapas
            </div>
            <button id="toggle-chat-button">
                <i class="fas fa-times" id="toggle-icon"></i>
            </button>
        </div>
        <!-- Área onde as mensagens aparecerão -->
        <div id="messages">
            <!-- Mensagem de boas-vindas -->
            <div class="welcome-message">
                <p><strong>Bem-vindo ao SobralMapas!</strong></p>
                <p>Resolva as suas dúvidas.</p>
            </div>
            <hr>
            <div class="message received"></div>
        </div>
        <!-- Caixa de input e botão de envio -->
        <div id="message-input-container">
            <input type="text" id="message-input" placeholder="Digite sua mensagem...">
            <button id="send-button">Enviar</button>
        </div>
    </div>

    <script type="text/javascript">
        var layersData = @json($layers);
    </script>
    <script>
        var baseUrl = "{{ url('/') }}";
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script  src="{{ asset('js/map.js') }}"></script>
    <script  src="{{ asset('js/search.js') }}"></script>
    <script  src="{{ asset('js/layers.js') }}"></script>
    <script  src="{{ asset('js/chat.js') }}"></script>
    <script  src="{{ asset('js/ferramentas.js') }}"></script>
</body>
</html>



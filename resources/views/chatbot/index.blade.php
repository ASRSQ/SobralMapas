<!DOCTYPE html>
<html>
<head>
    <title>Mapa com OpenLayers e GeoServer</title>
    <!-- Incluir os arquivos do OpenLayers -->
    <link rel="stylesheet" href="https://openlayers.org/en/v6.13.0/css/ol.css" type="text/css">
    <script src="https://openlayers.org/en/v6.13.0/build/ol.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <link href="{{ asset('css/chat.css') }}" rel="stylesheet">
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
        <!-- Div for selection box -->
        <div class="col-md-3">
            <div class="search-container">
                <button type="button" class="search-button"><i class="fas fa-search"></i></button>
                <input type="text" id="searchInput" placeholder="Pesquisar por mapas...">
            </div>
            <h3>Selecione um mapa para ter visualização:</h3>
            <div id="layerCheckboxList">
                @foreach($categories as $category)
                <details class="category">
                    <summary>{{ $category->name }}</summary>
                    @foreach($subcategories as $subcategory)
                    @if($subcategory->category_id == $category->id)
                    <details class="subcategory">
                        <summary>{{ $subcategory->name }}</summary>
                        @foreach($layers as $layer)
                        @if($layer->subcategory_id == $subcategory->id)
                        <div class="layer-category">
                            <input type="checkbox" id="{{ $layer->layer }}" name="{{ $layer->name }}">
                            <label for="{{ $layer->layer }}">{{ $layer->name }}</label>
                        </div>
                        @endif
                        @endforeach
                    </details>
                    @endif
                    @endforeach
                </details>
                @endforeach
                <div id="collapseDragDropMaps" class="container drag-drop-body p-0 collapse show" style="">
                    <div class="drag-drop-list">
                        <!-- Other existing active maps -->
                        <!-- Dropdown for custom map -->
                        <div class="dropdown">
                            <hr>
                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                Mapa Personalizado
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="customMapDropdown">
                                <!-- Selected layers will be dynamically added here -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Div for the map -->
        <div class="col-md-9">
            <div id="map" class="map"></div>
            <div id="legend" class="card">
                <div id="legend_heading" class="card-header p-0">
                    <span class="btn d-flex justify-content-between">Legenda</span>
                </div>
                <div id="legend_body" class="card-body">
                    <!-- Legend will be dynamically inserted here -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chat -->
<div class="chat" id="chat">
    <div class="chat-header" onclick="toggleChat()">
         Live Chat
    </div>
    <div class="chat-body" id="chatBody">
        <div class="chat-content" id="chat-messages">
            <div class="chat-messages-inner"> <!-- Container interno para mensagens -->
                <!-- Mensagens do chat serão adicionadas aqui -->
            </div>
        </div>
       
    </div>
    <div class="chat-input-container" id="chat-input-container"> 
            <input type="text" id="chat-input" placeholder="Digite sua mensagem...">
            <button id="chat-send" onclick="sendMessage()">Enviar</button>
    </div>
</div>

<!-- Botão pequeno para abrir o chat -->
<button class="open-chat-btn" onclick="toggleChat()" id="open-chat-btn">
    <i class="fas fa-comment"></i>
</button>

<!-- Scripts -->
<script type="text/javascript">
    var layersData = @json($layers);
</script>
<script>
    var baseUrl = "{{ url('/') }}";
</script>
<script src="{{ asset('js/chat.js') }}"></script>
<script type="module" src="{{ asset('js/home.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrM7mM7kHpp3PCjDTLf7ofMzPBBkjzYl6hA9xRz9U8vpfKa5tw5u0" crossorigin="anonymous"></script>
</body>
</html>

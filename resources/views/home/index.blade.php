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

    <style>
        

        html, body, #map {
            height: 100vh;
            margin: 0;
            padding: 0;
        }

        .coordinates-label {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: white;
            padding: 5px;
            border: 1px solid black;
            display: none;
        }


        #layerCheckboxList {
            height: 100vh; /* Ocupa toda a altura da tela */
            overflow-y: auto; /* Adiciona rolagem vertical */
        }

        .layer-checkbox input[type="checkbox"] {
            margin-right: 5px;
        }

        header {
            background-color: #0094EE;
            color: white;
            display: flex;
            justify-content: space-between;
            padding: 10px 20px;
        }

        .header-left {
            display: flex;
            align-items: center;
        }

        .header-left img {
            height: 60px;
            margin-right: 10px;
        }

        .header-center h2{
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            padding: 10px 20px; 
        }

        .header-left img {
            height: 60px;
            margin-right: 10px;
        }

        .header-right{
            display: flex;
            align-items: center;
            justify-content: center;
        }

        nav button {
            background: none; 
            border: none; 
            color: white; 
            font-weight: bold;
            padding: 10px 20px; 
            margin: 0 5px; 
            cursor: pointer; 
            font-size: 18px; 
        }

        nav button:hover {
            color: gray;
        }

        .search-container {
            position: relative;
            margin-bottom: 10px;
        }

        #searchInput {
            padding: 8px 30px 8px 8px;
            width: 100%;
            border: px solid #ccc;
            border-radius: 20px;
            box-sizing: border-box;
            font-size: 16px;
        }

        .search-button {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            background-color: transparent;
            border: none;
            cursor: pointer;
        }

        .search-button i {
            color: #777;
        }

        #searchInput:focus {
            outline: none;
            border-color: #555; 
            box-shadow: 0 0 5px rgba(85, 85, 85, 0.5); /
        }


        main {
            display: flex;
        }

        .container-fluid {
            height: 100%;
            background-color: white; 
            padding: 20px;
            padding-bottom: -20px; 
        }


        h3 {
            color: #0094EE;
            font-size: 1rem;
            margin-bottom: 15px;
        }

        #layerCheckboxList {
            background-color: #0094EE;
            border-radius: 10px;
            color: white;
            height: 100%;
            max-height: 600px; /* Define a altura máxima desejada */
            overflow-y: auto;
        }

        .map {
            height: 100%; /* Ajuste conforme necessário */
            max-height: 700px;
            border: 1px solid black;
            border-radius: 10px;
        }

        .col-md-3 {
            margin-bottom: 20px;
        }


        .layer-category {
            padding: 10px;
            margin: 5px 0;
            background-color: none;
            border-radius: 5px;
        }

        .layer-category input[type="checkbox"] {
            margin-right: 10px;
        }

        details {
            border-bottom: 1px solid white; 
            border-radius: 5px;
            margin-bottom: 10px;
            padding: 10px;
            background-color: none;
            color: white;
            transition: background-color 0.2s;
        }

        details:hover {
            background-color: #007bb5;
        }

        details summary {
            color: none;
            cursor: pointer;
            font-weight: bold;
            padding: 5px;
            background-color: none;
            border-radius: 3px;
            position: relative;
            list-style: none;
        }

        details summary::before {
            content: '\25BC'; 
            position: absolute;
            right: 15px;
            transition: transform 0.3s ease;
            transform: rotate(30deg);
        }

        details[open] summary::before {
            transform: rotate(120deg);
        }

        details div.layer-category {
            margin-left: 20px;
        }

        details summary {
            cursor: pointer;
            font-weight: bold;
            margin: 10px 0;
        }

        details summary:hover {
            color: #f0f0f0;
        }

        details[open] summary {
            color: #f0f0f0;
        }

        #legend {
            position: absolute;
            z-index: 1000;
            background-color: #fff;
            margin-bottom: 50px;
            margin-right: 20px;
            border: 1px solid black;
            border-radius: 3px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }


        #legend_heading {
            background-color: #fff;
            border-bottom: 1px solid black;
            max-height: 30px;
            cursor: pointer;
            border: none;
            margin: -10px;
            outline: none;
            transition: background-color 0.3s; 
        }

        #legend_heading:hover {
            background-color: #eaeaea; 
        }

        h4 {
            color: black;
            font-size: 0.9rem;
        }

        #legend_body {
            border: none;
        }

        .legend-item-header {
            margin-bottom: 10px;
        }

        .legend-item-body {
            margin-bottom: 10px;
            margin-top: 10px;
        }

        .collapse-legend span {
            color: black;
            margin-left: 145px;
            transition: transform 0.5s ease;
            font-size: 20px;
        }

        .collapse-legend[aria-expanded="true"] span {
            transform: rotate(180deg); 
        }

        .info-label {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }

        .info-label i {
            margin-right: 25px;
        }

        .source-label {
            font-size: 1em;
        }

        #collapseDragDropMaps {
            background-color: #0094EE;
            border-radius: 10px;
            margin-top: 50px;
            color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        #collapseDragDropMaps .dropdown-toggle {
            background-color: #0094EE;
            color: white;
            border: none;
            border-bottom: 1px solid white;
            font-weight: bold;
            text-align: center;
            height: 80px;
            width: 100%;
            position: relative; 
            padding-right: 30px; 
            appearance: none; 
        }

        #collapseDragDropMaps .dropdown-toggle::after {
            position: absolute;
            right: 10px; 
            top: 50%;
            transform: translateY(-50%) rotate(-90deg);
            font-size: 30px; 
            transition: transform 0.5s ease;
        }

        #collapseDragDropMaps .dropdown-toggle[aria-expanded="true"]::after {
            transform: translateY(-50%) rotate(0deg); 
        }

        #collapseDragDropMaps .dropdown-toggle:hover {
            background-color: #007bb5;
        }

        #collapseDragDropMaps .dropdown-menu {
            background-color: #fff;
            color: white;
            width: 100%;
            height: 100px;
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

        <div id="collapseDragDropMaps" class="drag-drop-body p-0 collapse show" style="">
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

                <div id="legend" class="card">
                    <div id="legend_heading" class="card-header p-0">
                        <button class="btn d-flex justify-content-between collapse-legend" data-bs-toggle="collapse" data-bs-target="#legend_body" aria-expanded="true">
                            <h4>LEGENDA</h4> 
                            <span class="fas fa-caret-up"></span>
                        </button>
                    </div>
                    <div id="legend_body" class="card-body collapse">
                        <!-- Conteúdo da legenda alocado dinamicamente -->
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
    var layersData = @json($layers);
    </script>
    <script>
    var baseUrl = "{{ url('/') }}";
    </script>

    <script type="module" src="{{ asset('js/home.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>



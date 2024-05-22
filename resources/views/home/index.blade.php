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
    <style>
        #layerCheckboxList {
            height: 100vh; /* Ocupa toda a altura da tela */
            overflow-y: auto; /* Adiciona rolagem vertical */
        }
        .layer-checkbox input[type="checkbox"] {
        margin-right: 5px;
    }
    </style>
</head>

<body>
    <div class="container-fluid">
            <div class="row">
                <!-- Div para a caixa de seleção -->
                <div class="col-md-3">
                <h3>Selecione um mapa para ter visualização</h3>
                <div  id="layerCheckboxList">
                <!-- Checkboxes das camadas -->
                 </div>
                </div>
                <!-- Div para o mapa -->
                <div class="col-md-9">
                    <div id="map" class="map"></div>
                </div>
                
            </div>
        </div>

        <script src="{{ asset('js/home.js') }}"></script>
    
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>

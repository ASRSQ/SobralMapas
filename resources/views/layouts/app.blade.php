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
            
        </div>
    </header>

    <div class="container-fluid">
        @yield('content')

        </div>

    <script type="module" src="{{ asset('js/home.js') }}"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
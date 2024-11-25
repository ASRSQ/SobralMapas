<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sobral em Mapas')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Adiciona o CDN do Font Awesome para ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Adiciona o CSS correto do OpenLayers (versão 6.13.0) -->
    <link rel="stylesheet" href="https://openlayers.org/en/v6.13.0/css/ol.css" />
    <meta name="theme-color" content="#ee1849">
</head>
<body>
    @include('partials.topbar')

    <div class="container-fluid">
        <div class="row" style="position: relative">     
            @include('partials.sidebar')        
            <main class="col">
                <span id="error-message"> </span>
                @yield('content')
            </main>
        </div>
    </div>
    

    <!-- Carregar a biblioteca OpenLayers correta (versão 6.13.0) -->
    <script src="https://openlayers.org/en/v6.13.0/build/ol.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Seu script para inicializar o mapa -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/map.js') }}"></script>
</body>
</html>

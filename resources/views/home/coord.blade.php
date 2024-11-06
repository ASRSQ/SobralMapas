<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sobral em Mapas')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <!-- OpenLayers CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@latest/ol.css" />
    <style>
        #map {
            width: 100%;
            height: 100vh;
        }
    </style>
</head>
<body>
    <div id="map"></div>

    <!-- OpenLayers JS via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/ol@latest/dist/ol.js"></script>
    <script>
        // Camada raster (fundo) usando OpenStreetMap
        const rasterLayer = new ol.layer.Tile({
            source: new ol.source.OSM(),
            zIndex: 0 // Coloca o mapa base no fundo
        });

        // Definir o polígono (área) usando coordenadas de Sobral
        const polygonFeature = new ol.Feature({
            geometry: new ol.geom.Polygon([[
                ol.proj.fromLonLat([-40.355, -3.685]),
                ol.proj.fromLonLat([-40.345, -3.685]),
                ol.proj.fromLonLat([-40.345, -3.695]),
                ol.proj.fromLonLat([-40.355, -3.695]),
                ol.proj.fromLonLat([-40.355, -3.685]) // Fechar o polígono
            ]])
        });

        // Criar a camada vetorial para o polígono
        const polygonLayer = new ol.layer.Vector({
            source: new ol.source.Vector({
                features: [polygonFeature]
            }),
            style: new ol.style.Style({
                fill: new ol.style.Fill({
                    color: 'rgba(0, 0, 255, 0.3)' // Azul semi-transparente
                }),
                stroke: new ol.style.Stroke({
                    color: 'blue',
                    width: 2
                })
            }),
            zIndex: 1 // Z-index para o polígono (abaixo do ponto)
        });

        // Definir o ponto de localização dentro do polígono
        const pointFeature = new ol.Feature({
            geometry: new ol.geom.Point(ol.proj.fromLonLat([-40.349, -3.689])) // Localização de Sobral
        });

        // Criar a camada vetorial para o ponto
        const pointLayer = new ol.layer.Vector({
            source: new ol.source.Vector({
                features: [pointFeature]
            }),
            style: new ol.style.Style({
                image: new ol.style.Circle({
                    radius: 8,
                    fill: new ol.style.Fill({ color: 'red' }),
                    stroke: new ol.style.Stroke({ color: 'white', width: 2 })
                })
            }),
            zIndex: 2 // Z-index maior para o ponto, para ficar sobre o polígono
        });

        // Inicializar o mapa com todas as camadas
        const map = new ol.Map({
            target: 'map',
            layers: [rasterLayer, polygonLayer, pointLayer],
            view: new ol.View({
                center: ol.proj.fromLonLat([-40.349, -3.689]), // Centralizado em Sobral
                zoom: 14 // Nível de zoom inicial
            })
        });
    </script>
</body>
</html>

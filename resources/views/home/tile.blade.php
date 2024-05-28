<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escolas com Ícones</title>
    <!-- Importe a biblioteca Proj4 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.7.5/proj4.js"></script>
    <!-- Importe o script OpenLayers -->
    <script src="https://openlayers.org/en/v6.13.0/build/ol.js"></script>
    <!-- Estilos OpenLayers -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@6.6.1/dist/ol.css">
</head>
<body>

<!-- Div para exibir o mapa -->
<div id="map" style="width: 100%; height: 800px;"></div>

<script>
    // Defina a projeção EPSG:31984 usando Proj4
    proj4.defs('EPSG:31984', '+proj=utm +zone=24 +south +ellps=GRS80 +towgs84=0,0,0,0,0,0,0 +units=m +no_defs');

    // Carregar e analisar o arquivo XML
    function loadXMLDoc(filePath) {
        return fetch(filePath)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to load XML file');
                }
                return response.text();
            })
            .then(xmlText => {
                const parser = new DOMParser();
                const xmlDoc = parser.parseFromString(xmlText, 'text/xml');
                return xmlDoc;
            })
            .catch(error => {
                console.error('Error loading XML file:', error);
            });
    }

    // Caminho para o arquivo XML
    const xmlFilePath = 'xml/a.xml';

    // Função para criar o mapa com ícones das escolas
    function createMapWithSchoolIcons(xmlDoc) {
        // Extrair informações das escolas municipais do XML
        const layers = xmlDoc.querySelectorAll('Layer');
        const escolasFeatures = Array.from(layers).map(layer => {
            const name = layer.querySelector('Name').textContent;
            const crs = layer.querySelector('CRS').textContent;
            const boundingBox = layer.querySelector('EX_GeographicBoundingBox');
            const westBoundLongitude = boundingBox.querySelector('westBoundLongitude').textContent;
            const eastBoundLongitude = boundingBox.querySelector('eastBoundLongitude').textContent;
            const southBoundLatitude = boundingBox.querySelector('southBoundLatitude').textContent;
            const northBoundLatitude = boundingBox.querySelector('northBoundLatitude').textContent;

            // Calculando o centro da bounding box
            const longitude = (parseFloat(westBoundLongitude) + parseFloat(eastBoundLongitude)) / 2;
            const latitude = (parseFloat(southBoundLatitude) + parseFloat(northBoundLatitude)) / 2;

            // Transformar as coordenadas para EPSG:3857
            const transformedCoordinates = proj4('EPSG:31984', 'EPSG:3857', [longitude, latitude]);

            return new ol.Feature({
                geometry: new ol.geom.Point(transformedCoordinates),
                name: name,
                crs: crs
            });
        });

        // Criar uma fonte de vetor
        const vectorSource = new ol.source.Vector({
            features: escolasFeatures
        });

        // Criar uma camada de vetor
        const vectorLayer = new ol.layer.Vector({
            source: vectorSource,
            style: new ol.style.Style({
                image: new ol.style.Icon({
                    src: "{{ asset('img/escola.png') }}", // Ícone da escola
                    scale: 0.10
                })
            })
        });

        // Criar o mapa
        const map = new ol.Map({
            target: 'map',
            layers: [
                new ol.layer.Tile({
                    source: new ol.source.OSM()
                }),
                vectorLayer // Adicionar a camada de vetor com ícones das escolas
            ],
            view: new ol.View({
                center: ol.proj.fromLonLat([-40.3526, -3.6857]), // Centro do mapa
                zoom: 12 // Zoom inicial
            })
        });
    }

    // Carregar e analisar o arquivo XML quando a página for carregada
    document.addEventListener('DOMContentLoaded', () => {
        loadXMLDoc(xmlFilePath)
            .then(xmlDoc => {
                createMapWithSchoolIcons(xmlDoc);
            });
    });
</script>

</body>
</html>

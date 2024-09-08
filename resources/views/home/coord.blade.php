<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Medir Distância com OpenLayers</title>
    <link rel="stylesheet" href="https://openlayers.org/en/v6.13.0/css/ol.css" type="text/css">
    <style>
        #map {
            width: 100%;
            height: 400px;
        }
        .info {
            margin-top: 10px;
        }
        .toolbar {
            margin-bottom: 10px;
        }
        button {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="toolbar">
        <button id="drawTwoPoints">Desenhar Dois Pontos</button>
        <button id="drawMultiPoints">Desenhar Vários Pontos</button>
        <button id="drawFreehand">Desenhar Linha Livre</button>
    </div>
    <div id="map"></div>
    <div class="info" id="distanceInfo"></div>
    <script src="https://openlayers.org/en/v6.13.0/build/ol.js"></script>
    <script>
        // Inicializa o mapa
        const map = new ol.Map({
            target: 'map',
            layers: [
                new ol.layer.Tile({
                    source: new ol.source.OSM()
                })
            ],
            view: new ol.View({
                center: ol.proj.fromLonLat([-50.638, -23.182]), // Exemplo: Coordenadas de Cornélio Procópio
                zoom: 12
            })
        });

        // Crie uma camada vetorial para desenhar a linha e pontos
        const vectorSource = new ol.source.Vector();
        const vectorLayer = new ol.layer.Vector({
            source: vectorSource,
        });
        map.addLayer(vectorLayer);

        // Variável para armazenar as coordenadas temporárias
        let tempCoordinates = [];
        let draw; // variável para armazenar a interação de desenho atual

        // Função para iniciar a interação de desenho
        function addInteraction(type) {
            if (draw) {
                map.removeInteraction(draw);
            }

            draw = new ol.interaction.Draw({
                source: vectorSource,
                type: type === 'Point' || type === 'MultiPoint' ? 'Point' : 'LineString',
                freehand: type === 'LineString', // Ativa o desenho livre para LineString
            });

            map.addInteraction(draw);

            if (type === 'Point') {
                draw.on('drawend', function(event) {
                    const point = event.feature.getGeometry().getCoordinates();
                    tempCoordinates.push(point);

                    if (tempCoordinates.length === 2) {
                        const distance = ol.sphere.getDistance(tempCoordinates[0], tempCoordinates[1]);
                        document.getElementById('distanceInfo').innerHTML += `Distância entre os pontos: ${distance.toFixed(2)} metros<br>`;

                        const lineFeature = new ol.Feature({
                            geometry: new ol.geom.LineString(tempCoordinates),
                        });
                        vectorSource.addFeature(lineFeature);
                        tempCoordinates = [];
                    }
                });
            } else if (type === 'MultiPoint') {
                draw.on('drawend', function(event) {
                    const point = event.feature.getGeometry().getCoordinates();
                    tempCoordinates.push(point);

                    if (tempCoordinates.length > 1) {
                        const lineFeature = new ol.Feature({
                            geometry: new ol.geom.LineString(tempCoordinates),
                        });
                        vectorSource.addFeature(lineFeature);

                        const lastIndex = tempCoordinates.length - 1;
                        const distance = ol.sphere.getDistance(tempCoordinates[lastIndex - 1], tempCoordinates[lastIndex]);
                        document.getElementById('distanceInfo').innerHTML += `Distância entre os pontos ${lastIndex} e ${lastIndex + 1}: ${distance.toFixed(2)} metros<br>`;
                    }
                });
            } else if (type === 'LineString') {
                draw.on('drawend', function(event) {
                    const geometry = event.feature.getGeometry();
                    const coordinates = geometry.getCoordinates();
                    let totalDistance = 0;

                    for (let i = 0; i < coordinates.length - 1; i++) {
                        const segmentDistance = ol.sphere.getDistance(coordinates[i], coordinates[i + 1]);
                        totalDistance += segmentDistance;
                    }

                    document.getElementById('distanceInfo').innerHTML += `Distância total da linha: ${totalDistance.toFixed(2)} metros<br>`;
                });
            }
        }

        // Manipuladores de clique para botões
        document.getElementById('drawTwoPoints').addEventListener('click', function() {
            addInteraction('Point');
        });

        document.getElementById('drawMultiPoints').addEventListener('click', function() {
            addInteraction('MultiPoint');
        });

        document.getElementById('drawFreehand').addEventListener('click', function() {
            addInteraction('LineString');
        });

        // Desabilita o menu de contexto (botão direito) para evitar problemas durante o desenho
        map.getViewport().addEventListener('contextmenu', function (e) {
            e.preventDefault();
        });

    </script>
</body>
</html>

// URL do serviço WMS
var wmsUrl = 'http://geoserver.sobral.ce.gov.br/geoserver/ows';
var geoJsonUrl = 'http://polygons.openstreetmap.fr/get_geojson.py?id=302610&params=0';

// Referência ao elemento da lista de checkboxes
var layerCheckboxList = document.getElementById('layerCheckboxList');

// Criar o mapa
var map = new ol.Map({
    // Especificar o target (div) onde o mapa será exibido
    target: 'map',
    // Camadas base
    layers: [
        // Camada base do OpenStreetMap
        new ol.layer.Tile({
            source: new ol.source.OSM(),
            name: 'OpenStreetMap' // Define o nome da camada para identificação posterior
        })
    ],
    // Visualização do mapa
    view: new ol.View({
        center: ol.proj.fromLonLat([-40.3526, -3.6857]),
        zoom: 12 // Ajuste o nível de zoom conforme necessário
    })
});

// Adicionar a camada vetorial ao mapa apenas uma vez
var vectorSource = new ol.source.Vector({
    format: new ol.format.GeoJSON(),
    url: geoJsonUrl
});

var vectorLayer = new ol.layer.Vector({
    source: vectorSource,
    style: new ol.style.Style({
        stroke: new ol.style.Stroke({
            color: 'blue',
            width: 3,
            lineDash: [4] // Define o estilo da linha pontilhada
        })
    })
});

map.addLayer(vectorLayer);

// Event listener para alterações nas checkboxes de camadas
layerCheckboxList.addEventListener('change', function(event) {
    // Verificar se o elemento alterado é um checkbox
    if (event.target.type === 'checkbox') {
        var checkbox = event.target;
        var layerName = checkbox.id;

        if (checkbox.checked) {
            // Adicionar a camada selecionada ao mapa
            var newLayer = new ol.layer.Tile({
                source: new ol.source.TileWMS({
                    url: wmsUrl,
                    params: {
                        'LAYERS': layerName,
                        'TILED': true
                    },
                    serverType: 'geoserver',
                    transition: 0
                }),
                name: layerName // Define o nome da camada para identificação posterior
            });
            map.addLayer(newLayer);
        } else {
            // Remover a camada desmarcada do mapa
            map.getLayers().forEach(function(layer) {
                if (layer.get('name') === layerName) {
                    map.removeLayer(layer);
                }
            });
        }
    }
});

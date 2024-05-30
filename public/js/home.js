import { layers } from './layers.js';
  
console.log(layers)
  // URL do serviço WMS
   var wmsUrl = 'http://geoserver.sobral.ce.gov.br/geoserver/ows';


  // Referência ao elemento da lista de checkboxes
   var layerCheckboxList = document.getElementById('layerCheckboxList');

   // Criar checkboxes para o OpenStreetMap e ArcGIS e adicionar à lista
   var osmCheckboxDiv = document.createElement('div');
   osmCheckboxDiv.className = 'layer-checkbox';


   layers.forEach(function(layerName) {
       var checkboxDiv = document.createElement('div');
       checkboxDiv.className = 'layer-checkbox';

       var checkbox = document.createElement('input');
       checkbox.type = 'checkbox';
       checkbox.value = layerName;
       checkbox.id = layerName;

       var label = document.createElement('label');
       label.htmlFor = layerName;
       label.textContent = layerName.split(':')[1]; // Extrair o nome da camada sem o namespace

       checkboxDiv.appendChild(checkbox);
       checkboxDiv.appendChild(label);
       layerCheckboxList.appendChild(checkboxDiv);
   });

  // Event listener para alterações nas checkboxes de camadas
layerCheckboxList.addEventListener('change', function() {
    // Remover todas as camadas exceto a do OpenStreetMap
    map.getLayers().forEach(function(layer) {
        if (layer.get('name') !== 'OpenStreetMap') {
            map.removeLayer(layer);
        }
    });

    // Adicionar as camadas selecionadas ao mapa
    var selectedLayers = Array.from(layerCheckboxList.querySelectorAll('input[type="checkbox"]:checked')).map(function(checkbox) {
        return checkbox.value;
    });

    selectedLayers.forEach(function(layerName) {
  
        // Adicionar outras camadas selecionadas
        var newLayer = new ol.layer.Tile({
            source: new ol.source.TileWMS({
                url: wmsUrl+'?http=true',
                params: {
                    'LAYERS': layerName,
                    'TILED': true
                },
                serverType: 'geoserver',
                options: {
                    // Force HTTP requests
                    proxy: function(request) {
                        var url = request.getUrl();
                        if (url.startsWith('https')) {
                            // Replace 'https' with 'http'
                            url = url.replace('https', 'http');
                            request.setUrl(url);
                        }
                        return request;
                    }
                }
            }),
            name: layerName // Define o nome da camada para identificação posterior
        });
        map.addLayer(newLayer);
        
    });
});



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


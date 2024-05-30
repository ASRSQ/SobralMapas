import { layers } from './layers.js';
  
  // URL do serviço WMS
   var wmsUrl = 'http://geoserver.sobral.ce.gov.br/geoserver/ows';


  // Referência ao elemento da lista de checkboxes
   var layerCheckboxList = document.getElementById('layerCheckboxList');

   // Criar checkboxes para o OpenStreetMap e ArcGIS e adicionar à lista
   var osmCheckboxDiv = document.createElement('div');
   osmCheckboxDiv.className = 'layer-checkbox';

   var osmCheckbox = document.createElement('input');
   osmCheckbox.type = 'checkbox';
   osmCheckbox.value = 'OSM';
   osmCheckbox.id = 'OSM';

   var osmLabel = document.createElement('label');
   osmLabel.htmlFor = 'OSM';
   osmLabel.textContent = 'OpenStreetMap';

   osmCheckboxDiv.appendChild(osmCheckbox);
   osmCheckboxDiv.appendChild(osmLabel);
   layerCheckboxList.appendChild(osmCheckboxDiv);

   var arcgisCheckboxDiv = document.createElement('div');
   arcgisCheckboxDiv.className = 'layer-checkbox';

   var arcgisCheckbox = document.createElement('input');
   arcgisCheckbox.type = 'checkbox';
   arcgisCheckbox.value = 'ArcGIS';
   arcgisCheckbox.id = 'ArcGIS';

   var arcgisLabel = document.createElement('label');
   arcgisLabel.htmlFor = 'ArcGIS';
   arcgisLabel.textContent = 'ArcGIS Topo Map';

   arcgisCheckboxDiv.appendChild(arcgisCheckbox);
   arcgisCheckboxDiv.appendChild(arcgisLabel);
   layerCheckboxList.appendChild(arcgisCheckboxDiv);

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
       // Limpar todas as camadas existentes no mapa
       map.getLayers().clear();

       // Adicionar as camadas selecionadas ao mapa
       var selectedLayers = Array.from(layerCheckboxList.querySelectorAll('input[type="checkbox"]:checked')).map(function(checkbox) {
           return checkbox.value;
       });

       selectedLayers.forEach(function(layerName) {
           if (layerName === 'OSM') {
               // Adicionar a camada do OpenStreetMap
               map.addLayer(new ol.layer.Tile({
                   source: new ol.source.OSM(),
                   name: 'OpenStreetMap' // Define o nome da camada para identificação posterior
               }));
           } else if (layerName === 'ArcGIS') {
               // Adicionar a camada do ArcGIS
               var arcgisLayer = new ol.layer.Tile({
                   source: new ol.source.XYZ({
                       attributions: 'Tiles © <a href="https://services.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer">ArcGIS</a>',
                       url: 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer/tile/{z}/{y}/{x}',
                   }),
                   name: 'ArcGIS Topo Map' // Define o nome da camada para identificação posterior
               });
               map.addLayer(arcgisLayer);

           } 
           else {
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
           }
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
               source: new ol.source.OSM()
           })
       ],
       // Visualização do mapa
       view: new ol.View({
           center: ol.proj.fromLonLat([-40.3526, -3.6857]),
           zoom: 12 // Ajuste o nível de zoom conforme necessário
       })
   });

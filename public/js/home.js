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

// Função para adicionar ou remover camadas do mapa
function toggleLayer(layerName, addLayer) {
    if (addLayer) {
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

// Event listener para alterações nas checkboxes de camadas
layerCheckboxList.addEventListener('change', function(event) {
    // Verificar se o elemento alterado é um checkbox
    if (event.target.type === 'checkbox') {
        var checkbox = event.target;
        var layerName = checkbox.id;

        toggleLayer(layerName, checkbox.checked);
        updateCustomMapDropdown();
        updateLegend();
    }
});

// Função para atualizar o conteúdo do dropdown com as camadas selecionadas
function updateCustomMapDropdown() {
    // Selecionar o elemento do dropdown
    var dropdown = document.getElementById('customMapDropdown');
    // Limpar o conteúdo anterior do dropdown
    dropdown.innerHTML = '';

    // Obter todas as camadas selecionadas
    var selectedLayers = Array.from(document.querySelectorAll('#layerCheckboxList input[type="checkbox"]:checked')).map(function(checkbox) {
        return checkbox.id;
    });

    // Adicionar cada camada selecionada ao dropdown como um item da lista
    selectedLayers.forEach(function(layerName) {
        var listItem = document.createElement('li');
        listItem.className = 'dropdown-item';

        // Adicionar o texto da camada e um ícone "x" para removê-la
        listItem.innerHTML = '<span>' + layerName + '</span><span class="close-icon" style="cursor: pointer; margin-left: 10px;">&times;</span>';

        // Adicionar evento de clique ao ícone "x" para desmarcar a camada
        listItem.querySelector('.close-icon').addEventListener('click', function() {
            // Desmarcar a camada correspondente
            var checkbox = document.getElementById(layerName);
            if (checkbox) {
                checkbox.checked = false;
                toggleLayer(layerName, false);
                updateCustomMapDropdown();
                updateLegend();
            }
        });

        // Adicionar o item ao dropdown
        dropdown.appendChild(listItem);
    });
}

// Função para atualizar a legenda com base nas camadas selecionadas
function updateLegend() {
    // Selecionar o elemento da legenda
    var legendBody = document.getElementById('legend_body');
    // Limpar o conteúdo anterior da legenda
    legendBody.innerHTML = '';

    // Obter todas as camadas selecionadas
    var selectedLayers = Array.from(document.querySelectorAll('#layerCheckboxList input[type="checkbox"]:checked')).map(function(checkbox) {
        return checkbox.id;
    });
    console.log(selectedLayers)
    // Para cada camada selecionada, criar um novo dropdown na legenda
    selectedLayers.forEach(function(layerName) {
        // Buscar a descrição da camada
        var layerDescription = layersData.find(layer => layer.layer === layerName).description;
        var newname = layersData.find(layer => layer.layer === layerName).name;
        console.log(layerDescription)
        // Criar o elemento do dropdown
        var dropdown = document.createElement('div');
        dropdown.classList.add('dropdown');

        // Criar o botão do dropdown com o nome da camada como título
        var dropdownButton = document.createElement('button');
        dropdownButton.classList.add('btn', 'btn-secondary', 'dropdown-toggle');
        dropdownButton.setAttribute('type', 'button');
        dropdownButton.setAttribute('id', 'dropdownMenuButton_' +  newname); // Adiciona um ID único
        dropdownButton.setAttribute('data-bs-toggle', 'dropdown');
        dropdownButton.setAttribute('aria-expanded', 'false');
        dropdownButton.textContent =  newname; // Define o texto do botão como o nome da camada
        dropdown.appendChild(dropdownButton);

        // Criar o menu do dropdown
        var dropdownMenu = document.createElement('ul');
        dropdownMenu.classList.add('dropdown-menu');
        dropdownMenu.setAttribute('aria-labelledby', 'dropdownMenuButton_' +  newname); // Referência ao ID único do botão

        // Adicionar a descrição da camada ao menu do dropdown
        var dropdownItem = document.createElement('li');
        dropdownItem.textContent = layerDescription; // Define o texto do item como a descrição da camada
        dropdownMenu.appendChild(dropdownItem);

        dropdown.appendChild(dropdownMenu);

        // Adicionar o dropdown à legenda
        legendBody.appendChild(dropdown);
    });
}

// Chamar a função de atualização quando houver uma alteração nas camadas selecionadas
document.getElementById('layerCheckboxList').addEventListener('change', function() {
    updateCustomMapDropdown();
    updateLegend();
});

// Chamar a função de atualização ao carregar a página
updateCustomMapDropdown();
updateLegend();

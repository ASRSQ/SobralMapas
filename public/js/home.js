// URL do serviço WMS e GeoJSON
const wmsUrl = 'http://geoserver.sobral.ce.gov.br/geoserver/ows';
const geoJsonUrl = 'http://polygons.openstreetmap.fr/get_geojson.py?id=302610&params=0';

// Elemento da lista de checkboxes
const layerCheckboxList = document.getElementById('layerCheckboxList');

// Criar o mapa com camada base OpenStreetMap
const map = new ol.Map({
    target: 'map',
    layers: [
        new ol.layer.Tile({
            source: new ol.source.OSM(),
            name: 'OpenStreetMap'
        })
    ],
    view: new ol.View({
        center: ol.proj.fromLonLat([-40.3526, -3.6857]),
        zoom: 12
    })
});

// Adicionar a camada vetorial GeoJSON
const vectorLayer = new ol.layer.Vector({
    source: new ol.source.Vector({
        format: new ol.format.GeoJSON(),
        url: geoJsonUrl
    }),
    style: new ol.style.Style({
        stroke: new ol.style.Stroke({
            color: 'blue',
            width: 3,
            lineDash: [4]
        })
    })
});
map.addLayer(vectorLayer);

// Função para adicionar/remover camadas do mapa
function toggleLayer(layerName, addLayer) {
    if (addLayer) {
        // Verifica se a camada já existe no mapa antes de adicioná-la novamente
        const existingLayer = map.getLayers().getArray().find(layer => layer.get('name') === layerName);
        if (!existingLayer) {
            const newLayer = new ol.layer.Tile({
                source: new ol.source.TileWMS({
                    url: wmsUrl,
                    params: { 'LAYERS': layerName, 'TILED': true },
                    serverType: 'geoserver',
                    transition: 0
                }),
                name: layerName
            });
            map.addLayer(newLayer);
        }
    } else {
        removeLayerByName(layerName);
    }
}

// Função para remover uma camada do mapa pelo nome
function removeLayerByName(layerName) {
    const layers = map.getLayers().getArray();
    const layerToRemove = layers.find(layer => layer.get('name') === layerName);
    if (layerToRemove) {
        map.removeLayer(layerToRemove);
    }
}

// Função para recuperar camadas já selecionadas
function getSelectedLayers() {
    return Array.from(document.querySelectorAll('#layerCheckboxList input[type="checkbox"]:checked')).map(checkbox => checkbox.id);
}

// Event listener para alterações nas checkboxes de camadas
layerCheckboxList.addEventListener('change', (event) => {
    if (event.target.type === 'checkbox') {
        toggleLayer(event.target.id, event.target.checked);
        updateCustomMapDropdown();
        updateLegend();
    }
});

// Função para busca e exibição de camadas baseadas em metadados
function performSearch(searchTerm) {
    console.log("Enviando solicitação AJAX para pesquisa:", searchTerm);
    fetch(`${baseUrl}?search=${encodeURIComponent(searchTerm)}`, {
        method: "GET",
        headers: { "X-Requested-With": "XMLHttpRequest" }
    })
    .then(response => response.json())
    .then(data => {
        console.log("Dados recebidos:", data); // Exibe os dados recebidos no console
        updateLayerList(data, searchTerm); // Passa os dados para a função que atualiza a lista de camadas
    })
    .catch(error => console.error("Erro:", error));
}


// Atualiza a lista de camadas com base na resposta da pesquisa
function updateLayerList(data, searchTerm) {
    if (data.categories && data.subcategories && data.layers) {
        // Salvar camadas previamente selecionadas
        const previouslySelectedLayers = getSelectedLayers();

        // Salvar o conteúdo do "Mapa Personalizado"
        const customMapDropdown = document.getElementById("customMapDropdown").parentNode.parentNode.cloneNode(true);

        layerCheckboxList.innerHTML = '';

        data.categories.forEach(category => {
            const categoryDetails = createCategoryElement(category, data.subcategories, data.layers, searchTerm, previouslySelectedLayers);
            layerCheckboxList.appendChild(categoryDetails);
        });

        // Adiciona o conteúdo do "Mapa Personalizado" de volta
        layerCheckboxList.appendChild(customMapDropdown);

        // Restaurar camadas previamente selecionadas
        previouslySelectedLayers.forEach(layerName => {
            const checkbox = document.getElementById(layerName);
            if (checkbox) {
                checkbox.checked = true;
                toggleLayer(layerName, true); // Reativar camadas selecionadas
            }
        });

        updateCustomMapDropdown();
        updateLegend();
    }
}

// Cria o elemento HTML para uma categoria e suas subcategorias
function createCategoryElement(category, subcategories, layers, searchTerm, previouslySelectedLayers) {
    const categoryDetails = document.createElement("details");
    categoryDetails.classList.add("category");
    const categorySummary = document.createElement("summary");
    categorySummary.textContent = category.name;
    categoryDetails.appendChild(categorySummary);

    let shouldOpenCategory = false;

    subcategories.forEach(subcategory => {
        if (subcategory.category_id === category.id) {
            const subcategoryDetails = createSubcategoryElement(subcategory, layers, searchTerm, previouslySelectedLayers);
            if (subcategoryDetails.shouldOpenSubcategory) {
                shouldOpenCategory = true;
            }
            categoryDetails.appendChild(subcategoryDetails.element);
        }
    });

    // Verifica se o termo de busca corresponde ao nome da categoria
    if (category.name.toLowerCase().includes(searchTerm.toLowerCase())) {
        shouldOpenCategory = true;
    }

    if (shouldOpenCategory) {
        categoryDetails.setAttribute('open', ''); // Mantém a categoria aberta
    }

    return categoryDetails;
}

// Cria o elemento HTML para uma subcategoria e suas camadas
function createSubcategoryElement(subcategory, layers, searchTerm, previouslySelectedLayers) {
    const subcategoryDetails = document.createElement("details");
    subcategoryDetails.classList.add("subcategory");
    const subcategorySummary = document.createElement("summary");
    subcategorySummary.textContent = subcategory.name;
    subcategoryDetails.appendChild(subcategorySummary);

    let shouldOpenSubcategory = false;

    layers.forEach(layer => {
        if (layer.subcategory_id === subcategory.id) {
            const layerElement = createLayerElement(layer, searchTerm, previouslySelectedLayers);
            subcategoryDetails.appendChild(layerElement);
            if (layer.name.toLowerCase().includes(searchTerm.toLowerCase())) {
                shouldOpenSubcategory = true;
            }
        }
    });

    // Verifica se o termo de busca corresponde ao nome da subcategoria
    if (subcategory.name.toLowerCase().includes(searchTerm.toLowerCase())) {
        shouldOpenSubcategory = true;
    }

    if (shouldOpenSubcategory) {
        subcategoryDetails.setAttribute('open', ''); // Mantém a subcategoria aberta
    }

    return {
        element: subcategoryDetails,
        shouldOpenSubcategory: shouldOpenSubcategory
    };
}

// Cria o elemento HTML para uma camada
function createLayerElement(layer, searchTerm, previouslySelectedLayers) {
    const layerDiv = document.createElement("div");
    layerDiv.classList.add("layer-category");
    const checkbox = document.createElement("input");
    checkbox.type = "checkbox";
    checkbox.id = layer.layer;
    checkbox.name = layer.name;

    // Manter a camada selecionada se ela já estava selecionada antes ou se corresponde à busca exata
    if (layer.name.toLowerCase() === searchTerm.toLowerCase() || previouslySelectedLayers.includes(layer.layer)) {
        checkbox.checked = true;
        toggleLayer(layer.layer, true); // Certificar que a camada está ativada
    }

    const label = document.createElement("label");
    label.htmlFor = layer.layer;
    label.textContent = layer.name;
    layerDiv.appendChild(checkbox);
    layerDiv.appendChild(label);

    return layerDiv;
}

// Funções para atualizar dropdown e legenda
function updateCustomMapDropdown() {
    const dropdown = document.getElementById('customMapDropdown');
    dropdown.innerHTML = '';

    const selectedLayers = getSelectedLayers();

    selectedLayers.forEach(layerName => {
        const listItem = createDropdownItem(layerName);
        dropdown.appendChild(listItem);
    });
}

function createDropdownItem(layerName) {
    const listItem = document.createElement('li');
    listItem.className = 'dropdown-item';
    listItem.innerHTML = `<span>${layerName}</span><span class="close-icon" style="cursor: pointer; margin-left: 10px;">&times;</span>`;

    listItem.querySelector('.close-icon').addEventListener('click', () => {
        const checkbox = document.getElementById(layerName);
        if (checkbox) {
            checkbox.checked = false;
            toggleLayer(layerName, false);
            updateCustomMapDropdown();
            updateLegend();
        }
    });

    return listItem;
}

// Função para atualizar a legenda
function updateLegend() {
    const legendBody = document.getElementById('legend_body');
    legendBody.innerHTML = '';

    const selectedLayers = getSelectedLayers();

    selectedLayers.forEach(layerName => {
        const layerData = layersData.find(layer => layer.layer === layerName);
        if (layerData) {
            const dropdown = createLegendDropdown(layerData);
            legendBody.appendChild(dropdown);
        }
    });
}

// Cria o dropdown na legenda para cada camada selecionada
function createLegendDropdown(layerData) {
    const dropdown = document.createElement('div');
    dropdown.classList.add('dropdown');

    const dropdownButton = document.createElement('button');
    dropdownButton.classList.add('btn', 'btn-secondary', 'dropdown-toggle');
    dropdownButton.setAttribute('type', 'button');
    dropdownButton.setAttribute('id', `dropdownMenuButton_${layerData.name}`);
    dropdownButton.setAttribute('data-bs-toggle', 'dropdown');
    dropdownButton.setAttribute('aria-expanded', 'false');
    dropdownButton.textContent = layerData.name;
    dropdown.appendChild(dropdownButton);

    const dropdownMenu = document.createElement('ul');
    dropdownMenu.classList.add('dropdown-menu');
    dropdownMenu.setAttribute('aria-labelledby', `dropdownMenuButton_${layerData.name}`);

    const dropdownItem = document.createElement('li');
    dropdownItem.textContent = layerData.description;
    dropdownMenu.appendChild(dropdownItem);

    dropdown.appendChild(dropdownMenu);

    return dropdown;
}

// Inicialização e event listeners
document.addEventListener("DOMContentLoaded", () => {
    document.querySelector(".search-button").addEventListener("click", () => {
        const searchTerm = document.getElementById("searchInput").value.toLowerCase();
        performSearch(searchTerm);
    });

    document.addEventListener("mapTypeReceived", event => {
        performSearch(event.detail.mapType);
    });

    updateCustomMapDropdown();
    updateLegend();
});

// Funções para o chat

// Função para mostrar a caixa de chat ao clicar no botão
document.getElementById('show-chat-button').addEventListener('click', function() {
    const chatContainer = document.getElementById('chat-container');
    chatContainer.style.display = 'block';
    this.style.display = 'none'; // Esconde o botão depois que o chat é mostrado
});

// Função de envio de mensagens com AJAX
document.getElementById('send-button').addEventListener('click', function() {
    const messageInput = document.getElementById('message-input');
    const message = messageInput.value.trim();
    if (message !== '') {
        addMessageToChat('user', message);
        messageInput.value = '';

        // Envia a mensagem ao servidor usando AJAX
        fetch(`${baseUrl}/send-message`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ message: message })
        })
        .then(response => response.json())
        .then(data => {
            console.log("Dados recebidos do servidor:", data); // Verifica o que está sendo recebido
            if (data && data.length > 0) {
                data.forEach(msg => {
                    // Verifica se a mensagem contém metadados no campo 'custom'
                    if (msg.custom && msg.custom.map_type) {
                        console.log("Metadado recebido:", msg.custom.map_type); // Log para verificação
                        // Aciona a lógica de busca com base no tipo de mapa
                        activateMapSearch(msg.custom.map_type);
                    } else if (msg.text) {
                        // Caso seja texto normal, exibe a mensagem no chat
                        addMessageToChat('bot', msg.text);
                    }
                });
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            addMessageToChat('bot', 'Erro ao se comunicar com o servidor.');
        });
    }
});

// Enviar mensagem ao pressionar Enter
document.getElementById('message-input').addEventListener('keydown', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        document.getElementById('send-button').click();
    }
});

// Função para adicionar mensagens ao chat
function addMessageToChat(sender, text) {
    const messagesDiv = document.getElementById('messages');
    const messageDiv = document.createElement('div');
    messageDiv.classList.add('message', sender === 'user' ? 'sent' : 'received');
    messageDiv.textContent = text;
    messagesDiv.appendChild(messageDiv);
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
}

const showChatButton = document.getElementById('show-chat-button');
const chatContainer = document.getElementById('chat-container');
const toggleChatButton = document.getElementById('toggle-chat-button');
const sendButton = document.getElementById('send-button');
const messageInput = document.getElementById('message-input');
const messagesContainer = document.getElementById('messages');

// Mostrar o chatbox ao clicar no botão
showChatButton.addEventListener('click', function() {
    chatContainer.style.display = 'flex';
    showChatButton.style.display = 'none';
});

// Esconder o chatbox ao clicar no botão X
toggleChatButton.addEventListener('click', function() {
    chatContainer.style.display = 'none';
    showChatButton.style.display = 'block';
});

// Enviar mensagem ao clicar no botão "Enviar"
sendButton.addEventListener('click', function() {
    const messageText = messageInput.value;
    if (messageText.trim() !== "") {
        const messageElement = document.createElement('div');
        messageElement.classList.add('message', 'sent');
        messageElement.textContent = messageText;

        messagesContainer.appendChild(messageElement);
        messageInput.value = "";
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
});

// Função para ativar a busca com base no metadado do tipo de mapa
function activateMapSearch(mapType) {
    performSearch(mapType); // Chama a busca diretamente com o metadado, sem preencher a caixa de pesquisa
}

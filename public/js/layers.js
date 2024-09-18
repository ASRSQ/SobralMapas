// Cria o elemento HTML para uma subcategoria e suas camadas
function createSubcategoryElement(
    subcategory,
    layers,
    searchTerm,
    previouslySelectedLayers
) {
    const subcategoryDetails = document.createElement("details");
    subcategoryDetails.classList.add("subcategory");
    const subcategorySummary = document.createElement("summary");
    subcategorySummary.textContent = subcategory.name;
    subcategoryDetails.appendChild(subcategorySummary);

    let shouldOpenSubcategory = false;

    layers.forEach((layer) => {
        if (layer.subcategory_id === subcategory.id) {
            const layerElement = createLayerElement(
                layer,
                searchTerm,
                previouslySelectedLayers
            );
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
        subcategoryDetails.setAttribute("open", ""); // Mantém a subcategoria aberta
    }

    return {
        element: subcategoryDetails,
        shouldOpenSubcategory: shouldOpenSubcategory,
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
    if (
        layer.name.toLowerCase() === searchTerm.toLowerCase() ||
        previouslySelectedLayers.includes(layer.layer)
    ) {
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
    const dropdown = document.getElementById("customMapDropdown");
    dropdown.innerHTML = "";

    const selectedLayers = window.getSelectedLayers();


    selectedLayers.forEach((layerName) => {
        const listItem = createDropdownItem(layerName);
        dropdown.appendChild(listItem);
    });
}

function createDropdownItem(layerName) {
    const listItem = document.createElement("li");
    listItem.className = "dropdown-item";
    listItem.innerHTML = `<span>${layerName}</span><span class="close-icon" style="cursor: pointer; margin-left: 10px;">&times;</span>`;

    listItem.querySelector(".close-icon").addEventListener("click", () => {
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
    const legendBody = document.getElementById("legend_body");
    legendBody.innerHTML = "";

    const selectedLayers = window.getSelectedLayers();
    console.log(selectedLayers)
    selectedLayers.forEach((layerName) => {
        const layerData = layersData.find((layer) => layer.layer === layerName);
        if (layerData) {
            const dropdown = createLegendDropdown(layerData);
            legendBody.appendChild(dropdown);
        }
    });
}

// Cria o dropdown na legenda para cada camada selecionada
function createLegendDropdown(layerData) {
    const dropdown = document.createElement("div");
    dropdown.classList.add("dropdown");

    const dropdownButton = document.createElement("button");
    dropdownButton.classList.add("btn", "btn-secondary", "dropdown-toggle");
    dropdownButton.setAttribute("type", "button");
    dropdownButton.setAttribute("id", `dropdownMenuButton_${layerData.name}`);
    dropdownButton.setAttribute("data-bs-toggle", "dropdown");
    dropdownButton.setAttribute("aria-expanded", "false");
    dropdownButton.textContent = layerData.name;
    dropdown.appendChild(dropdownButton);

    const dropdownMenu = document.createElement("ul");
    dropdownMenu.classList.add("dropdown-menu");
    dropdownMenu.setAttribute(
        "aria-labelledby",
        `dropdownMenuButton_${layerData.name}`
    );

    const dropdownItem = document.createElement("li");
    dropdownItem.textContent = layerData.description;
    dropdownMenu.appendChild(dropdownItem);

    dropdown.appendChild(dropdownMenu);

    return dropdown;
}

// Inicialização e event listeners
document.addEventListener("DOMContentLoaded", () => {
    document.querySelector(".search-button").addEventListener("click", () => {
        const searchTerm = document
            .getElementById("searchInput")
            .value.toLowerCase();
        performSearch(searchTerm);
    });

    document.addEventListener("mapTypeReceived", (event) => {
        performSearch(event.detail.mapType);
    });

    updateCustomMapDropdown();
    updateLegend();
});
// Função para busca e exibição de camadas baseadas em metadados
function performSearch(searchTerm) {
    console.log("Enviando solicitação AJAX para pesquisa:", searchTerm);
    fetch(`${baseUrl}?search=${encodeURIComponent(searchTerm)}`, {
        method: "GET",
        headers: { "X-Requested-With": "XMLHttpRequest" },
    })
        .then((response) => response.json())
        .then((data) => {
            console.log("Dados recebidos:", data); // Exibe os dados recebidos no console
            updateLayerList(data, searchTerm); // Passa os dados para a função que atualiza a lista de camadas
        })
        .catch((error) => console.error("Erro:", error));
}

// Atualiza a lista de camadas com base na resposta da pesquisa
function updateLayerList(data, searchTerm) {
    if (data.categories && data.subcategories && data.layers) {
        // Salvar camadas previamente selecionadas
        const previouslySelectedLayers = getSelectedLayers();

        // Salvar o conteúdo do "Mapa Personalizado"
        const customMapDropdown = document
            .getElementById("customMapDropdown")
            .parentNode.parentNode.cloneNode(true);

        layerCheckboxList.innerHTML = "";

        data.categories.forEach((category) => {
            const categoryDetails = createCategoryElement(
                category,
                data.subcategories,
                data.layers,
                searchTerm,
                previouslySelectedLayers
            );
            layerCheckboxList.appendChild(categoryDetails);
        });

        // Adiciona o conteúdo do "Mapa Personalizado" de volta
        layerCheckboxList.appendChild(customMapDropdown);

        // Restaurar camadas previamente selecionadas
        previouslySelectedLayers.forEach((layerName) => {
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

// Inicialização e event listeners
document.addEventListener("DOMContentLoaded", () => {
    // Evento de clique no botão de pesquisa
    document.querySelector(".search-button").addEventListener("click", () => {
        const searchTerm = document.getElementById("searchInput").value.toLowerCase();
        performSearch(searchTerm);
    });

    // Evento de tecla pressionada no campo de entrada
    document.getElementById("searchInput").addEventListener("keypress", (event) => {
        if (event.key === "Enter") { // Verifica se a tecla pressionada é "Enter"
            const searchTerm = event.target.value.toLowerCase();
            performSearch(searchTerm);
        }
    });

    document.addEventListener("mapTypeReceived", (event) => {
        performSearch(event.detail.mapType);
    });

    updateCustomMapDropdown();
    updateLegend();
});

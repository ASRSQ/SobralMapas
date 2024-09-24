// IIFE (Immediately Invoked Function Expression) para encapsular o código
(() => {
    "use strict";

    // Função para inicializar a sidebar
    function initializeSidebar() {
        const sidebar = document.getElementById("mainSidebar");
        const toggleButton = document.getElementById("toggleSidebar");

        toggleButton.addEventListener("click", () => {
            sidebar.classList.toggle("sidebar-collapsed");
        });
    }

    // Inicializa os tooltips do Bootstrap
    function initializeTooltip() {
        document.addEventListener("DOMContentLoaded", function () {
            var tooltipTriggerList = [].slice.call(
                document.querySelectorAll('[data-bs-toggle="tooltip"]')
            );
            var tooltipList = tooltipTriggerList.map(function (
                tooltipTriggerEl
            ) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    }
    // Função para inicializar a pesquisa
    function initializeSearch() {
        const searchButton = document.getElementById("btn-search");
        const searchInput = document.querySelector(".input-search");

        searchButton.addEventListener("click", () => {
            searchInput.classList.toggle("hidden");
        });
    }

    // Função para alternar entre tela cheia (Fullscreen)
    function toggleFullScreen() {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen().catch((err) => {
                console.log(
                    `Error attempting to enable full-screen mode: ${err.message}`
                );
            });
        } else {
            document.exitFullscreen();
        }
    }

    // Função para inicializar o botão de expandir (fullscreen)
    function initializeExpandButton() {
        const expandButton = document.getElementById("btn-expand");
        const topBar = document.querySelector(".topbar");
        const mapEl = document.getElementById("map");
        expandButton.addEventListener("click", toggleFullScreen);

        // Alterna o ícone ao entrar e sair do modo fullscreen
        document.addEventListener("fullscreenchange", () => {
            const icon = expandButton.querySelector("i");
            if (document.fullscreenElement) {
                mapEl.style.height = "100vh";
                topBar.classList.add("hidden-topbar");
                icon.classList.remove("fa-expand-arrows-alt");
                icon.classList.add("fa-compress-arrows-alt"); // Ícone de "sair de tela cheia"
            } else {
                topBar.classList.remove("hidden-topbar");
                mapEl.style.height = "calc(100vh - 60px)";
                icon.classList.remove("fa-compress-arrows-alt");
                icon.classList.add("fa-expand-arrows-alt"); // Ícone de "expandir"
            }
        });
    }

    // Função para inicializar os toggles de camadas (checkboxes)
    function initializeLayerToggles(map) {
        const layer5Checkbox = document.getElementById("transol_linha_5");
        const layer6Checkbox = document.getElementById("transol_linha_6");

        // Listener para a camada Linha 5
        layer5Checkbox.addEventListener("change", function () {
            window.mapModule.toggleLayer(map, "transol_linha_5", this.checked);
        });

        // Listener para a camada Linha 6
        layer6Checkbox.addEventListener("change", function () {
            window.mapModule.toggleLayer(map, "transol_linha_6", this.checked);
        });
    }

    // Função para inicializar a caixa de seleção (mover e redimensionar)
    function initializeSelectionBox() {
        const selectionBox = document.getElementById("selection-box");
        const dragHandle = document.getElementById("drag-handle");

        let isDragging = false;
        let startX, startY, offsetX, offsetY;

        // Função para atualizar as dimensões no cabeçalho
        function updateDimensions() {
            const width = selectionBox.offsetWidth;
            const height = selectionBox.offsetHeight;
            dragHandle.innerHTML = `Arraste - ${width}px x ${height}px`;
        }

        // Iniciar o arraste ao clicar no cabeçalho
        dragHandle.addEventListener("mousedown", function (e) {
            isDragging = true;
            startX = e.clientX;
            startY = e.clientY;

            // Pega a posição inicial da caixa de seleção
            offsetX = selectionBox.offsetLeft;
            offsetY = selectionBox.offsetTop;

            e.preventDefault(); // Previne seleção de texto
        });

        // Mover a caixa durante o arraste
        document.addEventListener("mousemove", function (e) {
            if (isDragging) {
                const moveX = e.clientX - startX;
                const moveY = e.clientY - startY;

                // Atualizar a posição da caixa de seleção
                selectionBox.style.left = offsetX + moveX + "px";
                selectionBox.style.top = offsetY + moveY + "px";
            }
        });

        // Finalizar o arraste ao soltar o mouse
        document.addEventListener("mouseup", function () {
            isDragging = false;
            updateDimensions(); // Atualiza as dimensões após o movimento
        });

        // Atualizar as dimensões quando a página carregar
        updateDimensions();

        // Função que escuta o redimensionamento da caixa
        const resizeObserver = new ResizeObserver(() => {
            updateDimensions(); // Atualiza as dimensões após o redimensionamento
        });

        // Observar mudanças na caixa de seleção
        resizeObserver.observe(selectionBox);
    }

    // Função principal que inicializa todas as funcionalidades
    async function initializeApp() {
        const map = window.mapModule.initializeMap(); // Inicializa o mapa chamando a função do `map.js`
        // Variaveis e metodos globais
        window.map = map;
        // initializePrintButton(map);
        initializeSidebar(); // Inicializa a funcionalidade da sidebar
        initializeSelectionBox();
        initializeSearch(); // Inicializa a funcionalidade da pesquisa
        initializeExpandButton(); // Inicializa a funcionalidade do Fullscreen
        initializeTooltip(); // Inicializa a funcionalidade dos tooltips das actions button na sidebar

        initializeLayerToggles(map); // Inicializa os toggles de camadas
        window.mapModule.loadSobralBoundary(map); // Demarca o espaço geográfico de sobral chamando a funcao do map.js
    }

    // Executa a função principal quando o DOM estiver pronto
    document.addEventListener("DOMContentLoaded", () => {
        initializeApp();
    });
})();

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

    // Função para inicializar os botões da Action Bar que alterna entre seções dentro da sidebar
    function initializeActionButtons() {
        const btnCamadas = document.getElementById("btn-camadas");
        const btnMapasAtivos = document.getElementById("btn-mapas-ativos");

        btnCamadas.addEventListener("click", function () {
            // Exibe a div de Camadas e oculta a div de Mapas Ativos
            document.getElementById("view-camadas").style.display = "block";
            document.getElementById("view-mapas-ativos").style.display = "none";
            btnCamadas.classList.add("active");
            btnMapasAtivos.classList.remove("active");
        });

        btnMapasAtivos.addEventListener("click", function () {
            // Exibe a div de Mapas Ativos e oculta a div de Camadas
            document.getElementById("view-camadas").style.display = "none";
            document.getElementById("view-mapas-ativos").style.display =
                "block";
            btnMapasAtivos.classList.add("active");
            btnCamadas.classList.remove("active");
        });
    }

    function enableSwipeToDeleteAccordion(accordionId, onItemRemoved) {
        const accordionItems = document.querySelectorAll(
            `#${accordionId} .accordion-item`
        );

        accordionItems.forEach((item) => {
            let startX = 0;
            let currentX = 0;
            let isDragging = false;
            let hasMoved = false; // Flag para rastrear se o item foi deslizado ou não
            let isRemoved = false; // Flag para garantir que o item seja removido apenas uma vez

            // Iniciar o toque (touchstart) ou o mouse (mousedown)
            item.addEventListener("touchstart", handleTouchStart, {
                passive: true,
            });
            item.addEventListener("mousedown", handleMouseStart);

            // Mover (touchmove) ou mover o mouse (mousemove)
            item.addEventListener("touchmove", handleTouchMove, {
                passive: true,
            });
            item.addEventListener("mousemove", handleMouseMove);

            // Fim do toque (touchend) ou mouse (mouseup)
            item.addEventListener("touchend", handleTouchEnd);
            item.addEventListener("mouseup", handleMouseEnd);
            item.addEventListener("mouseleave", handleMouseEnd); // Para quando o mouse sai da área enquanto está arrastando

            function handleTouchStart(e) {
                startX = e.touches[0].clientX;
                isDragging = true;
                hasMoved = false; // Resetar a flag ao iniciar um novo arrasto
                isRemoved = false; // Resetar a flag ao iniciar um novo arrasto
                item.style.transition = "none"; // Remove a transição durante o arrasto
            }

            function handleMouseStart(e) {
                startX = e.clientX;
                isDragging = true;
                hasMoved = false; // Resetar a flag ao iniciar um novo arrasto
                isRemoved = false; // Resetar a flag ao iniciar um novo arrasto
                item.style.transition = "none"; // Remove a transição durante o arrasto
            }

            function handleTouchMove(e) {
                if (!isDragging || isRemoved) return;
                currentX = e.touches[0].clientX;
                const deltaX = currentX - startX;

                if (deltaX < -5) {
                    // Se o item começou a se mover, marcamos o hasMoved
                    hasMoved = true;
                }

                if (deltaX < 0) {
                    item.style.transform = `translateX(${deltaX}px)`; // Arrasta o item enquanto desliza
                }
            }

            function handleMouseMove(e) {
                if (!isDragging || isRemoved) return;
                currentX = e.clientX;
                const deltaX = currentX - startX;

                if (deltaX < -5) {
                    // Se o item começou a se mover, marcamos o hasMoved
                    hasMoved = true;
                }

                if (deltaX < 0) {
                    item.style.transform = `translateX(${deltaX}px)`; // Arrasta o item enquanto desliza
                }
            }

            function handleTouchEnd() {
                if (isRemoved || !hasMoved) return; // Apenas remove se o item foi deslizado
                isDragging = false;
                const deltaX = currentX - startX;

                if (deltaX < -100) {
                    // Se deslizou mais de 30px para a esquerda, removemos o item
                    slideOutAndRemove(item);
                } else {
                    item.style.transition = "transform 0.3s ease";
                    item.style.transform = "translateX(0)";
                }
            }

            function handleMouseEnd() {
                if (isRemoved || !hasMoved) return; // Apenas remove se o item foi deslizado
                isDragging = false;
                const deltaX = currentX - startX;

                if (deltaX < -100) {
                    // Se deslizou mais de 30px para a esquerda, removemos o item
                    slideOutAndRemove(item);
                } else {
                    item.style.transition = "transform 0.3s ease";
                    item.style.transform = "translateX(0)";
                }
            }

            function slideOutAndRemove(element) {
                isRemoved = true; // Marcar o item como removido
                element.style.transition =
                    "transform 0.3s ease, opacity 0.3s ease";
                element.style.transform = "translateX(-100%)"; // Move para fora da tela à esquerda
                element.style.opacity = "0"; // Adiciona efeito de desaparecimento
                setTimeout(() => {
                    element.remove(); // Remove o elemento após a animação
                    if (typeof onItemRemoved === "function") {
                        onItemRemoved(element); // Executa a função callback passando o elemento removido
                    }
                }, 300); // Espera 300ms (o tempo da animação)
            }
        });
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
        initializeActionButtons();

        enableSwipeToDeleteAccordion(
            "accordionMapasAtivos",
            function (removedElement) {
                console.log("Elemento removido:", removedElement);
                // Aqui você pode executar qualquer outra lógica, como uma notificação, por exemplo
                alert("Um item foi removido!");
            }
        );

        initializeLayerToggles(map); // Inicializa os toggles de camadas
        window.mapModule.loadSobralBoundary(map); // Demarca o espaço geográfico de sobral chamando a funcao do map.js
    }

    // Executa a função principal quando o DOM estiver pronto
    document.addEventListener("DOMContentLoaded", () => {
        initializeApp();
    });
})();

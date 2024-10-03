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
        const selectionButton = document.getElementById("selection-button");
        const selectionTools = document.querySelector(".selection-tools");
        const resolution = document.getElementById("resolution");
        const selectionArea = document.getElementById("selection-area");
        let isDragging = false;
        let startX, startY, offsetX, offsetY;

        // Verifica se os elementos estão presentes
        if (selectionButton && selectionTools) {
            selectionButton.addEventListener("click", function () {
                // Alterna a visibilidade da div "selection-tools"
                if (
                    selectionTools.style.display === "none" ||
                    selectionTools.style.display === ""
                ) {
                    selectionButton.classList.add("active");
                    selectionTools.style.display = "block"; // Exibe o selection-tools
                } else {
                    selectionTools.style.display = "none"; // Oculta o selection-tools
                    selectionButton.classList.remove("active");
                }
            });
        }

        // Função para atualizar as dimensões no cabeçalho
        function updateDimensions() {
            const width = selectionArea.offsetWidth;
            const height = selectionArea.offsetHeight;
            resolution.innerHTML = `${width} x ${height}`;
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
        const btnImpressao = document.getElementById("btn-imprimir");
        const selectionBox = document.getElementById("selection-box");

        btnImpressao.addEventListener("click", function () {
            // Alterna a visibilidade do componente
            if (
                selectionBox.style.display === "none" ||
                selectionBox.style.display === ""
            ) {
                btnImpressao.classList.add("active");
                selectionBox.style.display = "flex"; // Exibe o componente
            } else {
                btnImpressao.classList.remove("active");
                selectionBox.style.display = "none"; // Oculta o componente
            }
        });

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

    function enableSwipeToDeleteAccordion(accordionId) {
        const items = document.querySelectorAll(
            `#${accordionId} .accordion-item`
        );

        items.forEach((item) => {
            let startX = 0;
            let currentX = 0;
            let threshold = 80; // Limiar para remover o item
            let isSwiping = false;
            let isMouseDown = false; // Flag para verificar se o mouse está pressionado
            let isMoving = false; // Flag para verificar se está havendo movimento
            let allowSwipe = false; // Flag para permitir o arraste
            let holdTimeout = null; // Timeout para contar os 5 segundos

            // Função para iniciar o arrasto
            function startSwipe(x) {
                startX = x;
                isSwiping = true;
                isMoving = false; // Resetar flag de movimento
            }

            // Função para processar o movimento
            function moveSwipe(x) {
                if (!isSwiping || !allowSwipe) return; // Só permitir o movimento se o arraste for autorizado
                currentX = x;
                let deltaX = currentX - startX;

                if (Math.abs(deltaX) > 10) {
                    // Se houver movimento significativo, ativar a flag de movimento
                    isMoving = true;
                }
                if (Math.abs(deltaX) > threshold && allowSwipe) {
                    item.classList.add("layer-deleting");
                }

                if (deltaX < 0) {
                    // Apenas seguir o arraste para a esquerda
                    item.style.transform = `translateX(${deltaX}px)`;
                }
            }

            // Função para finalizar o arrasto
            function endSwipe() {
                if (isMoving) {
                    let deltaX = currentX - startX;

                    if (Math.abs(deltaX) > threshold && allowSwipe) {
                        // Se o arraste for maior que o limiar, remova o item
                        item.style.transition = "transform 0.3s ease";
                        item.style.transform = `translateX(-100%)`;

                        setTimeout(() => {
                            item.remove(); // Remove o item após a animação
                        }, 300);
                    } else {
                        // Volta ao estado original se o arraste for muito pequeno ou se não foi autorizado
                        item.style.transition = "transform 0.3s ease";
                        item.style.transform = "translateX(0)";
                        item.classList.remove("layer-deleting");
                    }
                }

                isMoving = false;
                isSwiping = false;
                isMouseDown = false;
                allowSwipe = false; // Reseta o estado para a próxima vez
            }

            // Inicia o temporizador de 5 segundos ao pressionar o botão
            function startHold() {
                holdTimeout = setTimeout(() => {
                    allowSwipe = true; // Permitir o arraste após 5 segundos
                    //item.classList.add("layer-deleting");
                }, 500); // Aguardar 5 segundos
            }

            // Cancela o temporizador se o mouse ou o dedo for solto antes dos 5 segundos
            function cancelHold() {
                clearTimeout(holdTimeout); // Cancela o timeout se o mouse for solto antes de 5 segundos
            }

            // Eventos para mobile
            item.addEventListener("touchstart", (e) => {
                startHold(); // Inicia o temporizador de 5 segundos
                startSwipe(e.touches[0].clientX);
            });

            item.addEventListener("touchmove", (e) => {
                moveSwipe(e.touches[0].clientX);
            });

            item.addEventListener("touchend", (e) => {
                cancelHold(); // Cancela o temporizador se o arrasto for interrompido
                if (isMoving) {
                    endSwipe();
                }
            });

            // Eventos para desktop (mouse)
            item.addEventListener("mousedown", (e) => {
                isMouseDown = true;
                startHold(); // Inicia o temporizador de 5 segundos
                startSwipe(e.clientX);
            });

            item.addEventListener("mousemove", (e) => {
                if (!isMouseDown) return; // Apenas mover se o mouse estiver pressionado
                moveSwipe(e.clientX);
            });

            item.addEventListener("mouseup", (e) => {
                cancelHold(); // Cancela o temporizador se o arrasto for interrompido
                if (isMoving) {
                    endSwipe();
                } else {
                    isMouseDown = false;
                    isSwiping = false;
                    allowSwipe = false;
                }
            });

            item.addEventListener("mouseleave", () => {
                cancelHold(); // Cancela o temporizador se o mouse sair do item
                if (isMouseDown && isMoving) {
                    endSwipe();
                }
            });
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

        enableSwipeToDeleteAccordion("accordionMapasAtivos");

        initializeLayerToggles(map); // Inicializa os toggles de camadas
        window.mapModule.loadSobralBoundary(map); // Demarca o espaço geográfico de sobral chamando a funcao do map.js
    }

    // Executa a função principal quando o DOM estiver pronto
    document.addEventListener("DOMContentLoaded", () => {
        initializeApp();
    });
})();

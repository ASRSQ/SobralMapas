import { toggleLayer } from "./map";

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
    const elements = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    elements.forEach((el) => {
        new bootstrap.Tooltip(el);
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

function toggleFullScreen() {
    // Verifica se o navegador está no modo de tela cheia
    if (!document.fullscreenElement && !document.webkitFullscreenElement) {
        // Para navegadores que não são Safari
        if (document.documentElement.requestFullscreen) {
            document.documentElement.requestFullscreen().catch((err) => {
                console.log(
                    `Erro ao tentar ativar o modo de tela cheia: ${err.message}`
                );
            });
        }
        // Para o Safari no iPhone
        else if (document.documentElement.webkitRequestFullscreen) {
            document.documentElement.webkitRequestFullscreen();
        }
    } else {
        // Para sair do modo de tela cheia
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        }
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
// Inicializa os toggles das camadas
function initializeLayerToggles() {
    document.querySelectorAll(".layer-toggle").forEach((checkbox) => {
        checkbox.addEventListener("change", function () {
            // Converte o atributo data-layer de volta para objeto JSON
            const layerData = JSON.parse(this.getAttribute("data-layer"));

            // Chama toggleLayer passando o mapa e os dados da camada
            toggleLayer(window.map, layerData, this.checked);

            // Atualiza a exibição das legendas
            updateLegends(layerData, this.checked);
        });
    });
}

// Função para atualizar as legendas em "Mapas Ativos"
function updateLegends(layerData, isChecked) {
    console.log("🛠 Dados recebidos em RemoveWmsLayer:", JSON.stringify(layerData, null, 2));
    
    if (typeof layerData === "string") {
        try {
            layerData = JSON.parse(layerData);
            console.log("✅ JSON convertido para objeto:", layerData);
        } catch (error) {
            console.error("❌ ERRO ao converter JSON para objeto:", error);
            return;
        }
    }
    const layerName = layerData.layer_name;

    const layerElement = document.getElementById(`active-layer-${layerName}`);
    if (layerElement) {
        if (isChecked) {
            // Se marcado, exibe a camada nos "Mapas Ativos"
            layerElement.style.display = "block";
            console.log(`✅ Camada ${layerName} adicionada à seção de legendas.`);
        } else {
            // Se desmarcado, oculta dos "Mapas Ativos"
            layerElement.style.display = "none";
            console.log(`❌ Camada ${layerName} removida da seção de legendas.`);
        }
    } else {
        console.warn(`⚠️ Elemento de legenda para "${layerName}" não encontrado.`);
    }
}



function enableSwipeToDeleteAccordion(accordionId) {
    const items = document.querySelectorAll(`#${accordionId} .accordion-item`);

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
        document.getElementById("view-mapas-ativos").style.display = "block";
        btnMapasAtivos.classList.add("active");
        btnCamadas.classList.remove("active");
    });
}

export function InitializeUI() {
    initializeSidebar();
    initializeTooltip();
    initializeSearch();
    toggleFullScreen();
    initializeExpandButton();
    initializeLayerToggles();
    enableSwipeToDeleteAccordion("accordionMapasAtivos");
    initializeActionButtons();
}

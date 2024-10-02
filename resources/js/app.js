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

    function initializeFloatingButton() {
        const floatingButton = document.getElementById("floating-button");
    
        function dragElement(el) {
            let pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
        
            el.onmousedown = function (e) {
                // Verifica se o alvo do clique é um dropdown ou select
                if (e.target.closest('.dropdown-menu') || e.target.closest('select')) {
                    return; // Não permite arrastar
                }
                
                e.preventDefault();
                pos3 = e.clientX;
                pos4 = e.clientY;
        
                document.onmouseup = closeDragElement;
                document.onmousemove = elementDrag;
            };
        
            function elementDrag(e) {
                e.preventDefault();
                pos1 = pos3 - e.clientX;
                pos2 = pos4 - e.clientY;
                pos3 = e.clientX;
                pos4 = e.clientY;
        
                el.style.top = (el.offsetTop - pos2) + "px";
                el.style.left = (el.offsetLeft - pos1) + "px";
            }
        
            function closeDragElement() {
                document.onmouseup = null;
                document.onmousemove = null;
            }
        }
        
    
        // Ativando a funcionalidade de arraste no botão flutuante
        if (floatingButton) {
            dragElement(floatingButton);
        }
        
    }
    function initializeMeasure() {
        let draw;
        let sketch;
        let helpTooltipElement;
        let measureTooltipElement;
        let measureTooltip;
        let helpTooltip;
        let selectedLineColor = '#ffcc33'; // Cor padrão da linha e bolinha
        let selectedLineWidth = 2; // Largura padrão
    
        // Elementos HTML
        const measureLineButton = document.getElementById('measure-line');
        const measureAreaButton = document.getElementById('measure-area');
        const lineColorPicker = document.getElementById('line-color-picker');
        const lineWidthPicker = document.getElementById('line-width-picker');
        const lineWidthValue = document.getElementById('line-width-value');
        const clearDrawingsButton = document.getElementById('clear-drawings');
        const stopDrawingButton = document.getElementById('stop-drawing');
    
        const source = new ol.source.Vector({
            wrapX: false,
        });
    
        // Camada de vetor para as geometrias
        const vectorLayer = new ol.layer.Vector({
            source: source,
            style: function (feature) {
                return new ol.style.Style({
                    stroke: new ol.style.Stroke({
                        color: selectedLineColor,
                        width: 2,
                    }),
                    fill: new ol.style.Fill({
                        color: hexToRGBA(selectedLineColor, 0.4), // Cor preenchida semi-transparente
                    }),
                    image: new ol.style.Circle({
                        radius: 5,
                        fill: new ol.style.Fill({
                            color: selectedLineColor, // Cor da bolinha
                        }),
                        stroke: new ol.style.Stroke({
                            color: '#000000',
                            width: 1,
                        }),
                    }),
                });
            }
        });
    
        window.map.addLayer(vectorLayer);
    
        // Converte hexadecimal para RGBA
        function hexToRGBA(hex, alpha) {
            let r = parseInt(hex.slice(1, 3), 16);
            let g = parseInt(hex.slice(3, 5), 16);
            let b = parseInt(hex.slice(5, 7), 16);
            return `rgba(${r}, ${g}, ${b}, ${alpha})`;
        }
    
        // Atualiza a cor da linha e do polígono com base no seletor de cor
        function updateLineColor(color) {
            selectedLineColor = color;
            vectorLayer.setStyle(function (feature) {
                return new ol.style.Style({
                    stroke: new ol.style.Stroke({
                        color: selectedLineColor,
                        width: 2,
                    }),
                    fill: new ol.style.Fill({
                        color: hexToRGBA(selectedLineColor, 0.4), // Preenchimento semi-transparente
                    }),
                    image: new ol.style.Circle({
                        radius: 5,
                        fill: new ol.style.Fill({
                            color: selectedLineColor, // Bolinha com a cor atual
                        }),
                        stroke: new ol.style.Stroke({
                            color: '#000000',
                            width: 1,
                        }),
                    }),
                });
            });
        }
       
        


    
        // Define o tipo de desenho (linha ou polígono)
        function setDrawType(type) {
            if (draw) {
                window.map.removeInteraction(draw);
            }
    
            draw = new ol.interaction.Draw({
                source: source,
                type: type,
                style: function (feature) {
                    return new ol.style.Style({
                        stroke: new ol.style.Stroke({
                            color: selectedLineColor,
                            width: 2,
                            lineDash: [10, 10],
                        }),
                        fill: new ol.style.Fill({
                            color: hexToRGBA(selectedLineColor, 0.4), // Preenchimento semi-transparente durante o desenho
                        }),
                        image: new ol.style.Circle({
                            radius: 5,
                            fill: new ol.style.Fill({
                                color: selectedLineColor, // Cor da bolinha
                            }),
                            stroke: new ol.style.Stroke({
                                color: '#000000',
                                width: 1,
                            }),
                        }),
                    });
                },
            });
    
            window.map.addInteraction(draw);
            createMeasureTooltip();
            createHelpTooltip();
    
            draw.on('drawstart', function (evt) {
                sketch = evt.feature;
                let tooltipCoord = evt.coordinate;
    
                sketch.getGeometry().on('change', function (evt) {
                    const geom = evt.target;
                    let output;
                    if (geom instanceof ol.geom.Polygon) {
                        output = `<span>${formatArea(geom)}</span>`;
                        tooltipCoord = geom.getInteriorPoint().getCoordinates();
                    } else if (geom instanceof ol.geom.LineString) {
                        output = `<span>${formatLength(geom)}</span>`;
                        tooltipCoord = geom.getLastCoordinate();
                    }
                    measureTooltipElement.innerHTML = output;
                    measureTooltip.setPosition(tooltipCoord);
                });
            });
    
            draw.on('drawend', function () {
                sketch.setStyle(new ol.style.Style({
                    stroke: new ol.style.Stroke({
                        color: selectedLineColor,
                        width: 2,
                        lineDash: null,
                    }),
                    fill: new ol.style.Fill({
                        color: hexToRGBA(selectedLineColor, 0.4), // Preenchimento após o desenho
                    }),
                    image: new ol.style.Circle({
                        radius: 5,
                        fill: new ol.style.Fill({
                            color: selectedLineColor,
                        }),
                        stroke: new ol.style.Stroke({
                            color: '#000000',
                            width: 1,
                        }),
                    }),
                }));
                measureTooltipElement.className = 'ol-tooltip ol-tooltip-static';
                measureTooltip.setOffset([0, -7]);
                sketch = null;
                measureTooltipElement = null;
                createMeasureTooltip();
            });
        }
    
        // Criação dos tooltips de ajuda e medição
        function createHelpTooltip() {
            if (helpTooltipElement) {
                helpTooltipElement.remove();
            }
            helpTooltipElement = document.createElement('div');
            helpTooltipElement.className = 'ol-tooltip hidden';
            helpTooltip = new ol.Overlay({
                element: helpTooltipElement,
                offset: [15, 0],
                positioning: 'center-left',
            });
            window.map.addOverlay(helpTooltip);
        }
    
        function createMeasureTooltip() {
            if (measureTooltipElement) {
                measureTooltipElement.remove();
            }
            measureTooltipElement = document.createElement('div');
            measureTooltipElement.className = 'ol-tooltip ol-tooltip-measure';
            measureTooltip = new ol.Overlay({
                element: measureTooltipElement,
                offset: [0, -15],
                positioning: 'bottom-center',
                stopEvent: false,
                insertFirst: false,
            });
            window.map.addOverlay(measureTooltip);
        }
    
        // Formata área e comprimento
        function formatArea(polygon) {
            const area = ol.sphere.getArea(polygon);
            return (area > 10000)
                ? `${Math.round((area / 1000000) * 100) / 100} km²`
                : `${Math.round(area * 100) / 100} m²`;
        }
    
        function formatLength(line) {
            const length = ol.sphere.getLength(line);
            return (length > 100)
                ? `${Math.round((length / 1000) * 100) / 100} km`
                : `${Math.round(length * 100) / 100} m`;
        }
    
        // Limpa todas as geometrias desenhadas e tooltips
        function clearDrawings() {
            source.clear();
            window.map.getOverlays().getArray().slice().forEach(function (overlay) {
                if (overlay.getElement().classList.contains('ol-tooltip')) {
                    window.map.removeOverlay(overlay);
                }
            });
            if (measureTooltipElement) {
                measureTooltipElement.innerHTML = '';
            }
            if (helpTooltipElement) {
                helpTooltipElement.classList.add('hidden');
            }
            createMeasureTooltip();
            createHelpTooltip();
        }
    
        // Eventos para definir o tipo de medição
        measureLineButton.addEventListener('click', function(event) {
            event.preventDefault();
            setDrawType('LineString');
        });
    
        measureAreaButton.addEventListener('click', function(event) {
            event.preventDefault();
            setDrawType('Polygon');
        });
    
        // Atualiza a cor conforme a escolha do usuário
        lineColorPicker.addEventListener('input', function() {
            updateLineColor(this.value);
        });

   

        clearDrawingsButton.addEventListener('click', function() {
            clearDrawings();
        });

         // Adiciona um evento para o botão que para o desenho
        stopDrawingButton.addEventListener('click', function(event) {
            event.preventDefault();
            if (draw) {
                window.map.removeInteraction(draw);
                draw = null; // Limpa a variável draw para que não haja referências pendentes
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
        initializeFloatingButton() ;
        initializeMeasure();

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

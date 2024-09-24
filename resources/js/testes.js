// -------------------------------- metodo 1 -----------------
function initializePrintButtons(map) {
    document
        .getElementById("resize-button")
        .addEventListener("click", function () {
            resizeMapToA4(map);
        });

    document
        .getElementById("print-button")
        .addEventListener("click", function () {
            printCurrentMap(map);
        });
}
function resizeMapToA4(map) {
    // Salvar o tamanho e visualização originais do mapa
    originalSize = map.getSize();
    originalView = map.getView();
    originalResolution = originalView.getResolution();
    originalCenter = originalView.getCenter();

    // Proporção A4 é aproximadamente 1:1.4142 (210mm x 297mm)
    var aspectRatio = 1 / 1.4142;

    // Definir a largura e altura desejadas do mapa em pixels
    var width = 800; // Largura em pixels (ajuste conforme necessário)
    var height = Math.round(width / aspectRatio);

    // Redimensionar o mapa
    map.setSize([width, height]);

    // Atualizar o tamanho do elemento HTML que contém o mapa
    var mapContainer = document.getElementById("map");
    mapContainer.style.width = width + "px";
    mapContainer.style.height = height + "px";
    // mapContainer.style.marginLeft = "200px";

    // Avisar o OpenLayers sobre a mudança de tamanho
    map.updateSize();

    // Manter o centro e resolução originais (opcional)
    map.getView().setCenter(originalCenter);
    map.getView().setResolution(originalResolution);

    // Habilitar o botão de impressão
    document.getElementById("print-button").disabled = false;

    // Desabilitar o botão de redimensionar para evitar múltiplos ajustes
    document.getElementById("resize-button").disabled = true;
}

function printCurrentMap(map) {
    // Inicia a impressão
    window.print();

    // Restaurar o tamanho original após a impressão
    restoreOriginalMapSize(map);
}

function restoreOriginalMapSize(map) {
    // Restaurar o tamanho original
    map.setSize(originalSize);

    // Restaurar o tamanho do elemento HTML que contém o mapa
    var mapContainer = document.getElementById("map");
    mapContainer.style.width = "";
    mapContainer.style.height = "";

    // Avisar o OpenLayers sobre a mudança de tamanho
    map.updateSize();

    // Restaurar a visualização original
    map.getView().setCenter(originalCenter);
    map.getView().setResolution(originalResolution);

    // Desabilitar o botão de impressão
    document.getElementById("print-button").disabled = true;

    // Habilitar o botão de redimensionar novamente
    document.getElementById("resize-button").disabled = false;
}

// ------------------------------- metodo 2 ------------------

function initializeAreaSelection(map) {
    var dragBox = new ol.interaction.DragBox({
        condition: ol.events.condition.shiftKeyOnly,
    });

    map.addInteraction(dragBox);

    dragBox.on("boxend", function () {
        selectedExtent = dragBox.getGeometry().getExtent();
        console.log("Área selecionada para impressão: ", selectedExtent);

        // Habilita o botão de exportação
        document.getElementById("export-button").disabled = false;
    });

    dragBox.on("boxstart", function () {
        console.log("Iniciando seleção de área para impressão");
    });

    // Adiciona um listener ao botão de exportação
    document
        .getElementById("export-button")
        .addEventListener("click", function () {
            exportMapArea(map, selectedExtent);
        });
}

function exportMapArea(map, extent) {
    var view = map.getView();
    var originalResolution = view.getResolution();
    var originalCenter = view.getCenter();
    var originalSize = map.getSize();

    // Proporção A4 é aproximadamente 1:1.4142 (210mm x 297mm)
    var aspectRatio = 1 / 1.4142;

    // Definir a largura desejada do canvas
    var canvasWidth = 1200; // Você pode ajustar este valor para aumentar a resolução
    var canvasHeight = Math.round(canvasWidth / aspectRatio);

    // Ajustar o tamanho do mapa para corresponder ao tamanho do canvas
    map.setSize([canvasWidth, canvasHeight]);

    // Ajustar a visualização para a extensão selecionada com o novo tamanho
    view.fit(extent, { size: [canvasWidth, canvasHeight] });

    map.once("rendercomplete", function () {
        // Criar um canvas com as dimensões calculadas
        var mapCanvas = document.createElement("canvas");
        mapCanvas.width = canvasWidth;
        mapCanvas.height = canvasHeight;
        var mapContext = mapCanvas.getContext("2d");

        // Iterar sobre os canvases das camadas e desenhá-los no canvas criado
        document
            .querySelectorAll(".ol-layer canvas")
            .forEach(function (canvas) {
                if (canvas.width > 0) {
                    var opacity = canvas.parentNode.style.opacity;
                    mapContext.globalAlpha =
                        opacity === "" ? 1 : Number(opacity);

                    var transform = canvas.style.transform;
                    // Remover "matrix(" e ")" e dividir os valores
                    var matrix = transform
                        .match(/^matrix\(([^\(]*)\)$/)[1]
                        .split(",")
                        .map(Number);
                    mapContext.setTransform(
                        matrix[0],
                        matrix[1],
                        matrix[2],
                        matrix[3],
                        matrix[4],
                        matrix[5]
                    );

                    mapContext.drawImage(canvas, 0, 0);
                }
            });

        // Converter o canvas em uma imagem e abrir em uma nova janela para impressão
        var imgData = mapCanvas.toDataURL("image/png");

        // Criar uma nova janela e inserir a imagem
        var printWindow = window.open("", "_blank");
        printWindow.document.open();
        printWindow.document.write(`
            <html>
                <head>
                    <title>Imprimir Mapa</title>
                    <style>
                        body {
                            margin: 0;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                        }
                        img {
                            max-width: 100%;
                            max-height: 100%;
                        }
                    </style>
                </head>
                <body>
                    <img src="${imgData}" />
                </body>
            </html>
        `);
        printWindow.document.close();

        // Aguarda o carregamento da imagem e inicia a impressão
        printWindow.onload = function () {
            printWindow.print();
        };

        // Restaurar a visualização e o tamanho originais
        view.setResolution(originalResolution);
        view.setCenter(originalCenter);
        map.setSize(originalSize);

        // Desabilitar o botão após a exportação
        document.getElementById("export-button").disabled = true;
    });

    // Forçar a renderização do mapa
    map.renderSync();
}

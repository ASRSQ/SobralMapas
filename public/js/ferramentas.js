 // Variáveis globais para a interação de desenho
 let draw;
 let sketch;
 let helpTooltipElement;
 let measureTooltipElement;
 let selectedLineColor = '#ffcc33'; // Cor padrão da linha

 // Função para atualizar a cor da linha com base na escolha do usuário
 function updateLineColor(color) {
     selectedLineColor = color;
 }

 // Função para configurar o tipo de desenho (linha ou polígono)
 function setDrawType(type) {
     if (draw) {
         map.removeInteraction(draw); // Remove a interação de desenho anterior (se existir)
     }

     const drawingStyle = new ol.style.Style({
         stroke: new ol.style.Stroke({
             color: selectedLineColor + '88',
             width: 2,
             lineDash: [10, 10],
         }),
         fill: new ol.style.Fill({
             color: 'rgba(255, 255, 255, 0.3)',
         }),
         image: new ol.style.Circle({
             radius: 5,
             fill: new ol.style.Fill({
                 color: selectedLineColor + '88',
             }),
             stroke: new ol.style.Stroke({
                 color: '#000000',
                 width: 1,
             }),
         }),
     });

     draw = new ol.interaction.Draw({
         source: source,
         type: type,
         style: function (feature, resolution) {
             const geom = feature.getGeometry();
             const styles = [drawingStyle];
             geom.getCoordinates().forEach(function (coord) {
                 styles.push(new ol.style.Style({
                     geometry: new ol.geom.Point(coord),
                     image: new ol.style.Circle({
                         radius: 5,
                         fill: new ol.style.Fill({
                             color: selectedLineColor + '88',
                         }),
                         stroke: new ol.style.Stroke({
                             color: '#000000',
                             width: 1,
                         }),
                     }),
                 }));
             });
             return styles;
         },
     });

     map.addInteraction(draw);
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
                 color: 'rgba(255, 255, 255, 0.4)',
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

 // Funções para criar tooltips de ajuda e medição
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
     map.addOverlay(helpTooltip);
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
     map.addOverlay(measureTooltip);
 }

 // Funções para formatar área e comprimento
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

 // Função para limpar todas as geometrias desenhadas e tooltips
 function clearDrawings() {
     source.clear();
     map.getOverlays().getArray().slice().forEach(function (overlay) {
         if (overlay.getElement().classList.contains('ol-tooltip')) {
             map.removeOverlay(overlay);
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
 // Opções do mapa para exportação/impressão
 const dims = {
    a0: [1189, 841],
    a1: [841, 594],
    a2: [594, 420],
    a3: [420, 297],
    a4: [297, 210],
    a5: [210, 148],
};

const exportOptions = {
    useCORS: true,
    ignoreElements: function (element) {
        const computedStyle = getComputedStyle(element);
        if (computedStyle.color.includes('oklch')) {
            element.style.color = 'rgb(0, 0, 0)'; // Substitui oklch por preto
        }
        const className = element.className || '';
        return className.includes('ol-control') && !className.includes('ol-scale');
    },
};
// Função para imprimir diretamente pelo navegador ocupando toda a página e em modo paisagem
document.getElementById('print-direct').addEventListener('click', function () {
    const format = document.getElementById('format').value;
    const resolution = document.getElementById('resolution').value;
    const scale = document.getElementById('scale').value;
    const dim = dims[format];
    const width = Math.round((dim[0] * resolution) / 25.4);
    const height = Math.round((dim[1] * resolution) / 25.4);
    const viewResolution = map.getView().getResolution();
    const scaleResolution = scale / ol.proj.getPointResolution(
        map.getView().getProjection(),
        resolution / 25.4,
        map.getView().getCenter()
    );

    map.once('rendercomplete', function () {
        const targetElement = map.getViewport();

        // Configurando as opções de alta resolução para o html2canvas
        const exportOptions = {
            width: width,
            height: height,
            scale: 3,  // Aumentar a escala para maior qualidade
            useCORS: true,
            ignoreElements: function (element) {
                const computedStyle = getComputedStyle(element);
                return element.className.includes('ol-control') && !element.className.includes('ol-scale');
            }
        };

        html2canvas(targetElement, exportOptions).then(function (canvas) {
            // Criando uma nova janela de impressão
            const printWindow = window.open('', '_blank');
            printWindow.document.write(`
                <html>
                <head>
                    <title>Imprimir Mapa</title>
                    <style>
                        @page { size: landscape; margin: 0; }
                        body { margin: 0; display: flex; justify-content: center; align-items: center; }
                        img { width: 100vw; height: 100vh; object-fit: cover; }
                    </style>
                </head>
                <body>
                    <img src="${canvas.toDataURL('image/jpeg')}">
                </body>
                </html>
            `);
            printWindow.document.close();

            // Timeout para garantir o carregamento antes da impressão
            printWindow.onload = function () {
                setTimeout(function () {
                    printWindow.focus();
                    printWindow.print();
                    printWindow.close();
                }, 1000);  // Tempo de espera para garantir que a imagem seja carregada
            };
        });
    });

    map.getTargetElement().style.width = width + 'px';
    map.getTargetElement().style.height = height + 'px';
    map.updateSize();
    map.getView().setResolution(scaleResolution);
});


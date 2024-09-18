// URL do serviço WMS e GeoJSON
const wmsUrl = "http://geoserver.sobral.ce.gov.br/geoserver/ows";
const geoJsonUrl = "https://polygons.openstreetmap.fr/get_geojson.py?id=302610&params=0";

// Definindo o source globalmente
const source = new ol.source.Vector({
    wrapX: false,
});

// Definindo o estilo globalmente
const defaultStyle = new ol.style.Style({
    fill: new ol.style.Fill({
        color: 'rgba(255, 255, 255, 0.2)',
    }),
    stroke: new ol.style.Stroke({
        color: 'rgba(0, 0, 0, 0.5)',
        lineDash: [10, 10], // Linha pontilhada por padrão
        width: 2,
    }),
    image: new ol.style.Circle({
        radius: 5,
        stroke: new ol.style.Stroke({
            color: 'rgba(0, 0, 0, 0.7)',
        }),
        fill: new ol.style.Fill({
            color: 'rgba(255, 255, 255, 0.2)',
        }),
    }),
});

// Adicionando uma camada de vetores ao mapa
const vector = new ol.layer.Vector({
    source: source,
    style: defaultStyle, // Aplica o estilo pontilhado inicialmente
});

// Definindo a camada raster (fundo do mapa)
const raster = new ol.layer.Tile({
    source: new ol.source.OSM(),
});

// Criar o mapa com camada base OpenStreetMap
let map = new ol.Map({
    target: "map",
    layers: [
        raster,
        vector, // Adiciona a camada vetorial ao mapa
    ],
    view: new ol.View({
        center: ol.proj.fromLonLat([-40.3526, -3.6857]), // Coordenadas centradas em Sobral
        zoom: 12,
    }),
});

// Adicionar a linha de escala ao mapa
const scaleLine = new ol.control.ScaleLine({
    bar: true,   // Mostrar a barra de escala
    text: true,  // Mostrar o texto indicando a escala
    minWidth: 100 // Largura mínima da barra
});
map.addControl(scaleLine);

// Adicionar a camada vetorial GeoJSON
const vectorLayer = new ol.layer.Vector({
    source: new ol.source.Vector({
        format: new ol.format.GeoJSON(),
        url: geoJsonUrl,
    }),
    style: new ol.style.Style({
        stroke: new ol.style.Stroke({
            color: "blue",
            width: 3,
            lineDash: [4], // Linha pontilhada
        }),
    }),
});
map.addLayer(vectorLayer);

// Função para adicionar/remover camadas do mapa
function toggleLayer(layerName, addLayer) {
    if (addLayer) {
        const existingLayer = map
            .getLayers()
            .getArray()
            .find((layer) => layer.get("name") === layerName);
        if (!existingLayer) {
            const newLayer = new ol.layer.Tile({
                source: new ol.source.TileWMS({
                    url: `${window.location.origin}/sobralmapas/public/api/proxy-wms`, // URL do proxy
                    params: { LAYERS: layerName, TILED: true },
                    serverType: "geoserver",
                    transition: 0,
                }),
                name: layerName,
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
    const layerToRemove = layers.find(
        (layer) => layer.get("name") === layerName
    );
    if (layerToRemove) {
        map.removeLayer(layerToRemove);
    }
}

// Função para recuperar camadas já selecionadas
function getSelectedLayers() {
    return Array.from(
        document.querySelectorAll(
            '#layerCheckboxList input[type="checkbox"]:checked'
        )
    ).map((checkbox) => checkbox.id);
}

// Torna a função acessível globalmente
window.getSelectedLayers = getSelectedLayers;

// Event listener para alterações nas checkboxes de camadas
layerCheckboxList.addEventListener("change", (event) => {
    if (event.target.type === "checkbox") {
        toggleLayer(event.target.id, event.target.checked);
        updateCustomMapDropdown();
        updateLegend();
    }
});

// Função para exportar o mapa para PDF
document.getElementById('export-pdf').addEventListener('click', function () {
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
        map.getView().getCenter());

    map.once('rendercomplete', function () {
        exportOptions.width = width;
        exportOptions.height = height;
        html2canvas(map.getViewport(), exportOptions).then(function (canvas) {
            const pdf = new jspdf.jsPDF('landscape', undefined, format);
            pdf.addImage(canvas.toDataURL('image/jpeg'), 'JPEG', 0, 0, dim[0], dim[1]);
            pdf.save('map.pdf');
            scaleLine.setDpi(); // Garantir que isso seja definido corretamente, ou remova se a versão do OpenLayers não suportar
            map.getTargetElement().style.width = '';
            map.getTargetElement().style.height = '';
            map.updateSize();
            map.getView().setResolution(viewResolution);
        });
    });

    scaleLine.setDpi(resolution);
    map.getTargetElement().style.width = width + 'px';
    map.getTargetElement().style.height = height + 'px';
    map.updateSize();
    map.getView().setResolution(scaleResolution);
}, false);

// Função para imprimir diretamente pelo navegador
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
        map.getView().getCenter());

    map.once('rendercomplete', function () {
        exportOptions.width = width;
        exportOptions.height = height;
        html2canvas(map.getViewport(), exportOptions).then(function (canvas) {
            const printWindow = window.open('', '_blank');
            printWindow.document.write('<html><head><title>Imprimir Mapa</title></head><body>');
            printWindow.document.write('<img src="' + canvas.toDataURL('image/jpeg') + '" style="width:100%;">');
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.onload = function () {
                printWindow.focus();
                printWindow.print();
                printWindow.close();
            };
        });
    });

    scaleLine.setDpi(resolution); // Garantir que isso seja definido corretamente, ou remova se a versão do OpenLayers não suportar
    map.getTargetElement().style.width = width + 'px';
    map.getTargetElement().style.height = height + 'px';
    map.updateSize();
    map.getView().setResolution(scaleResolution);
});

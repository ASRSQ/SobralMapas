const { Resolver } = require("laravel-mix/src/Resolver");
const { VERSION } = require("lodash");

// IIFE (Immediately Invoked Function Expression) para encapsular o código
(() => {
    let layersCache = {};

    // Inicializa o mapa com OSM e configura o pré-carregamento de tiles
    function initializeMap() {
        var map = new ol.Map({
            target: "map",
            layers: [
                new ol.layer.Tile({
                    source: new ol.source.OSM(),
                    preload: 10, // Preload de 4 níveis de tiles ao redor
                }),
            ],
            view: new ol.View({
                center: ol.proj.fromLonLat([-40.35, -3.69]),
                zoom: 15,
                maxZoom: 17,
                minZoom: 10,
                projection: ol.proj.get("EPSG:3857"),
            }),
            interactions: ol.interaction.defaults({
                // Configura a sensibilidade do zoom ao usar o scroll do mouse
                mouseWheelZoom: new ol.interaction.MouseWheelZoom({
                    duration: 100, // Duração da animação de zoom, em milissegundos
                    zoomDelta: 10, // Controla o quanto o zoom aumenta ou diminui a cada rotação do scroll
                }),
            }),
        });

        return map;
    }

    // Função para carregar e adicionar o polígono de Sobral via GeoJSON
    async function loadSobralBoundary(map) {
        // URL para o GeoJSON de Sobral
        var geojsonUrl =
            "https://polygons.openstreetmap.fr/get_geojson.py?id=302610&params=0";

        try {
            // Carrega o GeoJSON usando ol.source.Vector
            var vectorSource = new ol.source.Vector({
                url: geojsonUrl,
                format: new ol.format.GeoJSON(),
            });

            // Estilo para a linha do polígono
            var lineStyle = new ol.style.Style({
                stroke: new ol.style.Stroke({
                    color: "#FF0000", // Cor da linha (vermelho)
                    width: 3, // Espessura da linha
                }),
            });

            // Cria a camada vetorial com o GeoJSON
            var vectorLayer = new ol.layer.Vector({
                source: vectorSource,
                style: lineStyle,
            });

            // Adiciona a camada ao mapa
            map.addLayer(vectorLayer);
        } catch (error) {
            console.error("Erro ao carregar o polígono de Sobral:", error);
        }
    }

    // Função para exibir mensagem de erro personalizada
    async function showError(message, layerName) {
        const errorMessageElement = document.getElementById("error-message");
        const layerLabel = document.getElementById(layerName);
        const layerIconAlert = layerLabel?.nextElementSibling;

        layerLabel.classList.add("error-layer");
        layerIconAlert.classList.remove("hide-layer-alert");
        layerIconAlert.classList.add("show-layer-alert");

        errorMessageElement.textContent = message;
        errorMessageElement.style.top = "10px";
        errorMessageElement.style.display = "block";

        // Oculta a mensagem após 5 segundos (5000 milissegundos)
        await new Promise((resolve) => setTimeout(resolve, 3000));
        errorMessageElement.style.display = "none";
        errorMessageElement.style.top = "-10px";
    }

    // Função para adicionar uma camada WMS ao mapa com cache habilitado
    async function addWmsLayer(map, layerName) {
        try {
            if (layersCache[layerName]) {
                map.addLayer(layersCache[layerName]);
                console.log("camada sendo usada do cache local");
            } else {
                let isError = 0;
                let totalTilesLoading = 0;
                let totalTilesLoaded = 0;
                const geoServerLayer = new ol.layer.Tile({
                    source: new ol.source.TileWMS({
                        url: "api/proxy-wms", // URL relativa para o proxy no Laravel
                        params: {
                            LAYERS: layerName, // Nome da camada do GeoServer
                            TILED: true,
                            FORMAT: "image/png",
                            TRANSPARENT: true,
                            VERSION: "1.3.0",
                            SRS: "EPSG:3857",
                        },
                        serverType: "geoserver",
                        crossOrigin: "anonymous",
                        tileLoadFunction: function (imageTile, src) {
                            const xhr = new XMLHttpRequest();
                            xhr.open("GET", src, true);
                            xhr.responseType = "blob";

                            xhr.onload = async function () {
                                if (xhr.status === 200) {
                                    const reader = new FileReader();
                                    reader.readAsDataURL(xhr.response);
                                    reader.onload = function () {
                                        imageTile.getImage().src =
                                            reader.result;
                                    };
                                } else {
                                    // Captura erros de tiles defeituosos ou camadas inexistentes

                                    await showError(
                                        `Erro ao carregar tile ${src}. Status: ${xhr.status}`,
                                        geoServerLayer.get("name")
                                    );
                                }
                            };

                            xhr.onerror = async function () {
                                await showError(
                                    `Erro de rede ao carregar tile ${src}.`,
                                    geoServerLayer.get("name")
                                );
                            };

                            xhr.send();
                        },
                        cacheSize: 2048, // Define o tamanho do cache de tiles
                        preload: 4,
                    }),
                    name: layerName,
                });

                map.addLayer(geoServerLayer);
                //console.log("layer adicionado no mapa");
                layersCache[layerName] = geoServerLayer;
                //console.log("layer adicionada no cache local");

                // Adiciona eventos de monitoramento para o carregamento de tiles
                geoServerLayer.getSource().on("tileloadstart", function () {
                    totalTilesLoading++;
                    //   console.log("inciando :", geoServerLayer.get("name"));
                });

                geoServerLayer.getSource().on("tileloadend", function () {
                    totalTilesLoaded++;
                    //   console.log("finalizando", geoServerLayer.get("name"));
                    if (totalTilesLoaded === totalTilesLoading) {
                        //layersCache[layerName] = geoServerLayer;
                        if (!layersCache[layerName])
                            console.log(
                                "camada inserida no cache",
                                geoServerLayer.get("name")
                            );
                    }
                });

                geoServerLayer.getSource().on("tileloaderror", function () {
                    isError++;
                    if (isError === 1) {
                        map.removeLayer(geoServerLayer);
                        delete layersCache[geoServerLayer.get("name")];
                        // console.log(
                        //     "layer removida do cache",
                        //     geoServerLayer.get("name")
                        // );
                        showError(
                            `A camada ${layerName} possui erros e não será carregada.`,
                            geoServerLayer.get("name")
                        );
                    }
                });
            }
        } catch (error) {
            //console.error(`Erro ao carregar a camada ${layerName}:`, error);
            alert(
                `Erro ao carregar a camada ${layerName}. Verifique no GeoServer.`
            );
        }
    }

    // Função para remover uma camada WMS do mapa
    async function removeWmsLayer(map, layerName) {
        const layers = map.getLayers().getArray();
        const layerToRemove = layers.find(
            (layer) => layer.get("name") === layerName
        );
        if (layerToRemove) {
            map.removeLayer(layerToRemove);
        }
    }

    // Função para manipular camadas do mapa de fora do arquivo
    function toggleLayer(map, layerName, shouldAdd) {
        // Verifica se a camada já está presente no mapa
        // const existingLayer = map
        //    .getLayers()
        //     .getArray()
        //    .find((layer) => layer.get("name") === layerName);
        if (shouldAdd) {
            //if (existingLayer) {
            // Se a camada já está no mapa, não faz nada
            //   console.log(`A camada ${layerName} já está no mapa.`);
            //   return;
            // }
            // Se a camada não existe, chama a função para adicioná-la
            addWmsLayer(map, layerName);
        } else {
            // Remove a camada se ela estiver presente
            removeWmsLayer(map, layerName);
        }


    }
    

    // Exporta as funções para serem acessadas no `app.js`
    window.mapModule = {
        initializeMap,
        toggleLayer,
        loadSobralBoundary,
    };
})();

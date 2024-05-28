// URL do serviço WMS
var wmsUrl = 'http://geoserver.sobral.ce.gov.br/geoserver/ows';

// Solicitação GetCapabilities ao serviço WMS
var getCapabilitiesUrl = wmsUrl + '?service=WMS&version=1.3.0&request=GetCapabilities';

fetch(getCapabilitiesUrl)
    .then(response => response.text())
    .then(text => {
        var parser = new DOMParser();
        var xmlDoc = parser.parseFromString(text, 'application/xml');
        var layers = xmlDoc.getElementsByTagName('Layer');

        for (var i = 0; i < layers.length; i++) {
            var layerName = layers[i].getElementsByTagName('Name')[0].textContent;
            var boundingBox = layers[i].getElementsByTagName('EX_GeographicBoundingBox')[0];

            if (boundingBox) {
                var westBoundLongitude = boundingBox.getElementsByTagName('westBoundLongitude')[0].textContent;
                var eastBoundLongitude = boundingBox.getElementsByTagName('eastBoundLongitude')[0].textContent;
                var southBoundLatitude = boundingBox.getElementsByTagName('southBoundLatitude')[0].textContent;
                var northBoundLatitude = boundingBox.getElementsByTagName('northBoundLatitude')[0].textContent;

                console.log('Camada:', layerName);
                console.log('Bounding Box:', westBoundLongitude, southBoundLatitude, eastBoundLongitude, northBoundLatitude);
            }
        }
    })
    .catch(error => console.error('Erro ao buscar as coordenadas:', error));

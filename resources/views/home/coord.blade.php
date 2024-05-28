<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processar XML de Capabilities</title>
</head>
<body>
    <h1>Informações das Camadas</h1>
    <div id="output"></div>
    <script>
        // Função para processar o documento XML
        function processXML(xmlDoc) {
            var layers = xmlDoc.getElementsByTagName('Layer');
            var outputDiv = document.getElementById('output');

            for (var i = 0; i < layers.length; i++) {
                var layerName = layers[i].getElementsByTagName('Name')[0]?.textContent || 'N/A';
                var layerTitle = layers[i].getElementsByTagName('Title')[0]?.textContent || 'N/A';
                var layerAbstract = layers[i].getElementsByTagName('Abstract')[0]?.textContent || 'N/A';
                var crsElements = layers[i].getElementsByTagName('CRS');
                var crsList = Array.from(crsElements).map(crs => crs.textContent).join(', ') || 'N/A';

                var boundingBox = layers[i].getElementsByTagName('EX_GeographicBoundingBox')[0];
                var boundingBoxInfo = 'N/A';
                if (boundingBox) {
                    var westBoundLongitude = boundingBox.getElementsByTagName('westBoundLongitude')[0]?.textContent || 'N/A';
                    var eastBoundLongitude = boundingBox.getElementsByTagName('eastBoundLongitude')[0]?.textContent || 'N/A';
                    var southBoundLatitude = boundingBox.getElementsByTagName('southBoundLatitude')[0]?.textContent || 'N/A';
                    var northBoundLatitude = boundingBox.getElementsByTagName('northBoundLatitude')[0]?.textContent || 'N/A';

                    boundingBoxInfo = `${westBoundLongitude}, ${southBoundLatitude}, ${eastBoundLongitude}, ${northBoundLatitude}`;
                }

                var layerInfo = `
                    <h2>Camada: ${layerName}</h2>
                    <p><strong>Title:</strong> ${layerTitle}</p>
                    <p><strong>Abstract:</strong> ${layerAbstract}</p>
                    <p><strong>CRS:</strong> ${crsList}</p>
                    <p><strong>Bounding Box:</strong> ${boundingBoxInfo}</p>
                `;
                outputDiv.innerHTML += layerInfo;
            }
        }

        // Carregar o arquivo XML localmente e processá-lo
        function loadXMLFile(file) {
            var reader = new FileReader();
            reader.onload = function(event) {
                var parser = new DOMParser();
                var xmlDoc = parser.parseFromString(event.target.result, 'application/xml');
                processXML(xmlDoc);
            };
            reader.readAsText(file);
        }

        // Selecionar arquivo XML
        document.body.onload = function() {
            var input = document.createElement('input');
            input.type = 'file';
            input.accept = '.xml';
            input.onchange = function(event) {
                var file = event.target.files[0];
                if (file) {
                    loadXMLFile(file);
                }
            };
            document.body.appendChild(input);
        };
    </script>
</body>
</html>

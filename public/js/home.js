const cityBounds = [
    [-3.729030, -40.344194],
  // Repetindo a primeira coordenada para fechar o polígono
    [-3.723116, -40.344543], // Novo ponto
    [-3.707870, -40.319138],
    [-3.702731, -40.311928],
    [-3.693994, -40.315876],
    [-3.684230, -40.311584],
    [-3.661446, -40.332355],
    [-3.641745, -40.350380],
    [-3.638147, -40.350380], // Novo ponto
    [-3.639004, -40.355015],
    [-3.659904, -40.393982],
    [-3.701018, -40.369606], // Novo ponto
    [-3.721231, -40.330639],   
    [-3.729030, -40.344194],         
];
let config = {
minZoom: 1,
maxZoom: 20,
};
// magnification with which the map will start
const zoom = 14;
// co-ordinates
const lat = -3.68274;
const lng = -40.3512;


    // calling map
const map = L.map("map", config).setView([lat, lng], zoom);

L.tileLayer('https://services.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer/tile/{z}/{y}/{x}.jpg', {
    attribution: 'Topographic map from ESRI'
}).addTo(map);

const cityPolygon = L.polygon(cityBounds, {
    color: 'blue',
    dashArray: '5, 10', // Define a linha como pontilhada (5 pixels de linha, 10 pixels de espaço)
    fill: false 
}).addTo(map);
// obtaining coordinates after clicking on the map
map.on("click", function (e) {
const markerPlace = document.querySelector(".marker-position");
markerPlace.textContent = e.latlng;
});

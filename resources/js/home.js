/* eslint-disable no-undef */
/**
 * Simple map
 */

// config map
    let config = {
        minZoom: 1,
        maxZoom: 20,
    };
    // magnification with which the map will start
    const zoom = 15;
    // co-ordinates
    const lat = -3.68274;
    const lng = -40.3512;
    
    
      // calling map
    const map = L.map("map", config).setView([lat, lng], zoom);
    // Adicionando camadas base ao controle de layers
    var baseLayers = {
        "OpenStreet:Default": L.tileLayer("http://tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: 'Basic map from the OpenStreetMap project'
        }),
        "OpenStreet:watercolor": L.tileLayer("http://a.tile.stamen.com/watercolor/{z}/{x}/{y}.jpg", {
            attribution: 'Intresting map from Stamen'
        }),
        "NASA:via-maptiler": L.tileLayer("https://tileserver.maptiler.com/nasa/{z}/{x}/{y}.jpg", {
            attribution: 'Beutiful satillite images - but only to zoom level 4'
        }),
        "maps-for-free": L.tileLayer("https://maps-for-free.com/layer/relief/z{z}/row{y}/{z}_{x}-{y}.jpg", {
            attribution: 'Physical World map'
        }),
        "Carto:lightNolabels": L.tileLayer("https://cartodb-basemaps-b.global.ssl.fastly.net/light_nolabels/{z}/{x}/{y}.png", {
            attribution: 'Simple grey &amp; white'
        }),
        "OrdanceSurvey:UK": L.tileLayer("http://os.openstreetmap.org/sv/{z}/{x}/{y}.png", {
            attribution: 'Topo maps of Great Britian'
        }),
        "open:railwaymap": L.tileLayer("http://c.tiles.openrailwaymap.org/standard/{z}/{x}/{y}.png", {
            attribution: 'Railways you can overlay on other base layers'
        }),
        "WayMarkedTrail": L.tileLayer("http://tile.waymarkedtrails.org/hiking/{z}/{x}/{y}.png", {
            attribution: 'Hiking trail you can overlay on other base layers'
        }),
        "OSM Admin Boundaries": L.tileLayer("http://korona.geog.uni-heidelberg.de/tiles/adminb/x={x}&amp;y={y}&amp;z={z}", {
            attribution: 'Political boundries you can overlay on other maps'
        }),
        "NYPL - classic world": L.tileLayer("http://maps.nypl.org/warper/maps/tile/12602/{z}/{x}/{y}.png", {
            attribution: 'Historic map: "A new and correct SEA CHART of the WHOLE WORLD" 1702'
        }),
        "OpenStreet:hikeBike": L.tileLayer("http://a.tiles.wmflabs.org/hikebike/{z}/{x}/{y}.png", {
            attribution: 'From Open Street Map Hiking/biking trails'
        }),
        "USGS:Imagery": L.tileLayer("https://basemap.nationalmap.gov/arcgis/rest/services/USGSImageryOnly/MapServer/tile/{z}/{y}/{x}", {
            attribution: 'Satellite images from the USGS'
        }),
        "Esri:Topo": L.tileLayer("https://services.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer/tile/{z}/{y}/{x}.jpg", {
            attribution: 'Topographic map from ESRI'
        }),
        "ArcGIS Streets": L.tileLayer("http://services.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}", {
            attribution: 'Street map from ArcGIS'
        }),
        "NASA CityLight": L.tileLayer("http://map1.vis.earthdata.nasa.gov/wmts-webmerc/VIIRS_CityLights_2012/default//GoogleMapsCompatible_Level8/{z}/{y}/{x}.jpg", {
            attribution: 'Earth at night Zoom level 0-8'
        }),
        "NatGeo": L.tileLayer("http://services.arcgisonline.com/ArcGIS/rest/services/NatGeo_World_Map/MapServer/tile/{z}/{y}/{x}", {
            attribution: 'Map in the style of National Geographic'
        }),
        "Transport": L.tileLayer("http://www.openptmap.org/tiles/{z}/{x}/{y}.png", {
            attribution: 'Trains, buses and more over layer'
        }),
        "ESRI Satellite": L.tileLayer("https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}.jpg", {
            attribution: 'Satellite images from NASA via ESRI'
        }),
        "OSM no labels": L.tileLayer("https://tiles.wmflabs.org/osm-no-labels/{z}/{x}/{y}.png", {
            attribution: 'Simple map with no labels from Open Street Maps'
        }),
        "OpenTopo": L.tileLayer("http://a.tile.opentopomap.org/{z}/{x}/{y}.png", {
            attribution: 'Topographic map - open source project'
        }),
        "USGS:Topo": L.tileLayer("https://basemap.nationalmap.gov/arcgis/rest/services/USGSTopo/MapServer/tile/{z}/{y}/{x}", {
            attribution: 'Topograpic maps from the US Geological Survey. Limited detail outside the US'
        }),
    };
      
      // Used to load and display tile layers on the map
      // Most tile servers require attribution, which you can set under `Layer`
    //   L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
    //     attribution:
    //       '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    //   }).addTo(map);
    
    // Adicionando controle de layers ao mapa
    L.control.layers(baseLayers).addTo(map);
    L.marker([lat, lng]).addTo(map).bindPopup("Center Warsaw");
    
    map.on("click", function (e) {
    const markerPlace = document.querySelector(".marker-position");
    markerPlace.textContent = e.latlng;
    });
    
    // ------------------------------------------
    // data for context menu
    const contextmenuItems = [
        {
          text: "🗺 Show coordinates",
          callback: showCoordinates,
        },
        {
          text: "🚀 Fly Me To The Moon",
          callback: centerMap,
        },
        {
          text: "🏠 Back to home",
          callback: backToHome,
        },
        {
          text: "Zoom in",
          callback: zoomIn,
        },
        {
          text: "Zoom out",
          callback: zoomOut,
        },
      ];
      
      // global variable to store the coordinates
      let latlngObj = {
        lat: 0,
        lng: 0,
      };
      
      // callbacks function
      function showCoordinates(e) {
        console.log(latlngObj);
        const coordinatesLabel = document.querySelector(".coordinates-label");
        coordinatesLabel.style.display = "block";
        coordinatesLabel.innerText = `Lat: ${latlngObj.lat} Lng: ${latlngObj.lng}`;
        hideMenu();
      }
      
      function centerMap(e) {
        map.flyTo([moonCord.lat, moonCord.lng], 17, { animate: true, duration: 10 });
      
        map.on("moveend", function () {
          marker.openPopup();
          showCoordinatesLabel.innerHTML =
            "<a href='https://en.wikipedia.org/wiki/Statue_of_Frank_Sinatra' target='_blank'>Open wiki: Statue of Frank Sinatra</a>";
        });
      
        hideMenu();
      }
      
      function backToHome() {
        map.flyTo([lat, lng], zoom);
        marker.closePopup();
        removeTextFromLabel();
        hideMenu();
      }
      
      function zoomIn() {
        map.zoomIn();
        hideMenu();
      }
      
      function zoomOut() {
        map.zoomOut();
        hideMenu();
      }
      
      // hide context menu
      function hideMenu() {
        const ul = document.querySelector(".context-menu");
        ul.removeAttribute("style");
        ul.classList.remove("is-open");
      }
      
      // create context menu
      function createMenu() {
        const menu = document.createElement("ul");
        menu.classList.add("context-menu");
        menu.setAttribute("data-contextmenu", "0");
        contextmenuItems.forEach((item) => {
          const li = document.createElement("li");
          li.innerText = item.text;
          li.addEventListener("click", item.callback);
          menu.appendChild(li);
        });
      
        return menu;
      }
      
      // append context menu to the body
      document.body.appendChild(createMenu());
      
      // coordinate label
      const showCoordinatesLabel = document.createElement("p");
      showCoordinatesLabel.classList.add("coordinates-label");
      removeTextFromLabel();
      
      document.body.appendChild(showCoordinatesLabel);
      
      function removeTextFromLabel() {
        showCoordinatesLabel.textContent = "right click on the map";
      }
      
      // Add context menu to the map
      var menu = document.querySelector("#map");
      document.addEventListener("contextmenu", function (e) {
        e.preventDefault();
      
        // show context menu
        show(e);
      });
      
      function show(e) {
        const ul = document.querySelector("ul");
        ul.style.display = "block";
        ul.style.left = `${e.pageX}px`;
        ul.style.top = `${e.pageY}px`;
        ul.classList.add("is-open");
      
        ul.focus();
      
        const point = L.point(e.pageX, e.pageY);
        const coordinates = map.containerPointToLatLng(point);
      
        latlngObj = { ...latlngObj, ...coordinates };
      
        e.preventDefault();
      }
      
      // ------------------------------------------
      
      window.addEventListener("DOMContentLoaded", function () {
        document.addEventListener("wheel", hideMenu);
      
        ["zoomstart", "resize", "click", "move"].forEach((eventType) => {
          map.on(eventType, hideMenu);
        });
      });

      document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.layer-category input[type="checkbox"]');
    
        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('click', function() {
                if (checkbox.checked) {
                    console.log('Checkbox marcada:', checkbox.id);
                    // Aqui você pode adicionar a lógica para mostrar a camada correspondente no mapa
                } else {
                    console.log('Checkbox desmarcada:', checkbox.id);
                    // Aqui você pode adicionar a lógica para ocultar a camada correspondente no mapa
                }
            });
        });
      
    });




    

    
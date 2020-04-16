/*
      usare inserendo 
      <map-app :location-start="locationStart" :location-stop="locationStop"></map-app>
*/

Vue.component("map-app", {
      template: `<div id="map" class="map"></div>`,
      props: ['locationStart', 'locationStop'],
      data: function () {
            return {
                  map: null,
                  tileLayer: null,
                  layers: [{
                        id: 0,
                        name: 'Position',
                        active: true,
                        features: [],
                  }, ],
            }
      },
      mounted() {
            this.initMap();
            this.initLayers();
      },
      methods: {
            initMap() {
                  let start = this.locationStart != null ? this.locationStart.split(',').map(Number) : [0, 0];
                  let stop = this.locationStop != null ? this.locationStop.split(',').map(Number) : [0, 0];
                  if (this.locationStart != null) {
                        this.layers[0].features.push({
                              id: 0,
                              name: 'start',
                              type: 'marker',
                              coords: start,
                        });
                  }
                  if (this.locationStop != null) {
                        this.layers[0].features.push({
                              id: 0,
                              name: 'start',
                              type: 'marker',
                              coords: stop,
                        });
                  }

                  this.map = L.map('map').setView(start, 12);
                  this.tileLayer = L.tileLayer(
                        'https://cartodb-basemaps-{s}.global.ssl.fastly.net/rastertiles/voyager/{z}/{x}/{y}.png', {
                              maxZoom: 18,
                              attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>, &copy; <a href="https://carto.com/attribution">CARTO</a>',
                        }
                  );
                  this.tileLayer.addTo(this.map);
            },
            initLayers() {

                  this.layers.forEach((layer) => {
                        const markerFeatures = layer.features.filter(feature => feature.type === 'marker');
                        markerFeatures.forEach((feature) => {
                              feature.leafletObject = L.marker(feature.coords)
                                    .bindPopup(feature.name);
                                    feature.leafletObject.addTo(this.map);
                        });
                  })
            },
      },
})
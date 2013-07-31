(function () {
  "use strict";
  window.app.views.MapView = Backbone.View.extend({
    events: {
      // Currently disabled until we have the editing mode
      // 'click': 'onMapClick'
    },


    initialize: function() {
      _.bindAll(this, 'initMap', 'onMapClick', 'addPoint', 'renderPoints');

      this.listenTo(this.model, 'change:points', this.renderPoints);
    },

    render: function() {
      _.defer(this.initMap);
      return this;
    },

    initMap: function() {
      var mapCenter = new L.LatLng(this.model.get('latitude'), this.model.get('longitude'));
      this.map = L.mapbox.map(this.el, app.config.mapboxKey);
      this.map.setView(mapCenter, parseInt(this.model.get('zoom'), 10));

      this.renderPoints();
    },

    renderPoints: function() {
      this.model.comments.forEach(this.addPoint);
    },

    addPoint: function(point) {
      var latlng = new L.LatLng(point.get('latitude'), point.get('longitude'));
      var circle = L.circle(latlng, 5, {
        color: '#fff',
        weight: 2,
        fillColor: '#79cb59',
        fillOpacity: 0.9
      });

      circle.addTo(this.map);
    },

    onMapClick: function(evt) {
      var latlng = this.map.mouseEventToLatLng(evt);

      var myIcon = L.icon({
          iconUrl: '/bundles/nzzmytown/images/marker.png',
          iconSize: [25, 41],
          iconAnchor: [22, 30],
          popupAnchor: [-3, -20],
          shadowSize: [68, 95],
          shadowAnchor: [22, 94]
      });

      var marker = new L.marker(latlng, {
        icon: myIcon,
        riseOnHover: true
      });

      marker.addTo(this.map);
    }
  });
}());

(function () {
  "use strict";

  // rounds coordinates before setting to state model
  // https://en.wikipedia.org/wiki/Wikipedia:WikiProject_Geographical_coordinates#Precision_guidelines
  // 0.0001° = 5 - 10m accuracy
  // should be enough and makes urls shorter
  function coordsRound(n) {
    return Math.round(n * 10000) / 10000;
  }

  function colorCircle(sentiment) {
    switch (parseInt(sentiment, 10)) {
      case 0:
        return "#bec7d3";
      case 1:
        return "#79cb59";
      default:
        return "#bf292a";
    }
  }

  window.app.views.MapView = Backbone.View.extend({
    events: {
      // Currently disabled until we have the editing mode
      // 'click': 'onMapClick',
      'mouseover .leaflet-clickable': 'onHover'
    },


    initialize: function() {
      _.bindAll(this, 'initMap', 'onHover', 'onMapClick', 'addPoint', 'renderPoints');

      this.listenTo(this.model, 'change:points', this.renderPoints);
    },

    render: function() {
      _.defer(this.initMap);
      return this;
    },

    initMap: function() {
      var state = this.model.state,
          mapCenter = new L.LatLng(state.get('lat'), state.get('lng'));
      this.map = L.mapbox.map(this.el, app.config.mapboxKey);
      this.map.setView(mapCenter, parseInt(state.get('zoom'), 10));

      // debounced
      var saveState = _.debounce(function() {
        var coords = this.map.getCenter();
        this.model.state.set({
          'lat': coordsRound(coords.lat),
          'lng': coordsRound(coords.lng),
          'zoom': this.map.getZoom()
        });
      }.bind(this), 500);

      this.map.on('moveend', saveState);
      this.map.on('zoomend', saveState);

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
        fillColor: colorCircle(point.get('sentiment')),
        fillOpacity: 0.9
      });

      circle.addTo(this.map);
    },

    onHover: function(evt) {
      // TODO
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

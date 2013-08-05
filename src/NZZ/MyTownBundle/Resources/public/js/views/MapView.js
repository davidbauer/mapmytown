(function () {
  "use strict";
  window.app.views.MapView = Backbone.View.extend({
    events: {
      // Currently disabled until we have the editing mode
      'click': 'onSetCommentMarker',
      'mouseover .leaflet-clickable': 'onHover'
    },


    initialize: function() {
      _.bindAll(this, 'initMap', 'onHover', 'onSetCommentMarker', 'addPoint', 'renderPoints', 'updateComment', 'updateCommentMarkerPosition');

      this.listenTo(this.model, 'change:points', this.renderPoints);
      this.listenTo(this.model.comments, 'add', this.updateComment);
      this.listenTo(this.model.comments, 'remove', this.updateComment);
      this.listenTo(this.model.comments, 'reset', this.updateComment);
    },

    render: function() {
      _.defer(this.initMap);
      return this;
    },

    initMap: function() {
      var mapCenter = new L.LatLng(this.model.get('centerlatitude'), this.model.get('centerlongitude'));
      this.map = L.mapbox.map(this.el, app.config.mapboxKey);
      this.map.setView(mapCenter, parseInt(this.model.get('defaultzoom'), 10));
      this.renderPoints();
    },

    renderPoints: function() {
      this.model.comments.forEach(this.addPoint);
    },

    addPoint: function(point) {
      function colorCircle(sentiment) {
        switch (parseInt(sentiment, 10)) {
          case 0:
            return "#bec7d3";
            break;
          case 1:
            return "#79cb59";
            break;
          default:
            return "#bf292a";
            break;
        };
      };
      
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

    onSetCommentMarker: function(evt) {
      if (!this.model.comments.findNew()) return;

      var latlng = this.map.mouseEventToLatLng(evt);

      var myIcon = L.icon({
          iconUrl: '/bundles/nzzmytown/images/marker.png',
          iconSize: [23, 38],
          iconAnchor: [12, 38]
      });

      if (!this.marker) {
        this.marker = new L.marker(latlng, {
          icon: myIcon,
          riseOnHover: true,
          draggable: true
        })
        .on('move', this.updateCommentMarkerPosition)

        this.marker.addTo(this.map);
      } else {
        this.marker.setLatLng(latlng);
      }

      this.updateCommentMarkerPosition(latlng);
    },

    updateCommentMarkerPosition: function(latlng) {
      latlng.latlng && (latlng = latlng.latlng);
      var comment = this.model.comments.findNew();
      if (comment) {
        comment.set({latlng: latlng});
      }
    },

    updateComment: function() {
      var comment = this.model.comments.findNew();
      if (this.marker && !comment) {
        this.marker.off('move');
        this.map.removeLayer(this.marker);
        this.marker = null;
      }
    }
  });
}());

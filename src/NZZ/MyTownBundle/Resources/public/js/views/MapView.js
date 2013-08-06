(function () {
  "use strict";

  // Utils
  function pointerEventCoordinates(evt) {
    var isTouch = evt.type.indexOf('touch') === 0;
    if (isTouch) {
      return {
        x: evt.changedTouches[0].pageX,
        y: evt.changedTouches[0].pageY
      }
    } else {
      return {
        x: evt.clientX + window.pageXOffset,
        y: evt.clientY + window.pageYOffset
      }
    }
  }

  function pointerMoved(start, end) {
    if (!start || !end) return false;
    return Math.abs(start.x - end.x) > 5 || Math.abs(start.y - end.y) > 5;
  }

  function colorForSentiment(sentiment) {
    switch (parseInt(sentiment, 10)) {
      case -1:
        return "#bf292a";
        break;
      case 1:
        return "#79cb59";
        break;
      default:
        return "#bec7d3";
        break;
    };
  };

  function makePersistedMarker(comment, latlng) {
    return new L.CircleMarker(latlng, {
      stroke: true,
      color: '#fff',
      opacity: 1,
      weight: 2,
      fill: true,
      fillColor: colorForSentiment(comment.get('sentiment')),
      fillOpacity: 1,
      clickable: true
    }).setRadius(6);
  }

  function makePlaceableMarker(comment, latlng) {
    var icon = L.icon({
        iconUrl: '/bundles/nzzmytown/images/marker.png',
        iconSize: [23, 38],
        iconAnchor: [12, 38]
    });

    return new L.Marker(latlng, {
      icon: icon,
      riseOnHover: true,
      draggable: true
    });
  }


  // Class definition
  window.app.views.MapView = Backbone.View.extend({
    events: {
      'mousedown':  'onStartPlaceMarker',
      'mouseup':    'onEndPlaceMarker',
      'touchstart': 'onStartPlaceMarker',
      'touchend':   'onEndPlaceMarker'
    },

    initialize: function() {
      _.bindAll(this, 'initMap', 'onStartPlaceMarker', 'onEndPlaceMarker', 'addMarkerForComment', 'updateMarkerForComment', 'removeMarkerForComment');

      // Keep track of all placed markers
      this.markers = {};

      // Bind event listeners
      this.listenTo(this.model.comments, 'add',    this.addMarkerForComment);
      this.listenTo(this.model.comments, 'remove', this.removeMarkerForComment);
      this.listenTo(this.model.comments, 'change:persisted', this.updateMarkerForComment);
      this.listenTo(this.model.comments, 'change:latitude',  this.updateMarkerForComment);
      this.listenTo(this.model.comments, 'change:longitude', this.updateMarkerForComment);
    },

    render: function() {
      _.defer(this.initMap);
      return this;
    },

    initMap: function() {
      var mapCenter = this.model.getLatLng();
      this.map = L.mapbox.map(this.el, app.config.mapboxKey);
      this.map.setView(mapCenter, parseInt(this.model.get('defaultzoom'), 10));

      // Add initial markers
      this.model.comments.forEach(this.addMarkerForComment);
    },

    onStartPlaceMarker: function(evt) {
      this._pointerEventStart = pointerEventCoordinates(evt.originalEvent);
    },

    onEndPlaceMarker: function(evt) {
      var comment = this.model.comments.findNew();
      var pointerEnd = pointerEventCoordinates(evt.originalEvent);

      if (comment && !pointerMoved(this._pointerEventStart, pointerEnd)) {
        // Using a Point instead of mouseEventToLatLng because the latter
        // doesn't work with touch events
        var offset = $(this.map.getContainer()).offset();
        var point = new L.Point(pointerEnd.x - offset.left, pointerEnd.y - offset.top);
        var latlng = this.map.containerPointToLatLng(point);
        comment.setLatLng(latlng);
      }
    },

    addMarkerForComment: function(comment) {
      // If a marker already exists, remove it before adding it again
      if (this.markers[comment.cid]) {
        this.removeMarkerForComment(comment);
      }

      var latlng = comment.getLatLng() || this.map.getCenter();
      var comments = this.model.comments;
      var marker;

      if (comment.isPersisted()) {
        marker = makePersistedMarker(comment, latlng);
        marker.on('click', function(evt) {
          comments.selectComment(comment);
          marker.bringToFront();
        });
      } else {
        marker = makePlaceableMarker(comment, latlng);
        marker.on('move', function(evt) {
          comment.setLatLng(evt.latlng);
        });
      }

      comment.setLatLng(latlng);

      marker.addTo(this.map);
      this.markers[comment.cid] = {
        el: marker,
        persisted: comment.isPersisted()
      };
    },

    updateMarkerForComment: function(comment) {
      var marker = this.markers[comment.cid];
      if (!marker) return;

      if (marker.persisted == comment.isPersisted()) {
        marker.el.setLatLng(comment.getLatLng());
      } else {
        this.removeMarkerForComment(comment);
        this.addMarkerForComment(comment);
      }
    },

    removeMarkerForComment: function(comment) {
      var marker = this.markers[comment.cid];
      this.map.removeLayer(marker.el);
      marker.el.off('click');
      marker.el.off('move');
      delete this.markers[comment.id];
    }
  });
}());

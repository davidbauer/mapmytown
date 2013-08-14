(function () {
  "use strict";

  // Utils

  // rounds coordinates before setting to state model
  // https://en.wikipedia.org/wiki/Wikipedia:WikiProject_Geographical_coordinates#Precision_guidelines
  // 0.0001° = 5 - 10m accuracy
  // should be enough and makes urls shorter
  function coordsRound(n) {
    return Math.round(n * 10000) / 10000;
  }

  function pointerEventCoordinates(evt) {
    var isTouch = evt.type.indexOf('touch') === 0;
    if (isTouch) {
      return {
        x: evt.changedTouches[0].pageX,
        y: evt.changedTouches[0].pageY
      };
    } else {
      return {
        x: evt.clientX + window.pageXOffset,
        y: evt.clientY + window.pageYOffset
      };
    }
  }

  function pointerMoved(start, end) {
    if (!start || !end) return false;
    return Math.abs(start.x - end.x) > 5 || Math.abs(start.y - end.y) > 5;
  }

  function colorForSentiment(sentiment) {
    switch (parseInt(sentiment, 10)) {
      case -1:
        return "#f3182c";
      case 1:
        return "#3dbd05";
      default:
        return "#4299ff";
    }
  }

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
    }).setRadius(comment.get('selected') ? 8 : 6);
  }

  function makePlaceableMarker(comment, latlng) {
    var icon = L.icon({
        iconUrl: '/bundles/nzzmytown/images/marker-icon-red.png',
        iconSize: [25, 41],
        iconAnchor: [13, 43]
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
      _.bindAll(this, 'initMap', 'onStartPlaceMarker', 'onEndPlaceMarker', 'addMarkerForComment', 'updateMarkerForComment', 'selectMarkerForComment', 'removeMarkerForComment');

      // Keep track of all placed markers
      this.markers = {};

      // Bind event listeners
      this.listenTo(this.model.comments, 'add',    this.addMarkerForComment);
      this.listenTo(this.model.comments, 'remove', this.removeMarkerForComment);
      this.listenTo(this.model.comments, 'change:persisted', this.updateMarkerForComment);
      this.listenTo(this.model.comments, 'change:latitude',  this.updateMarkerForComment);
      this.listenTo(this.model.comments, 'change:longitude', this.updateMarkerForComment);
      this.listenTo(this.model.comments, 'change:selected', this.selectMarkerForComment);
    },

    render: function() {
      _.defer(this.initMap);
      return this;
    },

    initMap: function() {
      var state = this.model.state,
          mapCenter = new L.LatLng(state.get('lat'), state.get('lng'));
      this.map = L.mapbox.map(this.el, app.config.mapboxKey, {
        attributionControl: false,
        zoomControl: false
      });
      this.map.setView(mapCenter, (parseInt(state.get('zoom'), 10) || 12)); // if zoom param is not int fallback to 12

      // Add zoom control
      this.map.addControl(new L.Control.Zoom({
        position: 'topright'
      }));

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

      // Filter the comment list
      var refreshState = _.debounce(function() {
        this.updateVisibleComments();
      }.bind(this), 50);
      this.map.on('moveend', refreshState);
      this.map.on('zoomend', refreshState);
      this.updateVisibleComments();

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
        selected: comment.get('selected'),
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

    selectMarkerForComment: function(comment) {
      var marker = this.markers[comment.cid];
      if (!marker || !marker.persisted) return;
      marker.el.setRadius(comment.get('selected') ? 8 : 6);

      if (comment.get('selected')) {
        var defaultZoom = this.model.get('defaultzoom'),
            commentLatLng = comment.getLatLng();
        if(this.map.getZoom() < defaultZoom || !this.map.getBounds().contains(commentLatLng)) {
          this.map.setZoom(defaultZoom, {animate: true});
        }
        this.map.panTo(commentLatLng, {
          animate: true,
          duration: 0.3
        });
      }
    },

    removeMarkerForComment: function(comment) {
      var marker = this.markers[comment.cid];
      this.map.removeLayer(marker.el);
      marker.el.off('click');
      marker.el.off('move');
      delete this.markers[comment.id];
    },

    updateVisibleComments: function() {
      var bounds = this.map.getBounds();
      this.model.comments.each(function(comment) {
      	if (bounds.contains(comment.getLatLng()) || comment.get('selected')) {
          comment.set('visible', true);
      	} else {
          comment.set('visible', false);
      	}
      });
    }
  });
}());

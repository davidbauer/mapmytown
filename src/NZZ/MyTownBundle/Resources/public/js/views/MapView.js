(function () {
  "use strict";
  window.app.views.MapView = Backbone.View.extend({
    template: 'map-view',

    events: {
      // Currently disabled until we have the editing mode
      // 'click': 'onMapClick'
    },

    initialize: function() {
      _.bindAll(this, 'onMapClick');
    },

    render: function() {
      // var template = this.compileTemplate(this.template);
      // this.$el.html(template());

      _.defer(_.bind(function(){
        this.map = L.mapbox.map(this.el, app.config.mapboxKey);
        this.map.setView(new L.LatLng(app.config.lat, app.config.lon), parseInt(app.config.zoom, 10));
      }, this));

      return this;
    },

    onMapClick: function(evt) {
      var latlng = this.map.mouseEventToLatLng(evt);

      var myIcon = L.icon({
          iconUrl: '/bundles/nzzmytown/images/nzz.png',
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

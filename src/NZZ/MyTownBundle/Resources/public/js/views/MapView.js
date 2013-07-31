(function () {
  "use strict";
  window.app.views.MapView = Backbone.View.extend({
    template: 'map-view',

    events: {
      'click': 'onMapClick'
    },

    initialize: function() {
      _.bindAll(this, 'onMapClick');
    },

    render: function() {
      // var template = this.compileTemplate(this.template);
      // this.$el.html(template());

      this.$el.css({height: "100%"});
      this.map = L.mapbox.map(this.el, app.config.mapboxKey);
      this.map.setView(new L.LatLng(app.config.lat, app.config.lon), parseInt(app.config.zoom, 10));

      return this;
    },

    onMapClick: function(evt) {
      // var w, s = document.createElement('div'),
      //     c = evt.latlng;
      // var myIcon = L.icon({
      //     iconUrl: '/bundles/nzzmytown/images/' + app.config.project +'.png',
      //     iconSize: [25, 41],
      //     iconAnchor: [22, 30],
      //     popupAnchor: [-3, -20],
      //     shadowSize: [68, 95],
      //     shadowAnchor: [22, 94]
      // });

      // var marker = new L.marker(evt.latlng, {riseOnHover: true, icon: myIcon});

      // // $compile(tmpl)($scope, function (clonedElement) {
      // //     $(s).append(clonedElement);
      // //     $scope.marker = marker;
      // //     $scope.latlng = c;
      // //     marker.bindPopup(s);
      // // });

      // marker.addTo(this.map).remove(marker);
    }
  });
}());

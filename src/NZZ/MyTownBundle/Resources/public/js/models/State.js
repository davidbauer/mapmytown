(function () {
  "use strict";

  window.app.models.State = Backbone.Model.extend({
    initialize: function() {},
    defaults: {
      lat: undefined,
      lng: undefined,
      zoom: undefined
    }
  });

}());

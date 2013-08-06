(function () {
  "use strict";
  window.app || (window.app = {
    routers: {},
    collections: {},
    models: {},
    views: {},
    config: {}
  });
  app.routers.AppRouter = Backbone.Router.extend({
    routes: {
      "": "index"
    },

    index: function () {
      var appModel = new app.models.AppModel();
      appModel.fetch().done(function() {
        var currentView = new app.views.RootView({
          model: appModel,
          el: "[data-view='root']"
        });
        currentView.render();
      });
    }
  });
}());

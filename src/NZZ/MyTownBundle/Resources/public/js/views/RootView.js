(function () {
  "use strict";
  window.app.views.RootView = Backbone.View.extend({
    template: "root-view",

    render: function() {
      var template = this.compileTemplate(this.template);
      this.$el.html(template({
        title: "Title"
      }));

      var mapView = new app.views.MapView({
        model: this.model
      });
      this.$('#map').html(mapView.render().el);

      return this;
    }
  });
}());

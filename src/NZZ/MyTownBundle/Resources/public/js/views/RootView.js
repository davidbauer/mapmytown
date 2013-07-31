(function () {
  "use strict";
  window.app.views.RootView = Backbone.View.extend({
    template: "root-view",

    render: function() {
      var template = this.compileTemplate(this.template);
      this.$el.html(template({
        title: "Title"
      }));

      // Map view
      var mapView = new app.views.MapView({
        model: this.model
      });
      this.$('#map').html(mapView.render().el);

      // Comments list
      var commentsList = new app.views.CommentsList({
        collection: this.model.comments
      });
      this.$('[data-view="comments-list"]').html(commentsList.render().el);

      return this;
    }
  });
}());

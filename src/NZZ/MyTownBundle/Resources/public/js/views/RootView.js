(function () {
  "use strict";
  window.app.views.RootView = Backbone.View.extend({
    render : function() {
      this.$el.html("<h1>My Town</h1>");
      return this;
    }
  });
}());

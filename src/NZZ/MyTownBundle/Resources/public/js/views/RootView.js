(function () {
  "use strict";
  window.app.views.RootView = Backbone.View.extend({
    template: "root-view",

    render: function() {
      var template = this.compileTemplate(this.template);
      this.$el.html(template({
        title: "Title"
      }));
      return this;
    }
  });
}());

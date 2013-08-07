(function () {
  "use strict";
  window.app.views.CommentPlaceholder = Backbone.View.extend({
    className: "comment comment--placeholder",
    tagName: "li",
    template: "comment-placeholder",

    render: function() {
      var template = this.compileTemplate(this.template);
      this.$el.html(template());
      return this;
    }
  });
}());

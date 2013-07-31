(function () {
  "use strict";
  window.app.views.CommentsList = Backbone.View.extend({
    className: "comments__list",
    tagName: "ul",
    commentTemplate: "comment",

    initialize: function() {
      _.bindAll(this, 'render', 'appendItem');

      this.listenTo(this.collection, 'add', this.render);
      this.listenTo(this.collection, 'remove', this.render);
      this.listenTo(this.collection, 'reset', this.render);
    },

    render: function() {
      if (this.collection.length > 0) {
        this.$el.empty();
        this.collection.forEach(this.appendItem);
      } else {
        this.$el.html("<li>Keine Einträge</li>"); // FIXME: make localizable
      }
      return this;
    },

    appendItem: function(item) {
      var template = this.compileTemplate(this.commentTemplate);
      this.$el.append(template(item.toJSON()));
    }
  });
}());

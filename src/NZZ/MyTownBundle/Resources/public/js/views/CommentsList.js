(function () {
  "use strict";
  window.app.views.CommentsList = Backbone.View.extend({
    className: "comments__list",
    tagName: "ul",
    commentTemplate: "comment",

    events: {
      'click [data-action="select"]': 'onSelectComment'
    },

    initialize: function() {
      _.bindAll(this, 'render', 'appendItem');

      this.listenTo(this.collection, 'add', this.render);
      this.listenTo(this.collection, 'remove', this.render);
      this.listenTo(this.collection, 'reset', this.render);
      this.listenTo(this.collection, 'change:persisted', this.render);
      this.listenTo(this.collection, 'change:selected', this.render);
    },

    render: function() {
      if (this.collection.length > 0) {
        this.$el.empty();
        this.collection.forEachPersisted(this.appendItem);
      } else {
        this.$el.html("<li>Keine Einträge</li>"); // FIXME: make localizable
      }
      return this;
    },

    appendItem: function(item) {
      var template = this.compileTemplate(this.commentTemplate);
      this.$el.append(template(_.extend({}, item.toJSON(), {
        cid: item.cid
      })));
    },

    onSelectComment: function(evt) {
      var $item = $(evt.currentTarget);
      var cid = $item.data('cid');
      var comment = this.collection.get(cid);
      this.collection.selectComment(comment);
    }
  });
}());

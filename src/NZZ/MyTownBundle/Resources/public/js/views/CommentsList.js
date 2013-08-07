(function () {
  "use strict";
  window.app.views.CommentsList = Backbone.View.extend({
    className: "comments__list",
    tagName: "ul",

    events: {
      'click [data-action="select"]': 'onSelectComment'
    },

    initialize: function() {
      _.bindAll(this, 'render', 'addComment', 'removeComment');

      this.views = {};

      this.listenTo(this.collection, 'add', this.addComment);
      this.listenTo(this.collection, 'remove', this.removeComment);
      this.listenTo(this.collection, 'reset', this.render);
      this.listenTo(this.collection, 'change:selected', this.scrollToSelectedComment);
    },

    render: function() {
      if (this.collection.length > 0) {
        this.$el.empty();
        var comments = this.collection.findPersisted();
        comments.reverse(); // Add oldest first, because we're prepending
        comments.forEach(this.addComment);
      } else {
        this.placeholderView = new app.views.CommentPlaceholder();
        this.$el.html(this.placeholderView.render().el);
      }
      return this;
    },

    addComment: function(comment) {
      if (this.placeholderView) {
        this.placeholderView.remove();
        this.placeholderView = null;
      }

      var commentView = new app.views.Comment({model: comment});
      this.$el.prepend(commentView.render().el);
      this.views[comment.cid] = commentView;
    },

    removeComment: function(comment) {
      var commentView = this.views[comment.cid];
      commentView.remove();
      delete this.views[comment.cid];
    },

    scrollToSelectedComment: function(comment) {
      var commentView = this.views[comment.cid];
      if (comment.get('selected') && commentView) {
        var parent = commentView.$el.offsetParent();
        parent.animate({
          scrollTop: parent.scrollTop() + commentView.$el.offset().top
        }, 300);
      }
    },

    onSelectComment: function(evt) {
      var cid = $(evt.currentTarget).data('cid');
      var comment = this.collection.get(cid);
      this.collection.selectComment(comment);
    }
  });
}());

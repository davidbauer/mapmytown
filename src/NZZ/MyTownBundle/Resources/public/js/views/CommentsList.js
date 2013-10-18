(function () {
  "use strict";
  window.app.views.CommentsList = Backbone.View.extend({
    className: "comments__list",
    tagName: "ul",

    events: {
      'click [data-action="select"]': 'onSelectComment'
    },

    initialize: function() {
      _.bindAll(this, 'render', 'fitInSidebar', 'addComment', 'removeComment');

      this.views = {};

      this.listenTo(Backbone, 'resize', this.fitInSidebar);
      this.listenTo(this.collection, 'add', this.addComment);
      this.listenTo(this.collection, 'remove', this.removeComment);
      this.listenTo(this.collection, 'reset', this.render);

      // We need to update the scroll position if the selection is changed
      // and if the map is moved, in which case other comments will be hidden
      // or shown, which changes the selected comment's position in the list.
      this.listenTo(this.collection, 'change:selected', this.scrollToSelectedComment);
      this.listenTo(this.model.state, 'change', this.scrollToSelectedComment);
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

      _.defer(this.fitInSidebar);

      return this;
    },

    // Position within header and footer
    fitInSidebar: function() {
      var $header = $('#sidebar-header');
      var $footer = $('#sidebar-footer');

      this.$el.css({
        top: $header.outerHeight(),
        bottom: $footer.outerHeight()
      });
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

    scrollToSelectedComment: function() {
      var comment = this.collection.findSelected();
      var commentView = this.views[(comment ? comment.cid : null)];
      if (comment && commentView) {
        var parent = commentView.$el.offsetParent();
        parent.animate({
          queue: false,
          scrollTop: parent.scrollTop() + commentView.$el.position().top
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

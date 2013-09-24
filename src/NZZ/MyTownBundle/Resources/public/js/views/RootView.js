(function () {
  "use strict";
  window.app.views.RootView = Backbone.View.extend({
    template: "root-view",

    events: {
      'click [data-action="tac-modal"]': 'onShowTacModal',
      'click [data-action="embed-modal"]': 'onShowEmbedModal'
    },

    initialize: function() {
      _.bindAll(this, 'render', 'updateSidebar');

      this.listenTo(this.model.comments, 'add', this.updateSidebar);
      this.listenTo(this.model.comments, 'remove', this.updateSidebar);
      this.listenTo(this.model.comments, 'change:persisted', this.updateSidebar);
    },

    render: function() {
      var template = this.compileTemplate(this.template);
      this.$el.html(template(this.model.toJSON()));

      // Map view
      this.mapView = new app.views.MapView({
        model: this.model
      });
      this.$('[data-view="map-view"]').html(this.mapView.render().el);

      // Comments list
      var commentsList = new app.views.CommentsList({
        collection: this.model.comments
      });
      this.$('[data-view="comments-list"]').html(commentsList.render().el);

      // Submit view
      var submitView = new app.views.SubmitView({
        model: this.model
      });
      this.$('[data-view="submit-view"]').html(submitView.render().el);

      return this;
    },

    updateSidebar: function(comment) {
      var newComment = this.model.comments.findNew();
      this.$('.sidebar').toggleClass('sidebar--minimized', newComment);
      // Hackish...
      $('#map').toggleClass('map--full', newComment);
      this.mapView.map.invalidateSize();
    },

    onShowTacModal: function(evt) {
      evt.preventDefault();
      this.$('#tac-modal').modal('show');
    },

    onShowEmbedModal: function(evt) {
      evt.preventDefault();
      var template = this.compileTemplate("embed");
      this.$('[data-bind="embed"]').html(template({
        src: window.location.href,
        height: "700px",
        width: "1000px"
      }));
      this.$('#embed-modal').modal('show');
    }
  });
}());

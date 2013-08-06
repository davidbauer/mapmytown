(function () {
  "use strict";
  window.app.views.Comment = Backbone.View.extend({
    className: "comments__item comment",
    tagName: "li",
    template: "comment",

    attributes: function() {
      return {
        'data-cid': this.model.cid,
        'data-action': 'select'
      }
    },

    initialize: function() {
      _.bindAll(this, 'render');
      this.listenTo(this.model, 'change:persisted', this.render);
      this.listenTo(this.model, 'change:selected', this.render);
    },

    render: function() {
      this.$el.hide();
      if (this.model.isPersisted()) {
        var template = this.compileTemplate(this.template);
        this.$el.html(template(this.model.toJSON()));
        this.$el.toggleClass('selected', this.model.get('selected'));
        this.$el.show();
      }
      return this;
    }
  });
}());

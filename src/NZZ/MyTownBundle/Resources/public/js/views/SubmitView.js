(function () {
  "use strict";
  window.app.views.SubmitView = Backbone.View.extend({

    events: {
      'click [data-action="new"]': 'onCreate',
      'click [data-action="cancel"]': 'onCancel',
    },

    initialize: function() {
      this.listenTo(this.model, 'change:mode', this.render);
    },

    render: function() {
      var templateName;
      switch (this.model.get('mode')) {
        case 'create':
          templateName = 'submit-create'
          break;
        default:
          templateName = 'submit-default'
      }

      var template = this.compileTemplate(templateName);
      this.$el.html(template());

      return this;
    },

    onCreate: function(evt) {
      this.model.set('mode', 'create');
    },

    onCancel: function(evt) {
      this.model.set('mode', 'default');
    }
  });
}());

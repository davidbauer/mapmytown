(function () {
  "use strict";
  window.app.views.SubmitView = Backbone.View.extend({
    template: 'submit',

    events: {
      'click [data-action="new"]': 'onNew',
      'click [data-action="cancel"]': 'onCancel',
      'click [data-action="edit"]': 'onEdit'
    },

    initialize: function() {
      _.bindAll(this, 'render', 'onNew', 'onEdit', 'onCreate', 'onShowDialog', 'onCancel');

      this.listenTo(this.model.comments, 'add', this.render);
      this.listenTo(this.model.comments, 'remove', this.render);
      this.listenTo(this.model.comments, 'reset', this.render);
    },

    render: function() {
      var template = this.compileTemplate(this.template);
      var options = this.model.toJSON();
      var comment = this.model.comments.findNew();
      if (comment) options.comment = comment.toJSON();
      this.$el.html(template(options));

      return this;
    },

    onNew: function(evt) {
      var comment = new app.models.Comment();
      this.model.comments.add(comment);
      comment.on('change:latlng', this.render, this);
    },

    onEdit: function(evt) {
      var comment = this.model.comments.findNew();

      if (comment.get('latlng')) {
        var dialogId = $(evt.currentTarget).data('target');
        this.onShowDialog(dialogId);
      } else {
        alert('Please choose a point on the map'); // TODO
      }
    },

    onShowDialog: function(dialogId) {
      // Initialize
      var dialog = $(dialogId).modal();
      var afterDialogHide = function(callback){
        return function() {
          dialog.modal('hide');
          callback();
        }
      }

      // Bind UI events
      dialog.on('click.submitViewDialog', '[data-action="cancel"]', afterDialogHide(this.onCancel));
      dialog.on('click.submitViewDialog', '[data-action="submit"]', afterDialogHide(this.onCreate));

      // Unbind global events after we're done
      dialog.on('hide', function(){
        dialog.off('click.submitViewDialog');
      });

      // Finally, show the dialog
      dialog.modal('show');
    },

    onCreate: function(evt) {
      var comment = this.model.comments.findNew();
      // TODO: validation and error handling
      comment.save();
    },

    onCancel: function(evt) {
      var comment = this.model.comments.findNew();
      if (comment) {
        comment.destroy();
      }
    }
  });
}());

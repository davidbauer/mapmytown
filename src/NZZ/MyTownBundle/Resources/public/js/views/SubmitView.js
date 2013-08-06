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
      _.bindAll(this, 'render', 'onNew', 'onEdit', 'create', 'onShowDialog', 'onCancel');

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
      comment.on('change:latitude', this.render, this);
      comment.on('change:longitude', this.render, this);
      comment.on('change:persisted', this.render, this);
    },

    onEdit: function(evt) {
      var comment = this.model.comments.findNew();

      if (comment.get('latitude') && comment.get('longitude')) {
        var dialogId = $(evt.currentTarget).data('target');
        this.onShowDialog(dialogId);
      } else {
        alert('Please choose a point on the map'); // TODO
      }
    },

    onShowDialog: function(dialogId) {
      // Initialize
      var dialog = $(dialogId).modal();
      var afterHideDialog = function(callback) {
        return function() {
          dialog.modal('hide');
          callback();
        }
      }
      var withDialog = function(callback) {
        return function() {
          callback(dialog);
        }
      }

      // Bind UI events
      dialog.on('click.submitViewDialog', '[data-action="cancel"]', afterHideDialog(this.onCancel));
      dialog.on('click.submitViewDialog', '[data-action="submit"]', withDialog(this.create));

      // Unbind global events after we're done
      dialog.on('hide', function(){
        dialog.off('click.submitViewDialog');
      });

      // Finally, show the dialog
      dialog.modal('show');
    },

    create: function(dialog) {
      var comment = this.model.comments.findNew();
      var $form = dialog.find('form');

      // Serialize form
      var formData = $form.serializeArray();
      var data = _.reduce(formData, function(memo, d){
        memo[d.name] = d.value;
        return memo;
      }, {});

      var request = comment.save(data);
      if (request) {
        request.done(_.bind(function(){
          $form.trigger('reset');
          dialog.modal('hide');
          this.model.comments.selectComment(comment);
        }, this));
        request.fail(function() {
          alert("Could not save the data"); // TODO
        });
      } else {
        alert("Not all required fields are filled-in: " + comment.validationError); // TODO
      }
    },

    onCancel: function(evt) {
      var comment = this.model.comments.findNew();
      if (comment) {
        comment.destroy();
      }
    }
  });
}());

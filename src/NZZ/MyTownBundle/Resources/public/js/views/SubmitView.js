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

      // Init Toggle Charcount
      if (!this.hasCharCounter) {
        this.hasCharCounter = true;
        _.defer(function() {
          $(".charcount--max50").charCount({
            allowed: 50,
            warning: 20,
            counterText: ''
          });
          $(".charcount--max100").charCount({
            allowed: 100,
            warning: 20,
            counterText: ''
          });
        })
      }

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
          $("#thanks-modal").modal();

          this.model.comments.selectComment(comment);
        }, this));
        request.fail(function() {
          $('.form-feedback').show();
          $('.form-feedback').text("Could not save the data");
        });
      } else {
        $('.form-feedback').show();
        $('.form-feedback').text("Not all required fields are filled-in correctly: " + comment.validationError + "...");
      }
    },

    onCancel: function(evt) {
      var comment = this.model.comments.findNew();
      if (comment) {
        comment.destroy();
      }
      $('.form-feedback').hide();
    }
  });
}());
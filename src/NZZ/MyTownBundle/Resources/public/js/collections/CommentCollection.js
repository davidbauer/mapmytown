(function () {
  "use strict";

  window.app.collections.CommentCollection = Backbone.Collection.extend({
    model: app.models.Comment
  });
}());

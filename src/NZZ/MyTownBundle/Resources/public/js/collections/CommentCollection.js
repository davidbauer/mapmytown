(function () {
  "use strict";

  window.app.collections.CommentCollection = Backbone.Collection.extend({
    model: app.models.Comment,

    selectAt: function(idx) {
      this.forEach(function(m) {m.set('selected', false)});
      this.at(0).set('selected', true);
    }
  });
}());

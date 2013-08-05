(function () {
  "use strict";

  window.app.collections.CommentCollection = Backbone.Collection.extend({
    model: app.models.Comment,

    selectAt: function(idx) {
      this.forEach(function(m) {m.set('selected', false)});
      this.at(0).set('selected', true);
    },

    findNew: function() {
      var newComments = this.filter(function(d){return d.isNew()});
      return newComments ? newComments[0] : null;
    }
  });
}());

(function () {
  "use strict";

  window.app.collections.CommentCollection = Backbone.Collection.extend({
    model: app.models.Comment,

    selectComment: function(comment) {
      var idx = this.indexOf(comment);
      if (idx > -1) this.selectAt(idx);
    },

    selectAt: function(idx) {
      this.forEach(function(d){d.set('selected', false)});
      this.at(idx).set('selected', true);
    },

    forEachPersisted: function(callback) {
      return this
        .filter(function(d){return d.isPersisted()})
        .forEach(callback);
    },

    findNew: function() {
      var newComments = this.filter(function(d){return !d.isPersisted()});
      return newComments ? newComments[0] : null;
    }
  });
}());

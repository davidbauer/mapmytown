(function () {
  "use strict";

  window.app.models.AppModel = Backbone.Model.extend({
    initialize: function() {
      _.bindAll(this, 'parse');
    },

    fetch: function() {
      if (this.deferred) this.deferred.reject();

      var req = $.ajax({
        url: "/bundles/nzzmytown/mockdata/project.json",
        dataType: "json"
      });
      req.done(this.parse);
      req.fail(function() {
        console.error("Todo: catch error");
      });

      this.deferred = $.Deferred();
      return this.deferred.promise();
    },

    parse: function(result) {
      // Comments
      this.comments = new app.collections.CommentCollection(result.project.points);
      delete result.project.points;

      // Set project data      
      this.set(result.project);

      // Mark deferred as resolved
      this.deferred.resolve();
      this.deferred = null;
    }
  });
}());
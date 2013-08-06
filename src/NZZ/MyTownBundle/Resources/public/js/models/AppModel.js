(function () {
  "use strict";

  window.app.models.AppModel = Backbone.Model.extend({
    initialize: function() {
      _.bindAll(this, 'parse');
      this.comments = new app.collections.CommentCollection();
    },

    fetch: function() {
      if (this.deferred) this.deferred.reject();

      var req = $.ajax({
        url: app.config.baseUrl,
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
      this.comments.reset(result.project.points);
      this.comments.selectAt(0);
      delete result.project.points;

      // Set project data
      this.set(result.project);

      // Mark deferred as resolved
      this.deferred.resolve();
      this.deferred = null;
    }
  });
}());

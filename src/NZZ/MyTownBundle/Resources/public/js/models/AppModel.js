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
      this.comments.selectAt(0);
      delete result.project.points;

      // Set project data      
      this.set(result.project);

      // set project default to state if not already defined via query param
      this.state.set({
        'lat': this.state.get('lat') || this.get('latitude'),
        'lng': this.state.get('lng') || this.get('longitude'),
        'zoom': this.state.get('zoom') || this.get('zoom')
      });

      // Mark deferred as resolved
      this.deferred.resolve();
      this.deferred = null;
    }
  });
}());

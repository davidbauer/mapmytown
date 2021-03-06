(function () {
  "use strict";

  window.app.models.Comment = Backbone.Model.extend({
    defaults: {
      selected: false,
      persisted: false,
      visible: true
    },

    initialize: function() {
      // If the comment has an ID, mark it as persisted
      this.set('persisted', !!this.get('id'));
    },

    isPersisted: function() {
      return this.get('persisted');
    },

    isVisible: function() {
      return this.get('visible');
    },

    getLatLng: function() {
      var lat = this.get('latitude');
      var lng = this.get('longitude');
      if (lat && lng) {
        return new L.LatLng(lat, lng);
      } else {
        return null;
      }
    },

    setLatLng: function(latlng) {
      this.set({
        latitude: latlng.lat,
        longitude: latlng.lng
      });
    },

    // We're overriding Backbone's save method here to have more
    // control and to make it clear, that only this function
    // is supported
    save: function(data) {
      data = _.extend(this.toJSON(), data);

      // Try to store the data, but don't continue if the
      // validation fails
      if (!this.set(data, {validate: true})) return false;

      var request = $.ajax({
        url: app.config.apiUrl,
        data: $.param(data),
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        }
      });

      request.done(_.bind(function() {
        // If the storage request was successful, mark the model as persisted
        this.set('persisted', true);
      }, this));

      return request;
    },

    validate: function(attrs, options) {
      var errors = [];
      if (!attrs.title || attrs.title == "") errors.push(i18n.t('form.title'));
      if (!attrs.description || attrs.description == "") errors.push(i18n.t('form.description'));
      if (!_.include(["-1", "0", "1"], "" + attrs.sentiment)) errors.push(i18n.t('form.sentiment'));
      if (!attrs.authorName || attrs.authorName == "") errors.push(i18n.t('form.name'));
      if (!attrs.latitude) errors.push('Latitude is missing');
      if (!attrs.longitude) errors.push('Longitude is missing');
      if (errors.length > 0) return _.map(errors, function(d){return '“'+d+'”'}).join(", ");
      return null;
    }
  });
}());

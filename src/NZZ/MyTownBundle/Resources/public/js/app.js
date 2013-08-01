(function () {
  "use strict";
  window.app = window.app || {
    routers: {},
    collections: {},
    models: {},
    views: {},
    config: {
      project: 'nzz',
      mapboxKey: 'sylke-gruhnwald.map-a6qno9vz'
    }
  };

  app.routers.AppRouter = Backbone.Router.extend({
    routes: {
      "": "index",
      "show": "index"
    },
    initialize: function() {
      console.log('init');

      var appModel = this.appModel = new app.models.AppModel(),
          state = appModel.state = new app.models.State();

      // update url
      this.listenTo(state, 'change', this.replaceState);
    },
    index: function (queryParams) {
      queryParams = queryParams || {};
      console.log('index', queryParams);

      // only remember known state vars from queryParams
      // - you can add new ones @ state.defaults
      var state = this.appModel.state;
      state.set(_.pick(queryParams, _.keys(state.attributes)));

      this.appModel.fetch().done(function() {
        var currentView = new app.views.RootView({
          model: this.appModel,
          el: "[data-view='root']"
        });
        currentView.render();
      }.bind(this));
    },
    replaceState: function() {
        var action = 'show',
            queryParams = this.appModel.state.attributes;
        console.log('replaceState', action, queryParams);
        this.navigate(this.toFragment(action, queryParams), {replace: true});
    }

  });
}());

// function MarkerController ($scope, $http) {
//     $scope.save = function () {
//         var data = {};

//         data.lat = $scope.latlng.lat;
//         data.lng = $scope.latlng.lng;
//         data.comment = $scope.comment;
//         data.author = $scope.author;
//         if (data.author.length > 0 && data.comment.length > 0) {
//             console.log($scope);
//             $http({
//                 url: '/app_dev.php/nzz/save',
//                 method: "POST",
//                 data: $.param(data),
//                 headers: {'Content-Type': 'application/x-www-form-urlencoded'}
//             }).success(function (data, status, headers, config) {
//                     alert('saved');
//                     $scope.marker.addTo($scope.map);
//                 }).error(function (data) {
//                     $scope.map.removeLayer($scope.marker);
//                 });
//         } else {
//             alert('empty');
//         }
//     }
// }

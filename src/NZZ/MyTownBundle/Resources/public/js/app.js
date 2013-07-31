(function () {
  "use strict";
  window.app || (window.app = {
    routers: {},
    collections: {},
    models: {},
    views: {},
    config: {
      city: 'Zürich',
      lat: '47.369',
      lon:  '8.542',
      zoom: 18,
      project: 'nzz',
      mapboxKey: 'sylke-gruhnwald.map-a6qno9vz'
    }
  });
  app.routers.AppRouter = Backbone.Router.extend({
    routes: {
      "": "index"
    },

    index: function () {
      this.currentView = new app.views.RootView();
      $('#app-container').html(this.currentView.render().el);
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

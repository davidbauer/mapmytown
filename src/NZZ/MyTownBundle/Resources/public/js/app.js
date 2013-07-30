(function () {
  "use strict";
  window.app || (window.app = {routers: {}, collections: {}, models: {}, views: {}});
  app.routers.AppRouter = Backbone.Router.extend({
    routes: {
      "": "index"
    },

    index: function () {
      this.currentView = new app.views.RootView().render();
      $('#app-container').html(this.currentView.render().el);
    }
  });
}());

// function MapController ($scope, $compile) {

//     var tmpl = '<div class="control-group" ng-controller="MarkerController">' +
//                     '<label for="author">Author</label>' +
//                     '<input type="text" id="author" ng-model="author" size=20 required>' +
//                     '<label for="comment">Comment</label>' +
//                     '<input type="text" id="comment" ng-model="comment" required>' +
//                     '<button class="btn btn-danger" ng-click="save()">Save</button>' +
//                 '</div>';

//     // use mapbox
//     $scope.map = L.mapbox.map('map', 'sylke-gruhnwald.map-a6qno9vz');

//     $scope.map.setView(new L.LatLng(config.lat, config.lon),parseInt(config.zoom));

//     $scope.onMapClick = function (e) {
//         var w, s = document.createElement('div'),
//             c = e.latlng;
//         var myIcon = L.icon({
//             iconUrl: '/bundles/nzzmytown/images/' + config.project +'.png',
//             iconSize: [25, 41],
//             iconAnchor: [22, 30],
//             popupAnchor: [-3, -20],
//             shadowSize: [68, 95],
//             shadowAnchor: [22, 94]
//         });
//             marker = new L.marker(e.latlng, {riseOnHover: true, icon: myIcon});

//         $compile(tmpl)($scope, function (clonedElement) {
//             $(s).append(clonedElement);
//             $scope.marker = marker;
//             $scope.latlng = c;
//             marker.bindPopup(s);
//         });
//         marker.addTo($scope.map).remove(marker);

//     };

//     $scope.map.on('click', $scope.onMapClick);
// }
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

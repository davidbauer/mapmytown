var module = angular.module('leafletMap', []);
module.directive('sap', function() {
    return {
        restrict: 'E',
        replace: true,
        template: '<div></div>',
        link: function(scope, element, attrs) {
            var map = L.map(attrs.id, {
                center: [40, -86],
                zoom: 10
            });
            //create a CloudMade tile layer and add it to the map
            L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18
            }).addTo(map);

            //add markers dynamically
            var points = [{lat: 40, lng: -86},{lat: 40.1, lng: -86.2}];
            updatePoints(points);

            function updatePoints(pts) {
                for (var p in pts) {
                    L.marker([pts[p].lat, pts[p].lng]).addTo(map);
                }
            }

            //add a watch on the scope to update your points.
            // whatever scope property that is passed into
            // the poinsource="" attribute will now update the points
            scope.$watch(attr.pointsource, function(value) {
                updatePoints(value);
            });
        }
    };
});

function MapCtrl($scope, $http) {
    //here's the property you can just update.
    $scope.pointsFromController = [{lat: 40, lng: -86},{lat: 40.1, lng: -86.2}];

    //here's some contrived controller method to demo updating the property.
    $scope.getPointsFromSomewhere = function() {
        $http.get('/Get/Points/From/Somewhere').success(function(somepoints) {
            $scope.pointsFromController = somepoints;
        });
    }
}
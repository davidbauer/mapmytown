angular.module("demoapp", ["leaflet-directive"]);
function DemoController($scope) {
    angular.extend($scope, {
        tileLayer: "http://{s}.tile.opencyclemap.org/cycle/{z}/{x}/{y}.png",
        london: {
            lat: 51.505,
            lng: -0.09,
            zoom: 8
        },
        markers: {
            m1: {
                lat: 51.505,
                lng: -0.09,
                message: "I'm a static marker"
            },
            m2: {
                lat: 51,
                lng: 0,
                focus: true,
                message: "Hey, drag me if you want",
                draggable: true
            }
        }
    });
};
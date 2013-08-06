(function() {
    if(!window.console) {
        window.console = {};
    }

    var noop = function() {},
        methods = 'assert clear count debug dir dirxml error exception group groupCollapsed groupEnd info log markTimeline profile profileEnd markTimeline table time timeEnd timeStamp trace warn'.split(' '),
        length = methods.length;

    while(length--) {
        if(typeof console[methods[length]] != 'function') {
            console[methods[length]] = noop;
        }
    }
}());

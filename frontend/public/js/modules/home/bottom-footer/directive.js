'use strict';

module.exports = [function () {
    return {
        restrict: 'E',
        replace: true,
        scope: false,
        template: require('./template.html')
    };
}
];

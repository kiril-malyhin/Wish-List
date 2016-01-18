'use strict';

module.exports = [function () {
    return {
        restrict: 'E',
        replace: true,
        scope: {
            data: '=',
            prefix: '@?'
        },
        template: require('./template.html'),
        controller: ['$scope', function($scope) {
            $scope.prefix = $scope.prefix || '@';
        }]
    };
}
];

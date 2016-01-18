'use strict';

module.exports = [
    '$scope',
    '$stateParams',
    '$state',
    'userService',
    function ($scope, $stateParams, $state, userService) {
        userService.getUser(parseInt($stateParams.userId, 10)).then(function(response) {
            if(response.result === 'success') {
                $scope.user = response.data;
            }
        });

        $scope.changePasswordBtn = false;
    }
];

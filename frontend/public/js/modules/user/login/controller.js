'use strict';

module.exports = [
    '$scope',
    '$state',
    'authService',
    function ($scope, $state, authService) {

        $scope.loginData = {
            email: '',
            password: ''
        };

        $scope.login = function () {
            return authService.login($scope.loginData).then(
                function () {
                    $state.go('wish-list');
                }
            );
        };

    }
];

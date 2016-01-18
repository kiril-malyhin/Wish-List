'use strict';

module.exports = [
    '$scope',
    '$state',
    'authService',
    'userService',
    function ($scope, $state, authService, userService) {

       $scope.isAuth = function() {
            return authService.isAuthenticated();
        };

        $scope.logout = function() {
            userService.logout().then(function() {
                $state.go('login');
            });
        };

    }
];

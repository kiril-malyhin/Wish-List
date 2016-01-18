'use strict';

module.exports = [
    '$rootScope',
    'authEvents',
    'authService',
    '$state',
    'itaEmbeddedDataService',
    'userService',
    function($rootScope, authEvents, authService, $state, itaEmbeddedDataService, userService) {
        var isLoadedProfile = false;

        $rootScope.$on('$stateChangeStart', function (event, toState) {

            var checkAuth = function () {

                if (!toState.data || !toState.data.authorizedRoles) {
                    if(
                        authService.isAuthenticated() && (
                        toState.name === 'login' ||
                        toState.name === 'registration' ||
                        toState.name === 'home')
                    ) {
                        event.preventDefault();
                        return $state.go('wish-list');
                    }
                } else {
                    var authorizedRoles = toState.data.authorizedRoles;

                    if (!authService.isAuthorized(authorizedRoles)) {
                        event.preventDefault();
                        if (authService.isAuthenticated()) {
                            $rootScope.$broadcast(authEvents.notAuthorized);
                            return $state.go('forbidden');
                        } else {
                            $rootScope.$broadcast(authEvents.notAuthenticated);
                            return $state.go('login');
                        }
                    }
                }
            };

            if (!isLoadedProfile) {
                isLoadedProfile = true;

                userService.getProfile().then(function(response) {
                    if(response.result === 'success') {
                        itaEmbeddedDataService.setCurrentUser(response.data);

                        checkAuth();
                    } else {
                        itaEmbeddedDataService.setCurrentUser(null);

                        checkAuth();
                    }
                }, function() {
                    itaEmbeddedDataService.setCurrentUser(null);

                    checkAuth();
                });
            } else {
                checkAuth();
            }
        });
    }
];
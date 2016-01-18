'use strict';

var angular = require('angular');

module.exports = [
    'userService',
    'userRoleService',
    'itaEmbeddedDataService',
    'messageService',
    function (userService, userRoleService, itaEmbeddedDataService, messageService) {
        var authService = {};

        authService.login = function (credentials) {
            return userService.login(credentials).then(function (response) {
                if(response.result === 'success') {
                    itaEmbeddedDataService.setCurrentUser(response.data);
                    messageService.success('Success login. Hello, '+ response.data.first_name);
                    return response;
                } else {
                    itaEmbeddedDataService.setCurrentUser(null);
                    messageService.error('Error login.');
                    return response;
                }
            });
        };

        authService.isAuthenticated = function () {
            return !!itaEmbeddedDataService.getCurrentUser();
        };

        authService.isAuthorized = function (authorizedRoles) {
            if (!angular.isArray(authorizedRoles)) {
                authorizedRoles = [authorizedRoles];
            }

            return authService.isAuthenticated() && authorizedRoles.indexOf(itaEmbeddedDataService.getCurrentUser().role) !== -1;
        };

        return authService;
    }
];
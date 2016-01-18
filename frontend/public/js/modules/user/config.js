'use strict';

module.exports = [
    '$stateProvider',
    function ($stateProvider) {
        $stateProvider
            .state('profile', {
                url: '/profile',
                controller: 'ProfileController',
                template: require('./profile/template.html'),
                data: {
                    authorizedRoles: ['User']
                }
            })
            .state('user-page', {
                url: '/user/:userId',
                template: require('./user-page/template.html'),
                controller: 'UserPageController',
                data: {
                    authorizedRoles: ['User']
                }
            })
            .state('users', {
                url: '/users',
                controller: 'UserController',
                template: require('./template.html'),
                data: {
                    authorizedRoles: ['User']
                }
            });
    }
];

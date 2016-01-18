'use strict';

module.exports = [
    '$stateProvider',
    function ($stateProvider) {
        $stateProvider
            .state('friends', {
                url: '/friends',
                controller: 'FriendController',
                template: require('./template.html'),
                data: {
                    authorizedRoles: ['User']
                }
            })
            .state('userFriends', {
                url: '/friends/:userId',
                controller: 'UserFriendController',
                template: require('./user-friends/template.html'),
                data: {
                    authorizedRoles: ['User']
                }
            });
    }
];

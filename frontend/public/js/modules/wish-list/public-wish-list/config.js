'use strict';

module.exports = [
    '$stateProvider',
    function ($stateProvider) {
        $stateProvider
            .state('public-wish-list', {
                url: '/public-wish-page/:userId',
                controller: 'PublicWishController',
                template: require('./template.html'),
                data: {
                    authorizedRoles: ['User']
                }
            });
    }
];
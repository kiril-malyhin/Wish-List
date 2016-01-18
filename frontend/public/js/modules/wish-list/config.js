'use strict';

module.exports = [
    '$stateProvider',
    function ($stateProvider) {
        $stateProvider
            .state('wish-list', {
                url: '/wish-page',
                controller: 'WishController',
                template: require('./template.html'),
                data: {
                    authorizedRoles: ['User']
                }
            });
    }
];


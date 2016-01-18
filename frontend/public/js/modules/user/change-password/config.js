'use strict';

module.exports = [
    '$stateProvider',
    function ($stateProvider) {
        $stateProvider
            .state('change-password', {
                url: '/change-password',
                template: require('./template.html'),
                data: {
                    authorizedRoles: ['User']
                }
            });
    }
];

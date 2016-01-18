
'use strict';

module.exports = [
    '$stateProvider',
    function ($stateProvider) {
        $stateProvider
            .state('restore-password', {
                url: '/restore-password',
                template: require('./template.html')
            });
    }
];


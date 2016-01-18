
'use strict';

module.exports = [
    '$stateProvider',
    function ($stateProvider) {
        $stateProvider
            .state('registration', {
                url: '/registration?email',
                template: require('./template.html'),
                controller: 'RegistrationController'
            });
    }
];


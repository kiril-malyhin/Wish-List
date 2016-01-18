'use strict';

module.exports = [
    '$stateProvider',
    function ($stateProvider) {
        $stateProvider
            .state('forbidden', {
                url: '/forbidden',
                template: require('./forbidden-template.html')
            });
    }
];

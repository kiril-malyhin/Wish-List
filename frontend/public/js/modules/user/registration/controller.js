'use strict';

module.exports = [
    '$scope',
    '$state',
    'userService',
    'messageService',
    '$stateParams',
    function ($scope, $state, userService, messageService, $stateParams) {

        $scope.registrationData = {
            email: $stateParams.email,
            password: '',
            confirm: '',
            first_name: '',
            last_name: '',
            city: '',
            phone: ''
        };

        $scope.registration = function() {
            userService.registration($scope.registrationData).then(
                function (response) {
                    if(response.result === 'success') {
                        messageService.success('Success registration.');

                        $state.go('login');
                    } else {
                        messageService.error(response.data);
                    }
                }, function() {
                    messageService.error('Error registration!');
                }
            );
        };

    }
];

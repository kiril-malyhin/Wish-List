'use strict';

module.exports = [
    '$scope',
    '$state',
    'userService',
    'messageService',
    function ($scope, $state, userService, messageService) {
        userService.getProfile().then(function(response) {
            if(response.result === 'success') {
                $scope.user = response.data;
            }
        }, function() {
            return $state.go('login');
        });

        $scope.changePasswordBtn = true;

        $scope.uploadPic = function(file) {
            userService.uploadPhoto(file).then(function(response) {
                if(response.result === 'success') {
                    $scope.user = response.data;
                    $scope.picFile = null;
                    messageService.success('SUCCESS');
                } else {
                    messageService.error('Error uploading!');
                }
            }, function() {
                messageService.error('Error uploading!');
            });
        }

    }
];

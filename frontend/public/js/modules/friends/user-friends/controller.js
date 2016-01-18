'use strict';

module.exports = [
    '$scope',
    '$stateParams',
    'userService',
    'messageService',
    'categoryService',
    function ($scope, $stateParams, userService, messageService, categoryService) {

        userService.getUser(parseInt($stateParams.userId, 10)).then(function(response) {
            $scope.currentUser = response.data;
        });

        categoryService.getFriendCategories().then(function(response) {
            $scope.categories = response;
        });

        var loadUsers = function () {
            userService.getUserFriends(parseInt($stateParams.userId, 10)).then(function(response) {
                if(response.result === 'success') {
                    $scope.users = response.data;
                }
            });
        };

        loadUsers();

        $scope.removeFriend = function(id) {
            userService.removeFriend(id).then(function(response) {
                if(response.result === 'success') {
                    loadUsers();
                    messageService.success('A friend successfully removed.');
                } else {
                    messageService.error('Error.');
                }
            }, function() {
                messageService.error('Error.');
            });
        };

        $scope.addFriend = function(id, categoryId) {
            userService.addFriend(id, categoryId).then(function(response) {
                if(response.result === 'success') {
                    loadUsers();
                    messageService.success('A friend successfully added.');
                } else {
                    messageService.error('Error.');
                }
            }, function() {
                messageService.error('Error.');
            });
        };
    }
];

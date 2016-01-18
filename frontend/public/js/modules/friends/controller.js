'use strict';

module.exports = [
    '$scope',
    '$state',
    'userService',
    'messageService',
    'categoryService',
    function ($scope, $state, userService, messageService, categoryService) {
        categoryService.getFriendCategories().then(function(response) {
            $scope.categories = response;
        });

        var loadFriends = function () {
            userService.getFriends().then(function(response) {
                if(response.result === 'success') {
                    $scope.friends = response.data;
                }
            });
        };

        loadFriends();

        $scope.confirmFriend = function(id, categoryId) {
            userService.addFriend(id, categoryId).then(function(response) {
                if(response.result === 'success') {
                    loadFriends();
                    messageService.success('A friend successfully confirmed.');
                } else {
                    messageService.error('Error.');
                }
            }, function() {
                messageService.error('Error.');
            });
        };

        $scope.removeFriend = function(id) {
            userService.removeFriend(id).then(function(response) {
                if(response.result === 'success') {
                    loadFriends();
                    messageService.success('A friend successfully removed.');
                } else {
                    messageService.error('Error.');
                }
            }, function() {
                messageService.error('Error.');
            });
        };

        $scope.editCategory = function(id, categoryId) {
            userService.editFriendCategory(id, categoryId).then(function(response) {
                if(response.result === 'success') {
                    loadFriends();
                    messageService.success('A friend category successfully changed.');
                } else {
                    messageService.error('Error.');
                }
            }, function() {
                messageService.error('Error.');
            });
        };

    }
];

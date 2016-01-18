'use strict';

module.exports = [
    '$scope',
    '$state',
    'userService',
    'messageService',
    'categoryService',
    function ($scope, $state, userService, messageService, categoryService) {

        $scope.search = '';
        $scope.isDisabledSearchBtn = true;

        categoryService.getFriendCategories().then(function(response) {
            $scope.categories = response;
        });

        var loadUsers = function () {
            userService.getUsers().then(function(response) {
                if(response.result === 'success') {
                    $scope.users = response.data;
                    $scope.isDisabledSearchBtn = true;
                }
            });
        };

        $scope.loadUsers = function() {
            $scope.search = '';
            loadUsers();
        };

        loadUsers();

        $scope.searchUsers = function() {
            if($scope.search.length < 2) {
                return messageService.error('Error. Please input the name of user you want to search!');
            }
            userService.searchUsers($scope.search).then(function(response) {
                if(response.result === 'success') {
                    $scope.users = response.data;
                    $scope.isDisabledSearchBtn = false;
                } else {
                    messageService.error('Error. Access deny!');
                }
            });
        };

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

        $scope.editCategory = function(id, categoryId) {
            userService.editFriendCategory(id, categoryId).then(function(response) {
                if(response.result === 'success') {
                    loadUsers();
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

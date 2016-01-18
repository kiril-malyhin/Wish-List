'use strict';

var angular = require('angular');

module.exports = [
    '$scope',
    '$state',
    'wishService',
    'categoryService',
    'messageService',
    function ($scope, $state, wishService, categoryService, messageService) {
        $scope.showAddButton = true;
        $scope.editWishObj = false;

        categoryService.getCategories().then(function(response) {
            $scope.categoryItems = response;

        });

        var loadWishes = function () {
            wishService.getWishes().then(function(response) {
                if(response.result === 'success') {
                    $scope.wishes = response.data;
                }
            });
        };

        loadWishes();

        $scope.onEditWishClick = function(wish){
            $scope.editWishObj = angular.copy(wish);
        };

        $scope.cancelEdit = function(){
            $scope.editWishObj = false;
        };

        $scope.abortEdit = function() {
            messageService.confirm(
                'Do you really want to cancel the editing?',
                function() {
                    messageService.error('Wish is not changed.');
                    $scope.cancelEdit();
                }
            );
        };

        $scope.addWish = function() {
            if ($scope.addWishForm.$valid) {
                wishService.addWish($scope.wishData).then(function(response){

                    if(response.result === 'success')
                    {
                        messageService.success('Wish successfully added.');
                        $scope.hideAddWishForm();
                        loadWishes();
                    }
                });

            } else {
                messageService.error('Error! Check the entered data.');
            }
        };

        $scope.deleteWish = function (wish) {
            messageService.confirm(
                'Do you really want to delete this wish?',
                function() {
                    wishService.deleteWish(wish.id).then(function(response){
                        if(response.result ==='success') {
                            messageService.success('Wish successfully deleted.');
                            loadWishes();
                        }
                    });

                }
            );
        };

        $scope.editWish = function () {
            wishService.updateWish($scope.editWishObj.id, $scope.editWishObj).then(function(response){
                var wish = wishService.getWish($scope.editWishObj.id, $scope.wishes);
                wish = angular.copy($scope.editWishObj);
                messageService.success('Wish successfully changed.');
                $scope.cancelEdit();
                loadWishes();
            });
        };

        $scope.showAddWishForm = function () {
            $scope.showForm = true;
            $scope.showAddButton = false;
            $scope.wishData = {};
        };

        $scope.hideAddWishForm = function () {
            $scope.showForm = false;
            $scope.showAddButton = true;
        };

        $scope.updatePublishStateTrue = function(wish) {
            wishService.updateStateTrue(wish.id).then(function(response){
                if(response.result ==='success') {
                    loadWishes();
                }
            });
        };

        $scope.updatePublishStateFalse = function(wish) {
            wishService.updateStateFalse(wish.id).then(function(response){
                if(response.result ==='success') {
                    loadWishes();
                }
            });
        }
    }
];

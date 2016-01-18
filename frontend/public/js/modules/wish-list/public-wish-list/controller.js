'use strict';

module.exports = [
    '$scope',
    'categoryService',
    'wishService',
    '$stateParams',
    'userService',
    function ($scope, categoryService, wishService,$stateParams, userService) {
        categoryService.getCategories().then(function(response) {
            $scope.categoryItems = response;
        });

        userService.getUser(parseInt($stateParams.userId, 10)).then(function(response) {
            $scope.currentUser = response.data;
        });

        var showUserWishes = function () {
            wishService.wishList(parseInt($stateParams.userId, 10)).then(function (response) {
                if (response.result === 'success') {
                    $scope.wishes = response.data;
                }
            });
        };

        showUserWishes();

        $scope.updatePresentStateTrue = function(wish) {
            wishService.updatePresentTrue(parseInt($stateParams.userId, 10)).then(function(response){
                if(response.result ==='success') {
                    showUserWishes();
                }
            });
        };

        $scope.updatePresentStateFalse = function(wish) {
            wishService.updatePresentFalse(parseInt($stateParams.userId, 10)).then(function(response){
                if(response.result ==='success') {
                    showUserWishes();
                }
            });
        }
    }
];

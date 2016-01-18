'use strict';

module.exports = [
    'itaRequestService',
    function (itaRequestService) {
        this.getCategories = function () {
            return itaRequestService.request({
                url: '/categories',
                method: 'get'
            }).then(function(response) {
                return response;
            });
        };

        this.getFriendCategories = function () {
            return itaRequestService.request({
                url: '/categories/friend',
                method: 'get'
            }).then(function(response) {
                return response;
            });
        };
    }
];
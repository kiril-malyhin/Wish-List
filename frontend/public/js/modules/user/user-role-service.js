'use strict';

module.exports = [
    'itaRequestService',
    function (itaRequestService) {
        this.getRoles = function () {
            return itaRequestService.request({
                url: '/roles',
                method: 'get'
            }).then(function(response) {
                return response.data;
            });
        };

        this.getRole = function (id) {
            return itaRequestService.request({
                url: ['/role', id].join('/'),
                method: 'get'
            }).then(function(response) {
                return response.data;
            });
        };

    }
];

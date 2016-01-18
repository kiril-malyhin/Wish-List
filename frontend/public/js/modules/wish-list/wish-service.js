'use strict';

var _ = require('lodash');

module.exports = [
    'itaRequestService',
    function (itaRequestService) {

        this.getWishes = function() {
            return itaRequestService.request({
                method: 'GET',
                url: '/wishes'
            }).then(function(response) {
                return response;
            });
        };

        this.addWish = function (data) {
            return itaRequestService.request({
                method: 'POST',
                url: '/wish/add',
                data: data
            });
        };

        this.getWish = function (id, data) {
            return _.find(data, function(wish) {
                return wish.id === id;
            });
        };

        this.updateWish = function (id,data) {

            return itaRequestService.request({
                method: 'PUT',
                contentType: 'multipart/form-data',
                url: ['/wish', id].join('/'),
                data: data
            });
        };

        this.deleteWish = function(id) {
            return itaRequestService.request({
                method: 'DELETE',
                url: ['/wish', id].join('/'),
            }).then(function(response) {
                return response;
            });

        };

        this.wishList = function(id) {
            return itaRequestService.request({
                method: 'get',
                url: ['/wishes', id].join('/'),
            });
        };

        this.updateStateTrue= function (id) {
            return itaRequestService.request({
                method: 'PUT',
                url: ['/publish_state_true', id].join('/')
            });
        };

        this.updateStateFalse= function (id) {
            return itaRequestService.request({
                method: 'PUT',
                url: ['/publish_state_false', id].join('/')
            });
        };

        this.updatePresentTrue= function (id) {
            return itaRequestService.request({
                method: 'PUT',
                url: ['/present_state_true', id].join('/')
            });
        };

        this.updatePresentFalse= function (id) {
            return itaRequestService.request({
                method: 'PUT',
                url: ['/present_state_false', id].join('/')
            });
        };
    }
];
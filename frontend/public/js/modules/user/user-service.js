'use strict';

module.exports = [
    'userRoleService',
    'itaRequestService',
    'itaEmbeddedDataService',
    'Upload',
    function (userRoleService, itaRequestService, itaEmbeddedDataService, Upload) {
        var roles = [];
        var loadRoles = function() {
            userRoleService.getRoles().then(function(response) {
                roles = response;
            });
        };

        loadRoles();

        this.getUsers = function () {
            return itaRequestService.request({
                method: 'GET',
                url: '/users'
            }).then(function(response) {
                return response;
            });
        };

        this.searchUsers = function (search) {
            return itaRequestService.request({
                method: 'GET',
                url: ['/users', search].join('/')
            }).then(function(response) {
                return response;
            });
        };

        this.getFriends = function() {
            return itaRequestService.request({
                method: 'GET',
                url: '/friends'
            }).then(function(response) {
                return response;
            });
        };

        this.getUserFriends = function(id) {
            return itaRequestService.request({
                method: 'GET',
                url: ['/friends', id].join('/')
            }).then(function(response) {
                return response;
            });
        };

        this.getUser = function (id) {
            return itaRequestService.request({
                url: ['/user', id].join('/'),
                method: 'get'
            }).then(function(response) {
                return response;
            });
        };

        this.login = function (data) {
            return itaRequestService.request({
                method: 'POST',
                url: '/user/login',
                data: data
            });
        };

        this.registration = function (data) {
            return itaRequestService.request({
                method: 'POST',
                url: '/user/registration',
                data: data
            });
        };

        this.getProfile = function() {
            return itaRequestService.request({
                method: 'POST',
                url: '/user/auth'
            });
        };

        this.addFriend = function(id, categoryId) {
            return itaRequestService.request({
                method: 'POST',
                url: '/friend/add',
                data: {
                    id: id,
                    categoryId: categoryId
                }
            });
        };

        this.editFriendCategory = function(id, categoryId) {
            return itaRequestService.request({
                method: 'POST',
                url: '/friend/edit',
                data: {
                    id: id,
                    categoryId: categoryId
                }
            });
        };

        this.removeFriend = function(id) {
            return itaRequestService.request({
                method: 'POST',
                url: '/friend/remove',
                data: {
                    id: id
                }
            });
        };

        this.logout = function () {
            itaEmbeddedDataService.setCurrentUser(null);

            return itaRequestService.request({
                method: 'POST',
                url: '/user/logout'
            });
        };

        this.uploadPhoto = function(file) {
            return itaRequestService.request({
                method: 'POST',
                url: '/user/photo',
                contentType: 'multipart/form-data',
                data: {
                    file: file
                }
            });
        };

    }
];
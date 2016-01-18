'use strict';

var angular = require('angular');

angular
    .module('Friends', [])
    .config(require('./config'))
    .controller('FriendController', require('./controller'))
    .controller('UserFriendController', require('./user-friends/controller'))
    .service('categoryService', require('./category-service'))
    .directive('wishLink', require('./wish-link'));


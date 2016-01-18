'use strict';

var angular = require('angular');
require('./public-wish-list');

angular
    .module('WishList', ['PublicWishList'])
    .config(require('./config'))
    .controller('WishController', require('./controller'))
    .service('wishService', require('./wish-service'));

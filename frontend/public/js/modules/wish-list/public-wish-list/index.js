'use strict';

var angular = require('angular');

angular
    .module('PublicWishList', [])
    .config(require('./config'))
    .controller('PublicWishController', require('./controller'))


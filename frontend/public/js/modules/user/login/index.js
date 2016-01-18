'use strict';

var angular = require('angular');

angular
    .module('User.Login', [])
    .config(require('./config'))
    .controller('LoginController', require('./controller'));

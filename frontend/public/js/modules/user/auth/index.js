'use strict';

var angular = require('angular');

angular
    .module('User.Auth', [])
    .config(require('./config'))
    .run(require('./auth-run'))
    .constant('authEvents', require('./auth-events'))
    .factory('authService', require('./auth-service'));
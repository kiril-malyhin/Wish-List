'use strict';

var angular = require('angular');


angular
    .module('User.Registration', [])
    .config(require('./config'))
    .controller('RegistrationController', require('./controller'));
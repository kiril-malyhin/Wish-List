'use strict';

var angular = require('angular');
require('./restore-password/index');
require('./login/index');
require('./auth/index');
require('./registration/index');
require('./change-password/index');

angular
    .module('User',
        [
            'User.RestorePassword',
            'User.ChangePassword',
            'User.Login',
            'User.Auth',
            'User.Registration'
        ])
    .config(require('./config'))
    .controller('UserController', require('./controller'))
    .controller('ProfileController', require('./profile/controller'))
    .controller('UserPageController', require('./user-page/controller'))
    .service('userService', require('./user-service'))
    .service('userRoleService', require('./user-role-service'))
    .directive('userLink', require('./user-link'));

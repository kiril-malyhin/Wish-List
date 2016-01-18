'use strict';

var angular = require('angular');

angular
    .module('Home', [])
    .config(require('./config'))
    .directive('topMenu', require('./top-menu/directive'))
    .directive('bottomFooter', require('./bottom-footer/directive'));

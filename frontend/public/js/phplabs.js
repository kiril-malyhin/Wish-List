'use strict';

var domready = require('domready');
var angular = require('angular');

//require common modules
require('./common/ita-embedded-data');
require('./common/ita-request');
require('./common/ita-loading');

//require project modules
require('./modules/home');
require('./modules/user');
require('./modules/wish-list');
require('./modules/friends');
require('./modules/message');

domready(function () {
    angular
        .module('PHPLabs', [
            'ui.router',
            'ui.bootstrap',

            'ngFileUpload',

            'ITA.EmbeddedData',
            'ITA.Request',
            'ITA.Loading',

            'Home',
            'User',
            'WishList',
            'Friends',
            'Message'
        ])
        .config([
            'itaEmbeddedDataServiceProvider',
            'itaRequestServiceProvider',
            '$urlRouterProvider',
            function(itaEmbeddedDataServiceProvider, itaRequestServiceProvider, $urlRouterProvider) {
                itaEmbeddedDataServiceProvider.init(window.embeddedData);
                itaRequestServiceProvider.baseUrl(window.embeddedData.api.url);
                $urlRouterProvider.otherwise('/');
            }
        ]);
    angular.bootstrap(document, ['PHPLabs']);
});

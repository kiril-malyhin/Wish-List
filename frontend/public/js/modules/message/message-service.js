'use strict';

var alertify = require('alertify');

module.exports = [
    '$timeout',
    function($timeout) {
        return {
            alert: function (message, callback) {
                alertify.alert(message, function() {
                    $timeout(function() {
                        callback();
                    });
                });
            },
            confirm: function (message, okCallback, cancelCallback) {
                alertify.confirm(
                    message,
                    function(e) {
                        if(e) {
                            if (okCallback) {
                                $timeout(function() {
                                    okCallback();
                                });
                            }
                        } else {
                            if (cancelCallback) {
                                $timeout(function() {
                                    cancelCallback();
                                });
                            }
                        }
                    }
                );
            },
            success: function (message) {
                alertify.success(message);
            },
            error: function (message) {
                alertify.error(message);
            },
            log: function (message) {
                alertify.log(message);
            }
        };
    }
];

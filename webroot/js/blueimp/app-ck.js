/*
 * jQuery File Upload Plugin Angular JS Example 1.2.1
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2013, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 *//*jslint nomen: true, regexp: true *//*global window, angular */(function() {
    "use strict";
    var e = window.location.hostname === "blueimp.github.io", t = e ? "//jquery-file-upload.appspot.com/" : "server/php/";
    angular.module("demo", [ "blueimp.fileupload" ]).config([ "$httpProvider", "fileUploadProvider", function(t, n) {
        delete t.defaults.headers.common["X-Requested-With"];
        n.defaults.redirect = window.location.href.replace(/\/[^\/]*$/, "/cors/result.html?%s");
        e && angular.extend(n.defaults, {
            disableImageResize: /Android(?!.*Chrome)|Opera/.test(window.navigator.userAgent),
            maxFileSize: 5e6,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i
        });
    } ]).controller("DemoFileUploadController", [ "$scope", "$http", "$filter", "$window", function(n, r) {
        n.options = {
            url: t
        };
        if (!e) {
            n.loadingFiles = !0;
            r.get(t).then(function(e) {
                n.loadingFiles = !1;
                n.queue = e.data.files || [];
            }, function() {
                n.loadingFiles = !1;
            });
        }
    } ]).controller("FileDestroyController", [ "$scope", "$http", function(e, t) {
        var n = e.file, r;
        if (n.url) {
            n.$state = function() {
                return r;
            };
            n.$destroy = function() {
                r = "pending";
                return t({
                    url: n.deleteUrl,
                    method: n.deleteType
                }).then(function() {
                    r = "resolved";
                    e.clear(n);
                }, function() {
                    r = "rejected";
                });
            };
        } else !n.$cancel && !n._index && (n.$cancel = function() {
            e.clear(n);
        });
    } ]);
})();
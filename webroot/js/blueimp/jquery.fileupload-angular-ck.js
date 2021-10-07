/*
 * jQuery File Upload AngularJS Plugin 1.4.5
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2013, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 *//*jslint nomen: true, unparam: true *//*global define, angular */(function(e) {
    "use strict";
    typeof define == "function" && define.amd ? define([ "jquery", "angular", "./jquery.fileupload-image", "./jquery.fileupload-audio", "./jquery.fileupload-video", "./jquery.fileupload-validate" ], e) : e();
})(function() {
    "use strict";
    angular.module("blueimp.fileupload", []).provider("fileUpload", function() {
        var e = function() {
            var e = angular.element(this).fileupload("option", "scope")(), t = angular.injector([ "ng" ]).get("$timeout");
            t(function() {
                e.$apply();
            });
        }, t;
        t = this.defaults = {
            handleResponse: function(e, t) {
                var n = t.result && t.result.files;
                if (n) t.scope().replace(t.files, n); else if (t.errorThrown || t.textStatus === "error") t.files[0].error = t.errorThrown || t.textStatus;
            },
            add: function(e, t) {
                var n = t.scope();
                t.process(function() {
                    return n.process(t);
                }).always(function() {
                    var e = t.files[0], r = function() {
                        return t.submit();
                    };
                    angular.forEach(t.files, function(e, n) {
                        e._index = n;
                        e.$state = function() {
                            return t.state();
                        };
                        e.$progress = function() {
                            return t.progress();
                        };
                        e.$response = function() {
                            return t.response();
                        };
                    });
                    e.$cancel = function() {
                        n.clear(t.files);
                        return t.abort();
                    };
                    e.$state() === "rejected" ? e._$submit = r : e.$submit = r;
                    n.$apply(function() {
                        var r = n.option("prependFiles") ? "unshift" : "push";
                        Array.prototype[r].apply(n.queue, t.files);
                        e.$submit && (n.option("autoUpload") || t.autoUpload) && t.autoUpload !== !1 && e.$submit();
                    });
                });
            },
            progress: function(e, t) {
                t.scope().$apply();
            },
            done: function(e, t) {
                var n = this;
                t.scope().$apply(function() {
                    t.handleResponse.call(n, e, t);
                });
            },
            fail: function(e, t) {
                var n = this;
                if (t.errorThrown === "abort") return;
                if (t.dataType && t.dataType.indexOf("json") === t.dataType.length - 4) try {
                    t.result = angular.fromJson(t.jqXHR.responseText);
                } catch (r) {}
                t.scope().$apply(function() {
                    t.handleResponse.call(n, e, t);
                });
            },
            stop: e,
            processstart: e,
            processstop: e,
            getNumberOfFiles: function() {
                return this.scope().queue.length;
            },
            dataType: "json",
            autoUpload: !1
        };
        this.$get = [ function() {
            return {
                defaults: t
            };
        } ];
    }).provider("formatFileSizeFilter", function() {
        var e = {
            units: [ {
                size: 1e9,
                suffix: " GB"
            }, {
                size: 1e6,
                suffix: " MB"
            }, {
                size: 1e3,
                suffix: " KB"
            } ]
        };
        this.defaults = e;
        this.$get = function() {
            return function(t) {
                if (!angular.isNumber(t)) return "";
                var n = !0, r = 0, i, s;
                while (n) {
                    n = e.units[r];
                    i = n.prefix || "";
                    s = n.suffix || "";
                    if (r === e.units.length - 1 || t >= n.size) return i + (t / n.size).toFixed(2) + s;
                    r += 1;
                }
            };
        };
    }).controller("FileUploadController", [ "$scope", "$element", "$attrs", "$window", "fileUpload", function(e, t, n, r, i) {
        var s = {
            progress: function() {
                return t.fileupload("progress");
            },
            active: function() {
                return t.fileupload("active");
            },
            option: function(e, n) {
                return t.fileupload("option", e, n);
            },
            add: function(e) {
                return t.fileupload("add", e);
            },
            send: function(e) {
                return t.fileupload("send", e);
            },
            process: function(e) {
                return t.fileupload("process", e);
            },
            processing: function(e) {
                return t.fileupload("processing", e);
            }
        };
        e.disabled = !r.jQuery.support.fileInput;
        e.queue = e.queue || [];
        e.clear = function(e) {
            var t = this.queue, n = t.length, r = e, i = 1;
            if (angular.isArray(e)) {
                r = e[0];
                i = e.length;
            }
            while (n) {
                n -= 1;
                if (t[n] === r) return t.splice(n, i);
            }
        };
        e.replace = function(e, t) {
            var n = this.queue, r = e[0], i, s;
            for (i = 0; i < n.length; i += 1) if (n[i] === r) {
                for (s = 0; s < t.length; s += 1) n[i + s] = t[s];
                return;
            }
        };
        e.applyOnQueue = function(e) {
            var t = this.queue.slice(0), n, r;
            for (n = 0; n < t.length; n += 1) {
                r = t[n];
                r[e] && r[e]();
            }
        };
        e.submit = function() {
            this.applyOnQueue("$submit");
        };
        e.cancel = function() {
            this.applyOnQueue("$cancel");
        };
        angular.extend(e, s);
        t.fileupload(angular.extend({
            scope: function() {
                return e;
            }
        }, i.defaults)).on("fileuploadadd", function(t, n) {
            n.scope = e.option("scope");
        }).on([ "fileuploadadd", "fileuploadsubmit", "fileuploadsend", "fileuploaddone", "fileuploadfail", "fileuploadalways", "fileuploadprogress", "fileuploadprogressall", "fileuploadstart", "fileuploadstop", "fileuploadchange", "fileuploadpaste", "fileuploaddrop", "fileuploaddragover", "fileuploadchunksend", "fileuploadchunkdone", "fileuploadchunkfail", "fileuploadchunkalways", "fileuploadprocessstart", "fileuploadprocess", "fileuploadprocessdone", "fileuploadprocessfail", "fileuploadprocessalways", "fileuploadprocessstop" ].join(" "), function(t, n) {
            e.$emit(t.type, n).defaultPrevented && t.preventDefault();
        }).on("remove", function() {
            var t;
            for (t in s) s.hasOwnProperty(t) && delete e[t];
        });
        e.$watch(n.fileUpload, function(e) {
            e && t.fileupload("option", e);
        });
    } ]).controller("FileUploadProgressController", [ "$scope", "$attrs", "$parse", function(e, t, n) {
        var r = n(t.fileUploadProgress), i = function() {
            var t = r(e);
            if (!t || !t.total) return;
            e.num = Math.floor(t.loaded / t.total * 100);
        };
        i();
        e.$watch(t.fileUploadProgress + ".loaded", function(e, t) {
            e !== t && i();
        });
    } ]).controller("FileUploadPreviewController", [ "$scope", "$element", "$attrs", "$parse", function(e, t, n, r) {
        var i = r(n.fileUploadPreview), s = i(e);
        s.preview && t.append(s.preview);
    } ]).directive("fileUpload", function() {
        return {
            controller: "FileUploadController",
            scope: !0
        };
    }).directive("fileUploadProgress", function() {
        return {
            controller: "FileUploadProgressController",
            scope: !0
        };
    }).directive("fileUploadPreview", function() {
        return {
            controller: "FileUploadPreviewController"
        };
    }).directive("download", function() {
        return function(e, t) {
            t.on("dragstart", function(e) {
                try {
                    e.originalEvent.dataTransfer.setData("DownloadURL", [ "application/octet-stream", t.prop("download"), t.prop("href") ].join(":"));
                } catch (n) {}
            });
        };
    });
});
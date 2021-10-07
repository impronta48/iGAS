/*
 * jQuery File Upload jQuery UI Plugin 8.7.0
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2013, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 *//*jslint nomen: true, unparam: true *//*global define, window */(function(e) {
    "use strict";
    typeof define == "function" && define.amd ? define([ "jquery", "./jquery.fileupload-ui" ], e) : e(window.jQuery);
})(function(e) {
    "use strict";
    e.widget("blueimp.fileupload", e.blueimp.fileupload, {
        options: {
            progress: function(e, t) {
                t.context && t.context.find(".progress").progressbar("option", "value", parseInt(t.loaded / t.total * 100, 10));
            },
            progressall: function(t, n) {
                var r = e(this);
                r.find(".fileupload-progress").find(".progress").progressbar("option", "value", parseInt(n.loaded / n.total * 100, 10)).end().find(".progress-extended").each(function() {
                    e(this).html((r.data("blueimp-fileupload") || r.data("fileupload"))._renderExtendedProgress(n));
                });
            }
        },
        _renderUpload: function(t, n) {
            var r = this._super(t, n), i = e(window).width() > 480;
            r.find(".progress").empty().progressbar();
            r.find(".start").button({
                icons: {
                    primary: "ui-icon-circle-arrow-e"
                },
                text: i
            });
            r.find(".cancel").button({
                icons: {
                    primary: "ui-icon-cancel"
                },
                text: i
            });
            return r;
        },
        _renderDownload: function(t, n) {
            var r = this._super(t, n), i = e(window).width() > 480;
            r.find(".delete").button({
                icons: {
                    primary: "ui-icon-trash"
                },
                text: i
            });
            return r;
        },
        _transition: function(t) {
            var n = e.Deferred();
            t.hasClass("fade") ? t.fadeToggle(this.options.transitionDuration, this.options.transitionEasing, function() {
                n.resolveWith(t);
            }) : n.resolveWith(t);
            return n;
        },
        _create: function() {
            this._super();
            this.element.find(".fileupload-buttonbar").find(".fileinput-button").each(function() {
                var t = e(this).find("input:file").detach();
                e(this).button({
                    icons: {
                        primary: "ui-icon-plusthick"
                    }
                }).append(t);
            }).end().find(".start").button({
                icons: {
                    primary: "ui-icon-circle-arrow-e"
                }
            }).end().find(".cancel").button({
                icons: {
                    primary: "ui-icon-cancel"
                }
            }).end().find(".delete").button({
                icons: {
                    primary: "ui-icon-trash"
                }
            }).end().find(".progress").progressbar();
        },
        _destroy: function() {
            this.element.find(".fileupload-buttonbar").find(".fileinput-button").each(function() {
                var t = e(this).find("input:file").detach();
                e(this).button("destroy").append(t);
            }).end().find(".start").button("destroy").end().find(".cancel").button("destroy").end().find(".delete").button("destroy").end().find(".progress").progressbar("destroy");
            this._super();
        }
    });
});
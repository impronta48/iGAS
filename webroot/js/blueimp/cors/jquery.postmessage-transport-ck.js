/*
 * jQuery postMessage Transport Plugin 1.1.1
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2011, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 *//*jslint unparam: true, nomen: true *//*global define, window, document */(function(e) {
    "use strict";
    typeof define == "function" && define.amd ? define([ "jquery" ], e) : e(window.jQuery);
})(function(e) {
    "use strict";
    var t = 0, n = [ "accepts", "cache", "contents", "contentType", "crossDomain", "data", "dataType", "headers", "ifModified", "mimeType", "password", "processData", "timeout", "traditional", "type", "url", "username" ], r = function(e) {
        return e;
    };
    e.ajaxSetup({
        converters: {
            "postmessage text": r,
            "postmessage json": r,
            "postmessage html": r
        }
    });
    e.ajaxTransport("postmessage", function(r) {
        if (r.postMessage && window.postMessage) {
            var i, s = e("<a>").prop("href", r.postMessage)[0], o = s.protocol + "//" + s.host, u = r.xhr().upload;
            return {
                send: function(s, a) {
                    t += 1;
                    var f = {
                        id: "postmessage-transport-" + t
                    }, l = "message." + f.id;
                    i = e('<iframe style="display:none;" src="' + r.postMessage + '" name="' + f.id + '"></iframe>').bind("load", function() {
                        e.each(n, function(e, t) {
                            f[t] = r[t];
                        });
                        f.dataType = f.dataType.replace("postmessage ", "");
                        e(window).bind(l, function(t) {
                            t = t.originalEvent;
                            var n = t.data, r;
                            if (t.origin === o && n.id === f.id) if (n.type === "progress") {
                                r = document.createEvent("Event");
                                r.initEvent(n.type, !1, !0);
                                e.extend(r, n);
                                u.dispatchEvent(r);
                            } else {
                                a(n.status, n.statusText, {
                                    postmessage: n.result
                                }, n.headers);
                                i.remove();
                                e(window).unbind(l);
                            }
                        });
                        i[0].contentWindow.postMessage(f, o);
                    }).appendTo(document.body);
                },
                abort: function() {
                    i && i.remove();
                }
            };
        }
    });
});
/*
 * jQuery File Upload Video Preview Plugin 1.0.3
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2013, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 *//*jslint nomen: true, unparam: true, regexp: true *//*global define, window, document */(function(e) {
    "use strict";
    typeof define == "function" && define.amd ? define([ "jquery", "load-image", "./jquery.fileupload-process" ], e) : e(window.jQuery, window.loadImage);
})(function(e, t) {
    "use strict";
    e.blueimp.fileupload.prototype.options.processQueue.unshift({
        action: "loadVideo",
        prefix: !0,
        fileTypes: "@",
        maxFileSize: "@",
        disabled: "@disableVideoPreview"
    }, {
        action: "setVideo",
        name: "@videoPreviewName",
        disabled: "@disableVideoPreview"
    });
    e.widget("blueimp.fileupload", e.blueimp.fileupload, {
        options: {
            loadVideoFileTypes: /^video\/.*$/
        },
        _videoElement: document.createElement("video"),
        processActions: {
            loadVideo: function(n, r) {
                if (r.disabled) return n;
                var i = n.files[n.index], s, o;
                if (this._videoElement.canPlayType && this._videoElement.canPlayType(i.type) && (e.type(r.maxFileSize) !== "number" || i.size <= r.maxFileSize) && (!r.fileTypes || r.fileTypes.test(i.type))) {
                    s = t.createObjectURL(i);
                    if (s) {
                        o = this._videoElement.cloneNode(!1);
                        o.src = s;
                        o.controls = !0;
                        n.video = o;
                        return n;
                    }
                }
                return n;
            },
            setVideo: function(e, t) {
                e.video && !t.disabled && (e.files[e.index][t.name || "preview"] = e.video);
                return e;
            }
        }
    });
});
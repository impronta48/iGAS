/*
 * jQuery File Upload Image Preview & Resize Plugin 1.3.0
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2013, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 *//*jslint nomen: true, unparam: true, regexp: true *//*global define, window, document, DataView, Blob, Uint8Array */(function(e) {
    "use strict";
    typeof define == "function" && define.amd ? define([ "jquery", "load-image", "load-image-meta", "load-image-exif", "load-image-ios", "canvas-to-blob", "./jquery.fileupload-process" ], e) : e(window.jQuery, window.loadImage);
})(function(e, t) {
    "use strict";
    e.blueimp.fileupload.prototype.options.processQueue.unshift({
        action: "loadImageMetaData",
        disableImageHead: "@",
        disableExif: "@",
        disableExifThumbnail: "@",
        disableExifSub: "@",
        disableExifGps: "@",
        disabled: "@disableImageMetaDataLoad"
    }, {
        action: "loadImage",
        prefix: !0,
        fileTypes: "@",
        maxFileSize: "@",
        noRevoke: "@",
        disabled: "@disableImageLoad"
    }, {
        action: "resizeImage",
        prefix: "image",
        maxWidth: "@",
        maxHeight: "@",
        minWidth: "@",
        minHeight: "@",
        crop: "@",
        orientation: "@",
        disabled: "@disableImageResize"
    }, {
        action: "saveImage",
        disabled: "@disableImageResize"
    }, {
        action: "saveImageMetaData",
        disabled: "@disableImageMetaDataSave"
    }, {
        action: "resizeImage",
        prefix: "preview",
        maxWidth: "@",
        maxHeight: "@",
        minWidth: "@",
        minHeight: "@",
        crop: "@",
        orientation: "@",
        thumbnail: "@",
        canvas: "@",
        disabled: "@disableImagePreview"
    }, {
        action: "setImage",
        name: "@imagePreviewName",
        disabled: "@disableImagePreview"
    });
    e.widget("blueimp.fileupload", e.blueimp.fileupload, {
        options: {
            loadImageFileTypes: /^image\/(gif|jpeg|png)$/,
            loadImageMaxFileSize: 1e7,
            imageMaxWidth: 1920,
            imageMaxHeight: 1080,
            imageOrientation: !1,
            imageCrop: !1,
            disableImageResize: !0,
            previewMaxWidth: 80,
            previewMaxHeight: 80,
            previewOrientation: !0,
            previewThumbnail: !0,
            previewCrop: !1,
            previewCanvas: !0
        },
        processActions: {
            loadImage: function(n, r) {
                if (r.disabled) return n;
                var i = this, s = n.files[n.index], o = e.Deferred();
                return e.type(r.maxFileSize) === "number" && s.size > r.maxFileSize || r.fileTypes && !r.fileTypes.test(s.type) || !t(s, function(e) {
                    e.src && (n.img = e);
                    o.resolveWith(i, [ n ]);
                }, r) ? n : o.promise();
            },
            resizeImage: function(n, r) {
                if (r.disabled) return n;
                r = e.extend({
                    canvas: !0
                }, r);
                var i = this, s = e.Deferred(), o = r.canvas && n.canvas || n.img, u = function(e) {
                    e && (e.width !== o.width || e.height !== o.height) && (n[e.getContext ? "canvas" : "img"] = e);
                    n.preview = e;
                    s.resolveWith(i, [ n ]);
                }, a;
                if (n.exif) {
                    r.orientation === !0 && (r.orientation = n.exif.get("Orientation"));
                    if (r.thumbnail) {
                        a = n.exif.get("Thumbnail");
                        if (a) {
                            t(a, u, r);
                            return s.promise();
                        }
                    }
                }
                if (o) {
                    u(t.scale(o, r));
                    return s.promise();
                }
                return n;
            },
            saveImage: function(t, n) {
                if (!t.canvas || n.disabled) return t;
                var r = this, i = t.files[t.index], s = i.name, o = e.Deferred(), u = function(e) {
                    e.name || (i.type === e.type ? e.name = i.name : i.name && (e.name = i.name.replace(/\..+$/, "." + e.type.substr(6))));
                    t.files[t.index] = e;
                    o.resolveWith(r, [ t ]);
                };
                if (t.canvas.mozGetAsFile) u(t.canvas.mozGetAsFile(/^image\/(jpeg|png)$/.test(i.type) && s || (s && s.replace(/\..+$/, "") || "blob") + ".png", i.type)); else {
                    if (!t.canvas.toBlob) return t;
                    t.canvas.toBlob(u, i.type);
                }
                return o.promise();
            },
            loadImageMetaData: function(n, r) {
                if (r.disabled) return n;
                var i = this, s = e.Deferred();
                t.parseMetaData(n.files[n.index], function(t) {
                    e.extend(n, t);
                    s.resolveWith(i, [ n ]);
                }, r);
                return s.promise();
            },
            saveImageMetaData: function(e, t) {
                if (!(e.imageHead && e.canvas && e.canvas.toBlob && !t.disabled)) return e;
                var n = e.files[e.index], r = new Blob([ e.imageHead, this._blobSlice.call(n, 20) ], {
                    type: n.type
                });
                r.name = n.name;
                e.files[e.index] = r;
                return e;
            },
            setImage: function(e, t) {
                e.preview && !t.disabled && (e.files[e.index][t.name || "preview"] = e.preview);
                return e;
            }
        }
    });
});
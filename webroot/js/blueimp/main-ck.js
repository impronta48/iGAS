/*
 * jQuery File Upload Plugin JS Example 8.8.2
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 *//*jslint nomen: true, regexp: true *//*global $, window, blueimp */$(function() {
    "use strict";
    $("#fileupload").fileupload({
        url: "server/php/"
    });
    $("#fileupload").fileupload("option", "redirect", window.location.href.replace(/\/[^\/]*$/, "/cors/result.html?%s"));
    if (window.location.hostname === "blueimp.github.io") {
        $("#fileupload").fileupload("option", {
            url: "//jquery-file-upload.appspot.com/",
            disableImageResize: /Android(?!.*Chrome)|Opera/.test(window.navigator.userAgent),
            maxFileSize: 5e6,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i
        });
        $.support.cors && $.ajax({
            url: "//jquery-file-upload.appspot.com/",
            type: "HEAD"
        }).fail(function() {
            $('<div class="alert alert-danger"/>').text("Upload server currently unavailable - " + new Date).appendTo("#fileupload");
        });
    } else {
        $("#fileupload").addClass("fileupload-processing");
        $.ajax({
            url: $("#fileupload").fileupload("option", "url"),
            dataType: "json",
            context: $("#fileupload")[0]
        }).always(function() {
            $(this).removeClass("fileupload-processing");
        }).done(function(e) {
            $(this).fileupload("option", "done").call(this, null, {
                result: e
            });
        });
    }
});
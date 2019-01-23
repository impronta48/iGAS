function generate(e, t) {
    var n = noty({
        text: e,
        type: t,
        dismissQueue: !0,
        layout: e,
        theme: "defaultTheme"
    });
}

function generateConfirm(e) {
    var t = noty({
        text: "Do you want to continue?",
        type: "alert",
        dismissQueue: !0,
        layout: e,
        theme: "defaultTheme",
        buttons: [ {
            addClass: "btn btn-primary",
            text: "Ok",
            onClick: function(t) {
                t.close();
                noty({
                    dismissQueue: !0,
                    force: !0,
                    layout: e,
                    theme: "defaultTheme",
                    text: 'You clicked "Ok" button',
                    type: "success"
                });
            }
        }, {
            addClass: "btn btn-danger",
            text: "Cancel",
            onClick: function(t) {
                t.close();
                noty({
                    dismissQueue: !0,
                    force: !0,
                    layout: e,
                    theme: "defaultTheme",
                    text: 'You clicked "Cancel" button',
                    type: "error"
                });
            }
        } ]
    });
}

function generateAll() {
    generate("top", "alert");
    generate("topCenter", "alert");
    generate("topLeft", "alert");
    generate("topRight", "alert");
    generate("center", "alert");
    generate("centerLeft", "alert");
    generate("centerRight", "alert");
    generate("bottom", "alert");
    generate("bottomCenter", "alert");
    generate("bottomLeft", "alert");
    generate("bottomRight", "alert");
}

$(document).ready(function() {
    $("a[data-layout]").click(function(e) {
        e.preventDefault();
        var t = $(this).attr("data-layout"), n = $(this).attr("data-type");
        n == "confirm" ? generateConfirm(t, n) : generate(t, n);
    });
    $(".btn-launch-all").click(function(e) {
        e.preventDefault();
        generateAll();
    });
});

$(function() {
    $(".colorGritter").click(function() {
        $.gritter.add({
            title: "Howdy!!",
            text: "Please check all the features and make sure you use search box to search your favourite pages.",
            image: "images/avatar.png",
            sticky: !0,
            class_name: $(this).data("color")
        });
        return !1;
    });
    $("#add-sticky").click(function() {
        var e = $.gritter.add({
            title: "This is a sticky notice!",
            text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus eget tincidunt velit. Cum sociis natoque penatibus et <a href="#" style="color:#ccc">magnis dis parturient</a> montes, nascetur ridiculus mus.',
            image: "images/avatar.png",
            sticky: !0,
            time: "",
            class_name: "my-sticky-class"
        });
        return !1;
    });
    $("#add-regular").click(function() {
        $.gritter.add({
            title: "This is a regular notice!",
            text: 'This will fade out after a certain amount of time. Vivamus eget tincidunt velit. Cum sociis natoque penatibus et <a href="#" style="color:#ccc">magnis dis parturient</a> montes, nascetur ridiculus mus.',
            image: "images/avatar.png",
            sticky: !1,
            time: ""
        });
        return !1;
    });
    $("#add-max").click(function() {
        $.gritter.add({
            title: "This is a notice with a max of 3 on screen at one time!",
            text: 'This will fade out after a certain amount of time. Vivamus eget tincidunt velit. Cum sociis natoque penatibus et <a href="#" style="color:#ccc">magnis dis parturient</a> montes, nascetur ridiculus mus.',
            image: "images/avatar.png",
            sticky: !1,
            before_open: function() {
                if ($(".gritter-item-wrapper").length == 3) return !1;
            }
        });
        return !1;
    });
    $("#add-without-image").click(function() {
        $.gritter.add({
            title: "This is a notice without an image!",
            text: 'This will fade out after a certain amount of time. Vivamus eget tincidunt velit. Cum sociis natoque penatibus et <a href="#" style="color:#ccc">magnis dis parturient</a> montes, nascetur ridiculus mus.'
        });
        return !1;
    });
    $("#add-gritter-light").click(function() {
        $.gritter.add({
            title: "This is a light notification",
            text: 'Just add a "gritter-light" class_name to your $.gritter.add or globally to $.gritter.options.class_name',
            class_name: "gritter-light"
        });
        return !1;
    });
    $("#add-with-callbacks").click(function() {
        $.gritter.add({
            title: "This is a notice with callbacks!",
            text: "The callback is...",
            before_open: function() {
                alert("I am called before it opens");
            },
            after_open: function(e) {
                alert("I am called after it opens: \nI am passed the jQuery object for the created Gritter element...\n" + e);
            },
            before_close: function(e, t) {
                var n = t ? 'The "X" was clicked to close me!' : "";
                alert("I am called before it closes: I am passed the jQuery object for the Gritter element... \n" + n);
            },
            after_close: function(e, t) {
                var n = t ? 'The "X" was clicked to close me!' : "";
                alert("I am called after it closes. " + n);
            }
        });
        return !1;
    });
    $("#add-sticky-with-callbacks").click(function() {
        $.gritter.add({
            title: "This is a sticky notice with callbacks!",
            text: "Sticky sticky notice.. sticky sticky notice...",
            sticky: !0,
            before_open: function() {
                alert("I am a sticky called before it opens");
            },
            after_open: function(e) {
                alert("I am a sticky called after it opens: \nI am passed the jQuery object for the created Gritter element...\n" + e);
            },
            before_close: function(e) {
                alert("I am a sticky called before it closes: I am passed the jQuery object for the Gritter element... \n" + e);
            },
            after_close: function() {
                alert("I am a sticky called after it closes");
            }
        });
        return !1;
    });
    $("#remove-all").click(function() {
        $.gritter.removeAll();
        return !1;
    });
    $("#remove-all-with-callbacks").click(function() {
        $.gritter.removeAll({
            before_close: function(e) {
                alert("I am called before all notifications are closed.  I am passed the jQuery object containing all  of Gritter notifications.\n" + e);
            },
            after_close: function() {
                alert("I am called after everything has been closed.");
            }
        });
        return !1;
    });
});

$(function() {
    $("button#noti").click(function() {
        $.desknoty({
            icon: "images/profiles/eleven.png",
            title: "Welcome to Cascade Admin Template",
            body: "Woooo this is awesome right? Check back all features"
        });
    });
});
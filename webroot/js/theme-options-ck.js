function applyLess() {
    if ($("#lessCss").attr("rel") == "stylesheet") {
        $("#lessCss").attr("rel", "stylesheet/less");
        less.sheets.push($("link[title=lessCss]")[0]);
        less.refresh();
    }
}

$(document).ready(function() {
    $("#colr").colorpicker().on("changeColor", function(e) {
        var t = e.color.toHex();
        $("#primaryColor").val(t);
        $(this).find("i").css("background-color", e.color.toHex());
        applyLess();
        less.modifyVars({
            "@primary": e.color.toHex(),
            "@leftSidebarBackground": $("#secondaryColor").val(),
            "@leftSidebarLinkColor": $("#linkColor").val(),
            "@rightSidebarBackground": $("#rightsidebarColor").val()
        });
    });
    $("#Scolr").colorpicker().on("changeColor", function(e) {
        var t = e.color.toHex();
        $("#secondaryColor").val(t);
        $(this).find("i").css("background-color", e.color.toHex());
        applyLess();
        less.modifyVars({
            "@primary": $("#primaryColor").val(),
            "@leftSidebarBackground": e.color.toHex(),
            "@leftSidebarLinkColor": $("#linkColor").val(),
            "@rightSidebarBackground": $("#rightsidebarColor").val()
        });
    });
    $("#Rcolr").colorpicker().on("changeColor", function(e) {
        var t = e.color.toHex();
        $("#rightsidebarColor").val(t);
        $(this).find("i").css("background-color", e.color.toHex());
        applyLess();
        less.modifyVars({
            "@primary": $("#primaryColor").val(),
            "@leftSidebarBackground": $("#secondaryColor").val(),
            "@leftSidebarLinkColor": $("#linkColor").val(),
            "@rightSidebarBackground": e.color.toHex()
        });
    });
    $("#Lcolr").colorpicker().on("changeColor", function(e) {
        var t = e.color.toHex();
        $("#linkColor").val(t);
        $(this).find("i").css("background-color", e.color.toHex());
        applyLess();
        less.modifyVars({
            "@primary": $("#primaryColor").val(),
            "@leftSidebarBackground": $("#secondaryColor").val(),
            "@leftSidebarLinkColor": e.color.toHex(),
            "@rightSidebarBackground": $("#rightsidebarColor").val()
        });
    });
    $("#fixedNavbar").click(function() {
        $(".navbar").toggleClass("navbar-fixed-top");
        $(".content").toggleClass("navbar-fixed");
        $(".site-holder").removeClass("container");
        $(".navbar").removeClass("navbar-fixed-bottom");
        $(".content").removeClass("navbar-fixedBottom");
        $(".navbar-collapse").removeClass("btn-group");
        $(".backgroundImage").addClass("hidden");
        $(".navbar-collapse").removeClass("dropup");
        $("#fixedNavbarBottom").attr("checked", !1);
        $(".hidden-minibar").removeClass("hide");
        $(".site-holder").removeClass("mini-sidebar");
        $("#boxed").attr("checked", !1);
    });
    $("#fixedNavbarBottom").click(function() {
        $(".navbar").toggleClass("navbar-fixed-bottom");
        $(".content").toggleClass("navbar-fixedBottom");
        $(".navbar").removeClass("navbar-fixed-top");
        $(".content").removeClass("navbar-fixed");
        $(".navbar-collapse").toggleClass("btn-group");
        $(".navbar-collapse").toggleClass("dropup");
        $(".site-holder").removeClass("container");
        $(".backgroundImage").addClass("hidden");
        $("#boxed").attr("checked", !1);
        $("#fixedNavbar").attr("checked", !1);
        $(".hidden-minibar").removeClass("hide");
        $(".site-holder").removeClass("mini-sidebar");
    });
    $("#boxed").click(function() {
        $(".site-holder").toggleClass("container");
        $(".navbar").removeClass("navbar-fixed-top");
        $(".content").removeClass("navbar-fixed");
        $("#fixedNavbar").attr("checked", !1);
        $(".navbar").removeClass("navbar-fixed-bottom");
        $(".content").removeClass("navbar-fixedBottom");
        $(".navbar-collapse").removeClass("btn-group");
        $(".navbar-collapse").removeClass("dropup");
        $("#fixedNavbarBottom").attr("checked", !1);
        $(".hidden-minibar").toggleClass("hide");
        $(".site-holder").toggleClass("mini-sidebar");
        $(".backgroundImage").toggleClass("hidden");
        if ($(".site-holder").hasClass("mini-sidebar")) {
            $(".sidebar-holder").tooltip({
                selector: "a",
                container: "body",
                placement: "right"
            });
            $("li.submenu ul").tooltip("destroy");
        } else $(".sidebar-holder").tooltip("destroy");
    });
    document.getElementById("backgroundImageUrl").onkeypress = function(e) {
        var t = e || window.event, n = t.which || t.keyCode;
        if (n == "13") {
            var r = $("#backgroundImageUrl").val();
            applyLess();
            less.modifyVars({
                "@boxedBackgroundImage": '"' + r + '"'
            });
        }
    };
    $(".theme-panel-close").click(function() {
        $(this).parent().fadeOut();
        $(".theme-options").fadeOut();
    });
    $("#responsive").click(function() {
        $("link[title=responsiveSheet]")[0].disabled = !0;
        $(".btn-nav-toggle-responsive").css("display", "none");
        $(".site-holder").toggleClass("site-nonresponsive");
    });
    $(".predefined-themes li a").click(function() {
        var e = $(this).data("color-primary"), t = $(this).data("color-secondary"), n = $(this).data("color-link");
        applyLess();
        less.modifyVars({
            "@primary": e,
            "@leftSidebarBackground": t,
            "@leftSidebarLinkColor": n
        });
    });
});
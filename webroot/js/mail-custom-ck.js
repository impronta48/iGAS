// jQuery $('document').ready(); function 
function add_event(e) {
    $(".inbox-labels").append('<a class="list-group-item"  href="#"><span class="badge pull-right">&nbsp;</span>' + e + "</a>");
    $("#write-label").val("");
}

$("document").ready(function() {
    $(".inbox-options a,.inbox-labels a").click(function() {
        $(".inbox-options a,.inbox-labels a").removeClass("active");
        $(this).addClass("active");
        var e = $(this).html();
        $("h3.page-header").html(e);
    });
    $(".mail-right-box .mails table tr td i").click(function() {
        $(this).toggleClass("active");
    });
    $(".mail-right-box .mails table tr td i.fa-square-o").click(function() {
        $(this).toggleClass("fa-square-o");
        $(this).parent().parent().toggleClass("active");
    });
    $(".mails").niceScroll({
        cursorcolor: "#54728c"
    });
    $("#create-label").click(function() {
        var e = $("#write-label").val();
        add_event(e);
    });
    document.getElementById("write-label").onkeypress = function(e) {
        var t = e || window.event, n = t.which || t.keyCode;
        if (n == "13") {
            var r = $("#write-label").val();
            add_event(r);
        }
    };
    $(".mail-right-box .mails table tr td.body").click(function(e) {
        e.preventDefault();
        var t = $(this).parent().find("td.subject").html();
        $(".modal-title").html(t);
        var n = $(this).html();
        $(".modal-body").html(n);
        $("#myModal").modal("show");
    });
});
//This code is for only demo site, you dont need to include in production
function testAnim(e) {
    $("#animateTest").removeClass().addClass(e + " animated");
    var t = window.setTimeout(function() {
        $("#animateTest").removeClass();
    }, 1300);
}

$(function() {
    $pos = $(".btn-animate").offset().top - 0;
    $(window).on("scroll", function() {
        $(window).scrollTop() >= $pos ? $(".btn-animate").addClass("fixed") : $(".btn-animate").removeClass("fixed");
    });
});

$(document).ready(function() {
    $(".animate-list a").click(function() {
        $(".animate-list a").removeClass("active");
        $(this).addClass("active");
        var e = $(this).attr("data-test");
        testAnim(e);
    });
});
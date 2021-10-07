$(document).ready(function() {
    $(".text-fill  .progress-bar").progressbar({
        display_text: "fill"
    });
    $(".text-fill-no-percent  .progress-bar").progressbar({
        display_text: "fill",
        use_percentage: !1
    });
    $(".text-fill-center  .progress-bar").progressbar({
        display_text: "center",
        use_percentage: !1
    });
    $("#transition-delay").click(function() {
        $(".transition-delay .progress-bar").progressbar({
            transition_delay: 3e3
        });
    });
    $(".panel-cascade").hover(function() {
        $(this).find(".progress .progress-bar").progressbar();
    });
});
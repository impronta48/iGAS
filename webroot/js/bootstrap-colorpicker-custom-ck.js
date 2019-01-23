$(function() {
    var e = function() {
        $("#cp1").colorpicker({
            format: "hex"
        });
        $("#cp2").colorpicker();
        $("#cp3").colorpicker();
        $("#cp4").colorpicker();
    };
    e();
    $(".bscp-destroy").click(function(e) {
        e.preventDefault();
        $(".bscp").colorpicker("destroy");
    });
    $(".bscp-create").click(function(t) {
        t.preventDefault();
        e();
    });
});
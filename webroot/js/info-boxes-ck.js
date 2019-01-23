$(function() {
    var e = [ 10, 8, 5, 7, 4, 6, 7, 1, 3, 5, 9, 4, 4, 1 ];
    $(".mini-graph.success").sparkline(e, {
        type: "bar",
        barColor: "white",
        lineColor: "black",
        height: "40"
    });
    $(".inlinesparkline").sparkline();
    var e = [ 10, 8, 5, 3, 5, 7, 4, 6, 7, 1, 9, 4, 4, 1 ];
    $(".mini-graph.pie").sparkline(e, {
        type: "pie",
        barColor: "white",
        height: "40"
    });
    var e = [ 10, 8, 5, 7, 4, 3, 5, 9, 4, 4, 1 ];
    $(".mini-graph.info").sparkline(e, {
        type: "bar",
        barColor: "white",
        height: "40"
    });
    var e = [ 10, 8, 5, 7, 4, 6, 7, 1, 3, 5, 9, 4, 4, 1 ];
    $(".mini-graph.danger").sparkline(e, {
        type: "bar",
        barColor: "white",
        height: "40"
    });
});
$(function() {
    var e = [ 10, 8, 5, 7, 4, 6, 7, 1, 3, 5, 9, 4, 4, 1 ];
    $(".mini-graph.success").sparkline(e, {
        type: "bar",
        barColor: "#90c657",
        lineColor: "black",
        height: "40"
    });
    $(".inlinesparkline").sparkline();
    var e = [ 10, 8, 5, 3, 5, 7, 4, 6, 7, 1, 9, 4, 4, 1 ];
    $(".mini-graph.pie").sparkline(e, {
        type: "pie",
        barColor: "#54728c",
        height: "40"
    });
    var e = [ 10, 8, 5, 7, 4, 3, 5, 9, 4, 4, 1 ];
    $(".mini-graph.info").sparkline(e, {
        type: "bar",
        barColor: "#54b5df",
        height: "40"
    });
    var e = [ 10, 8, 5, 7, 4, 6, 7, 1, 3, 5, 9, 4, 4, 1 ];
    $(".mini-graph.danger").sparkline(e, {
        type: "bar",
        barColor: "#e45857",
        height: "40"
    });
    $(".mini-graph.success-size").sparkline(e, {
        type: "bar",
        barColor: "#90c657",
        lineColor: "black",
        height: "150",
        width: "150"
    });
    $(".inlinesparkline").sparkline();
    $(".mini-graph.info-size").sparkline(e, {
        type: "bar",
        barColor: "#54728c",
        lineColor: "black",
        height: "150",
        width: "150"
    });
    $(".mini-graph.danger-size").sparkline(e, {
        type: "bar",
        barColor: "#54b5df",
        lineColor: "black",
        height: "150",
        width: "150"
    });
    $(".mini-graph.pie-size").sparkline(e, {
        type: "pie",
        barColor: "#e45857",
        lineColor: "black",
        height: "150",
        width: "150"
    });
});
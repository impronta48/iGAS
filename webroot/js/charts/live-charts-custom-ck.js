//Morris Live Updating Chart
function dataM(e) {
    var t = [];
    for (var n = 0; n <= 360; n += 10) {
        var r = (e + n) % 360;
        t.push({
            x: n,
            y: Math.sin(Math.PI * r / 180).toFixed(4),
            z: Math.cos(Math.PI * r / 180).toFixed(4)
        });
    }
    return t;
}

function update() {
    nReloads++;
    graph.setData(dataM(5 * nReloads));
    $("#reloadStatus").text(nReloads + " Reloads");
}

var nReloads = 0, graph = Morris.Line({
    element: "liveGraph",
    dataM: dataM(0),
    xkey: "x",
    ykeys: [ "y", "z" ],
    labels: [ "sin()", "cos()" ],
    parseTime: !1,
    ymin: -1,
    ymax: 1,
    hideHover: !0
});

setInterval(update, 1e3);

var chart, data = [ {
    key: "Stream 1",
    color: "orange",
    values: [ {
        x: 1,
        y: 1
    } ]
} ];

nv.addGraph(function() {
    chart = nv.models.historicalBarChart();
    chart.x(function(e, t) {
        return e.x;
    });
    chart.xAxis.tickFormat(d3.format(",.1f")).axisLabel("Time");
    chart.yAxis.axisLabel("Random Number").tickFormat(d3.format(",.4f"));
    chart.showXAxis(!0).showYAxis(!0).rightAlignYAxis(!0).margin({
        right: 90
    });
    d3.select("#nvdLive svg").datum(data).transition().duration(500).call(chart);
    nv.utils.windowResize(chart.update);
    return chart;
});

var x = 2, run = !0;

setInterval(function() {
    if (!run) return;
    var e = Math.random() > .95 ? 10 : 1;
    data[0].values.push({
        x: x,
        y: Math.random() * e
    });
    data[0].values.length > 70 && data[0].values.shift();
    x++;
    chart.update();
}, 500);

d3.select("#start-stop-button").on("click", function() {
    $(this).hasClass("btn-danger") ? $(this).removeClass("btn-danger").addClass("btn-success").html("Start Live Stream") : $(this).removeClass("btn-success").addClass("btn-danger").html("Stop Live Stream");
    run = !run;
});

$(function() {
    function n() {
        e.length > 0 && (e = e.slice(1));
        while (e.length < t) {
            var n = e.length > 0 ? e[e.length - 1] : 50, r = n + Math.random() * 10 - 5;
            r < 0 ? r = 0 : r > 100 && (r = 100);
            e.push(r);
        }
        var i = [];
        for (var s = 0; s < e.length; ++s) i.push([ s, e[s] ]);
        return i;
    }
    function s() {
        i.setData([ n() ]);
        i.draw();
        setTimeout(s, r);
    }
    var e = [], t = 300, r = 30;
    $("#updateInterval").val(r).change(function() {
        var e = $(this).val();
        if (e && !isNaN(+e)) {
            r = +e;
            r < 1 ? r = 1 : r > 2e3 && (r = 2e3);
            $(this).val("" + r);
        }
    });
    var i = $.plot("#placeholder", [ n() ], {
        series: {
            shadowSize: 0
        },
        yaxis: {
            min: 0,
            max: 100
        },
        xaxis: {
            show: !1
        }
    });
    s();
});
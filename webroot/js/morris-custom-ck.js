// First Donut chart on Dashboard
function data(e) {
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
    graph.setData(data(5 * nReloads));
    var e = 1 + Math.floor(Math.random() * 200);
    $("#reloadStatus").text(e);
}

Morris.Donut({
    element: "donut",
    data: [ {
        value: 70,
        label: "foo"
    }, {
        value: 15,
        label: "bar"
    }, {
        value: 10,
        label: "baz"
    }, {
        value: 5,
        label: "A really really long label"
    } ],
    formatter: function(e) {
        return e + "%";
    }
}).on("click", function(e, t) {
    console.log(e, t);
});

Morris.Donut({
    element: "coloredDonut",
    data: [ {
        value: 15,
        label: "Success"
    }, {
        value: 60,
        label: "Primary"
    }, {
        value: 10,
        label: "Info"
    }, {
        value: 10,
        label: "Warning"
    }, {
        value: 5,
        label: "A really really long Danger"
    } ],
    labelColor: "#54728c",
    colors: [ "#90c657", "#54728c", "#54b5df", "#f9a94a", "#e45857" ],
    formatter: function(e) {
        return e + "%";
    }
});

var nReloads = 0, graph = Morris.Line({
    element: "liveGraph",
    data: data(0),
    xkey: "x",
    ykeys: [ "y", "z" ],
    labels: [ "sin()", "cos()" ],
    parseTime: !1,
    ymin: -1,
    ymax: 1,
    hideHover: !0
}), day_data = [ {
    period: "2012-10-01",
    licensed: 3407,
    sorned: 660
}, {
    period: "2012-09-30",
    licensed: 2351,
    sorned: 629
}, {
    period: "2012-09-29",
    licensed: 4269,
    sorned: 618
}, {
    period: "2012-09-20",
    licensed: 2846,
    sorned: 661
}, {
    period: "2012-09-19",
    licensed: 3957,
    sorned: 667
}, {
    period: "2012-09-18",
    licensed: 1548,
    sorned: 627
} ];

Morris.Bar({
    element: "visitors",
    data: day_data,
    xkey: "period",
    ykeys: [ "licensed", "sorned" ],
    labels: [ "Vistors", "Unique" ],
    xLabelAngle: 60
});
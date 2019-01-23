//Discrete Bar chart
historicalBarChart = [ {
    key: "Cumulative Return",
    values: [ {
        label: "A",
        value: 29.765957771107
    }, {
        label: "B",
        value: 0
    }, {
        label: "C",
        value: 32.807804682612
    }, {
        label: "D",
        value: 196.45946739256
    }, {
        label: "E",
        value: .19434030906893
    }, {
        label: "F",
        value: 98.079782601442
    }, {
        label: "G",
        value: 13.925743130903
    }, {
        label: "H",
        value: 5.1387322875705
    } ]
} ];

nv.addGraph(function() {
    var e = nv.models.discreteBarChart().x(function(e) {
        return e.label;
    }).y(function(e) {
        return e.value;
    }).staggerLabels(!0).tooltips(!1).showValues(!0).transitionDuration(250);
    d3.select("#chart1 svg").datum(historicalBarChart).call(e);
    nv.utils.windowResize(e.update);
    return e;
});

var testdata = [ {
    key: "One",
    y: 5
}, {
    key: "Two",
    y: 2
}, {
    key: "Three",
    y: 9
}, {
    key: "Four",
    y: 7
}, {
    key: "Five",
    y: 4
}, {
    key: "Six",
    y: 3
}, {
    key: "Seven",
    y: .5
} ];

nv.addGraph(function() {
    var e = 500, t = 350, n = nv.models.pieChart().x(function(e) {
        return e.key;
    }).y(function(e) {
        return e.y;
    }).color(d3.scale.category10().range()).width(e).height(t);
    d3.select("#test1").datum(testdata).transition().duration(1200).attr("width", e).attr("height", t).call(n);
    n.dispatch.on("stateChange", function(e) {
        nv.log("New State:", JSON.stringify(e));
    });
    return n;
});
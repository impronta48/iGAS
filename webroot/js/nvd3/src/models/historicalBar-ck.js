//TODO: consider deprecating and using multibar with single series for this
nv.models.historicalBar = function() {
    "use strict";
    function b(w) {
        w.each(function(b) {
            var w = t - e.left - e.right, E = n - e.top - e.bottom, S = d3.select(this);
            i.domain(p || d3.extent(b[0].values.map(o).concat(a)));
            l ? i.range(v || [ w * .5 / b[0].values.length, w * (b[0].values.length - .5) / b[0].values.length ]) : i.range(v || [ 0, w ]);
            s.domain(d || d3.extent(b[0].values.map(u).concat(f))).range(m || [ E, 0 ]);
            i.domain()[0] === i.domain()[1] && (i.domain()[0] ? i.domain([ i.domain()[0] - i.domain()[0] * .01, i.domain()[1] + i.domain()[1] * .01 ]) : i.domain([ -1, 1 ]));
            s.domain()[0] === s.domain()[1] && (s.domain()[0] ? s.domain([ s.domain()[0] + s.domain()[0] * .01, s.domain()[1] - s.domain()[1] * .01 ]) : s.domain([ -1, 1 ]));
            var T = S.selectAll("g.nv-wrap.nv-historicalBar-" + r).data([ b[0].values ]), N = T.enter().append("g").attr("class", "nvd3 nv-wrap nv-historicalBar-" + r), C = N.append("defs"), k = N.append("g"), L = T.select("g");
            k.append("g").attr("class", "nv-bars");
            T.attr("transform", "translate(" + e.left + "," + e.top + ")");
            S.on("click", function(e, t) {
                g.chartClick({
                    data: e,
                    index: t,
                    pos: d3.event,
                    id: r
                });
            });
            C.append("clipPath").attr("id", "nv-chart-clip-path-" + r).append("rect");
            T.select("#nv-chart-clip-path-" + r + " rect").attr("width", w).attr("height", E);
            L.attr("clip-path", c ? "url(#nv-chart-clip-path-" + r + ")" : "");
            var A = T.select(".nv-bars").selectAll(".nv-bar").data(function(e) {
                return e;
            }, function(e, t) {
                return o(e, t);
            });
            A.exit().remove();
            var O = A.enter().append("rect").attr("x", 0).attr("y", function(e, t) {
                return nv.utils.NaNtoZero(s(Math.max(0, u(e, t))));
            }).attr("height", function(e, t) {
                return nv.utils.NaNtoZero(Math.abs(s(u(e, t)) - s(0)));
            }).attr("transform", function(e, t) {
                return "translate(" + (i(o(e, t)) - w / b[0].values.length * .45) + ",0)";
            }).on("mouseover", function(e, t) {
                if (!y) return;
                d3.select(this).classed("hover", !0);
                g.elementMouseover({
                    point: e,
                    series: b[0],
                    pos: [ i(o(e, t)), s(u(e, t)) ],
                    pointIndex: t,
                    seriesIndex: 0,
                    e: d3.event
                });
            }).on("mouseout", function(e, t) {
                if (!y) return;
                d3.select(this).classed("hover", !1);
                g.elementMouseout({
                    point: e,
                    series: b[0],
                    pointIndex: t,
                    seriesIndex: 0,
                    e: d3.event
                });
            }).on("click", function(e, t) {
                if (!y) return;
                g.elementClick({
                    value: u(e, t),
                    data: e,
                    index: t,
                    pos: [ i(o(e, t)), s(u(e, t)) ],
                    e: d3.event,
                    id: r
                });
                d3.event.stopPropagation();
            }).on("dblclick", function(e, t) {
                if (!y) return;
                g.elementDblClick({
                    value: u(e, t),
                    data: e,
                    index: t,
                    pos: [ i(o(e, t)), s(u(e, t)) ],
                    e: d3.event,
                    id: r
                });
                d3.event.stopPropagation();
            });
            A.attr("fill", function(e, t) {
                return h(e, t);
            }).attr("class", function(e, t, n) {
                return (u(e, t) < 0 ? "nv-bar negative" : "nv-bar positive") + " nv-bar-" + n + "-" + t;
            }).transition().attr("transform", function(e, t) {
                return "translate(" + (i(o(e, t)) - w / b[0].values.length * .45) + ",0)";
            }).attr("width", w / b[0].values.length * .9);
            A.transition().attr("y", function(e, t) {
                var n = u(e, t) < 0 ? s(0) : s(0) - s(u(e, t)) < 1 ? s(0) - 1 : s(u(e, t));
                return nv.utils.NaNtoZero(n);
            }).attr("height", function(e, t) {
                return nv.utils.NaNtoZero(Math.max(Math.abs(s(u(e, t)) - s(0)), 1));
            });
        });
        return b;
    }
    var e = {
        top: 0,
        right: 0,
        bottom: 0,
        left: 0
    }, t = 960, n = 500, r = Math.floor(Math.random() * 1e4), i = d3.scale.linear(), s = d3.scale.linear(), o = function(e) {
        return e.x;
    }, u = function(e) {
        return e.y;
    }, a = [], f = [ 0 ], l = !1, c = !0, h = nv.utils.defaultColor(), p, d, v, m, g = d3.dispatch("chartClick", "elementClick", "elementDblClick", "elementMouseover", "elementMouseout"), y = !0;
    b.highlightPoint = function(e, t) {
        d3.select(".nv-historicalBar-" + r).select(".nv-bars .nv-bar-0-" + e).classed("hover", t);
    };
    b.clearHighlights = function() {
        d3.select(".nv-historicalBar-" + r).select(".nv-bars .nv-bar.hover").classed("hover", !1);
    };
    b.dispatch = g;
    b.options = nv.utils.optionsFunc.bind(b);
    b.x = function(e) {
        if (!arguments.length) return o;
        o = e;
        return b;
    };
    b.y = function(e) {
        if (!arguments.length) return u;
        u = e;
        return b;
    };
    b.margin = function(t) {
        if (!arguments.length) return e;
        e.top = typeof t.top != "undefined" ? t.top : e.top;
        e.right = typeof t.right != "undefined" ? t.right : e.right;
        e.bottom = typeof t.bottom != "undefined" ? t.bottom : e.bottom;
        e.left = typeof t.left != "undefined" ? t.left : e.left;
        return b;
    };
    b.width = function(e) {
        if (!arguments.length) return t;
        t = e;
        return b;
    };
    b.height = function(e) {
        if (!arguments.length) return n;
        n = e;
        return b;
    };
    b.xScale = function(e) {
        if (!arguments.length) return i;
        i = e;
        return b;
    };
    b.yScale = function(e) {
        if (!arguments.length) return s;
        s = e;
        return b;
    };
    b.xDomain = function(e) {
        if (!arguments.length) return p;
        p = e;
        return b;
    };
    b.yDomain = function(e) {
        if (!arguments.length) return d;
        d = e;
        return b;
    };
    b.xRange = function(e) {
        if (!arguments.length) return v;
        v = e;
        return b;
    };
    b.yRange = function(e) {
        if (!arguments.length) return m;
        m = e;
        return b;
    };
    b.forceX = function(e) {
        if (!arguments.length) return a;
        a = e;
        return b;
    };
    b.forceY = function(e) {
        if (!arguments.length) return f;
        f = e;
        return b;
    };
    b.padData = function(e) {
        if (!arguments.length) return l;
        l = e;
        return b;
    };
    b.clipEdge = function(e) {
        if (!arguments.length) return c;
        c = e;
        return b;
    };
    b.color = function(e) {
        if (!arguments.length) return h;
        h = nv.utils.getColor(e);
        return b;
    };
    b.id = function(e) {
        if (!arguments.length) return r;
        r = e;
        return b;
    };
    b.interactive = function(e) {
        if (!arguments.length) return y;
        y = !1;
        return b;
    };
    return b;
};
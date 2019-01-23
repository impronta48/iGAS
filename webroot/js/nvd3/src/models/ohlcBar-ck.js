nv.models.ohlcBar = function() {
    "use strict";
    function S(m) {
        m.each(function(m) {
            var S = t - e.left - e.right, T = n - e.top - e.bottom, N = d3.select(this);
            i.domain(g || d3.extent(m[0].values.map(o).concat(h)));
            d ? i.range(b || [ S * .5 / m[0].values.length, S * (m[0].values.length - .5) / m[0].values.length ]) : i.range(b || [ 0, S ]);
            s.domain(y || [ d3.min(m[0].values.map(c).concat(p)), d3.max(m[0].values.map(l).concat(p)) ]).range(w || [ T, 0 ]);
            i.domain()[0] === i.domain()[1] && (i.domain()[0] ? i.domain([ i.domain()[0] - i.domain()[0] * .01, i.domain()[1] + i.domain()[1] * .01 ]) : i.domain([ -1, 1 ]));
            s.domain()[0] === s.domain()[1] && (s.domain()[0] ? s.domain([ s.domain()[0] + s.domain()[0] * .01, s.domain()[1] - s.domain()[1] * .01 ]) : s.domain([ -1, 1 ]));
            var C = d3.select(this).selectAll("g.nv-wrap.nv-ohlcBar").data([ m[0].values ]), k = C.enter().append("g").attr("class", "nvd3 nv-wrap nv-ohlcBar"), L = k.append("defs"), A = k.append("g"), O = C.select("g");
            A.append("g").attr("class", "nv-ticks");
            C.attr("transform", "translate(" + e.left + "," + e.top + ")");
            N.on("click", function(e, t) {
                E.chartClick({
                    data: e,
                    index: t,
                    pos: d3.event,
                    id: r
                });
            });
            L.append("clipPath").attr("id", "nv-chart-clip-path-" + r).append("rect");
            C.select("#nv-chart-clip-path-" + r + " rect").attr("width", S).attr("height", T);
            O.attr("clip-path", v ? "url(#nv-chart-clip-path-" + r + ")" : "");
            var M = C.select(".nv-ticks").selectAll(".nv-tick").data(function(e) {
                return e;
            });
            M.exit().remove();
            var _ = M.enter().append("path").attr("class", function(e, t, n) {
                return (a(e, t) > f(e, t) ? "nv-tick negative" : "nv-tick positive") + " nv-tick-" + n + "-" + t;
            }).attr("d", function(e, t) {
                var n = S / m[0].values.length * .9;
                return "m0,0l0," + (s(a(e, t)) - s(l(e, t))) + "l" + -n / 2 + ",0l" + n / 2 + ",0l0," + (s(c(e, t)) - s(a(e, t))) + "l0," + (s(f(e, t)) - s(c(e, t))) + "l" + n / 2 + ",0l" + -n / 2 + ",0z";
            }).attr("transform", function(e, t) {
                return "translate(" + i(o(e, t)) + "," + s(l(e, t)) + ")";
            }).on("mouseover", function(e, t) {
                d3.select(this).classed("hover", !0);
                E.elementMouseover({
                    point: e,
                    series: m[0],
                    pos: [ i(o(e, t)), s(u(e, t)) ],
                    pointIndex: t,
                    seriesIndex: 0,
                    e: d3.event
                });
            }).on("mouseout", function(e, t) {
                d3.select(this).classed("hover", !1);
                E.elementMouseout({
                    point: e,
                    series: m[0],
                    pointIndex: t,
                    seriesIndex: 0,
                    e: d3.event
                });
            }).on("click", function(e, t) {
                E.elementClick({
                    value: u(e, t),
                    data: e,
                    index: t,
                    pos: [ i(o(e, t)), s(u(e, t)) ],
                    e: d3.event,
                    id: r
                });
                d3.event.stopPropagation();
            }).on("dblclick", function(e, t) {
                E.elementDblClick({
                    value: u(e, t),
                    data: e,
                    index: t,
                    pos: [ i(o(e, t)), s(u(e, t)) ],
                    e: d3.event,
                    id: r
                });
                d3.event.stopPropagation();
            });
            M.attr("class", function(e, t, n) {
                return (a(e, t) > f(e, t) ? "nv-tick negative" : "nv-tick positive") + " nv-tick-" + n + "-" + t;
            });
            d3.transition(M).attr("transform", function(e, t) {
                return "translate(" + i(o(e, t)) + "," + s(l(e, t)) + ")";
            }).attr("d", function(e, t) {
                var n = S / m[0].values.length * .9;
                return "m0,0l0," + (s(a(e, t)) - s(l(e, t))) + "l" + -n / 2 + ",0l" + n / 2 + ",0l0," + (s(c(e, t)) - s(a(e, t))) + "l0," + (s(f(e, t)) - s(c(e, t))) + "l" + n / 2 + ",0l" + -n / 2 + ",0z";
            });
        });
        return S;
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
    }, a = function(e) {
        return e.open;
    }, f = function(e) {
        return e.close;
    }, l = function(e) {
        return e.high;
    }, c = function(e) {
        return e.low;
    }, h = [], p = [], d = !1, v = !0, m = nv.utils.defaultColor(), g, y, b, w, E = d3.dispatch("chartClick", "elementClick", "elementDblClick", "elementMouseover", "elementMouseout");
    S.dispatch = E;
    S.options = nv.utils.optionsFunc.bind(S);
    S.x = function(e) {
        if (!arguments.length) return o;
        o = e;
        return S;
    };
    S.y = function(e) {
        if (!arguments.length) return u;
        u = e;
        return S;
    };
    S.open = function(e) {
        if (!arguments.length) return a;
        a = e;
        return S;
    };
    S.close = function(e) {
        if (!arguments.length) return f;
        f = e;
        return S;
    };
    S.high = function(e) {
        if (!arguments.length) return l;
        l = e;
        return S;
    };
    S.low = function(e) {
        if (!arguments.length) return c;
        c = e;
        return S;
    };
    S.margin = function(t) {
        if (!arguments.length) return e;
        e.top = typeof t.top != "undefined" ? t.top : e.top;
        e.right = typeof t.right != "undefined" ? t.right : e.right;
        e.bottom = typeof t.bottom != "undefined" ? t.bottom : e.bottom;
        e.left = typeof t.left != "undefined" ? t.left : e.left;
        return S;
    };
    S.width = function(e) {
        if (!arguments.length) return t;
        t = e;
        return S;
    };
    S.height = function(e) {
        if (!arguments.length) return n;
        n = e;
        return S;
    };
    S.xScale = function(e) {
        if (!arguments.length) return i;
        i = e;
        return S;
    };
    S.yScale = function(e) {
        if (!arguments.length) return s;
        s = e;
        return S;
    };
    S.xDomain = function(e) {
        if (!arguments.length) return g;
        g = e;
        return S;
    };
    S.yDomain = function(e) {
        if (!arguments.length) return y;
        y = e;
        return S;
    };
    S.xRange = function(e) {
        if (!arguments.length) return b;
        b = e;
        return S;
    };
    S.yRange = function(e) {
        if (!arguments.length) return w;
        w = e;
        return S;
    };
    S.forceX = function(e) {
        if (!arguments.length) return h;
        h = e;
        return S;
    };
    S.forceY = function(e) {
        if (!arguments.length) return p;
        p = e;
        return S;
    };
    S.padData = function(e) {
        if (!arguments.length) return d;
        d = e;
        return S;
    };
    S.clipEdge = function(e) {
        if (!arguments.length) return v;
        v = e;
        return S;
    };
    S.color = function(e) {
        if (!arguments.length) return m;
        m = nv.utils.getColor(e);
        return S;
    };
    S.id = function(e) {
        if (!arguments.length) return r;
        r = e;
        return S;
    };
    return S;
};
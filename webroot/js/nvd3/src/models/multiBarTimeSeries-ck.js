nv.models.multiBarTimeSeries = function() {
    "use strict";
    function w(E) {
        E.each(function(w) {
            var E = t - e.left - e.right, S = n - e.top - e.bottom, T = d3.select(this);
            l && (w = d3.layout.stack().offset("zero").values(function(e) {
                return e.values;
            }).y(u)(w));
            w = w.map(function(e, t) {
                e.values = e.values.map(function(e) {
                    e.series = t;
                    return e;
                });
                return e;
            });
            var N = p && d ? [] : w.map(function(e) {
                return e.values.map(function(e, t) {
                    return {
                        x: o(e, t),
                        y: u(e, t),
                        y0: e.y0
                    };
                });
            });
            r.domain(p || d3.extent(d3.merge(N).map(function(e) {
                return e.x;
            }))).range(v || [ 0, E ]);
            i.domain(d || d3.extent(d3.merge(N).map(function(e) {
                return e.y + (l ? e.y0 : 0);
            }).concat(a))).range(m || [ S, 0 ]);
            r.domain()[0] === r.domain()[1] && (r.domain()[0] ? r.domain([ r.domain()[0] - r.domain()[0] * .01, r.domain()[1] + r.domain()[1] * .01 ]) : r.domain([ -1, 1 ]));
            i.domain()[0] === i.domain()[1] && (i.domain()[0] ? i.domain([ i.domain()[0] + i.domain()[0] * .01, i.domain()[1] - i.domain()[1] * .01 ]) : i.domain([ -1, 1 ]));
            y = y || r;
            b = b || i;
            var C = T.selectAll("g.nv-wrap.nv-multibar").data([ w ]), k = C.enter().append("g").attr("class", "nvd3 nv-wrap nv-multibar"), L = k.append("defs"), A = k.append("g"), O = C.select("g");
            A.append("g").attr("class", "nv-groups");
            C.attr("transform", "translate(" + e.left + "," + e.top + ")");
            L.append("clipPath").attr("id", "nv-edge-clip-" + s).append("rect");
            C.select("#nv-edge-clip-" + s + " rect").attr("width", E).attr("height", S);
            O.attr("clip-path", f ? "url(#nv-edge-clip-" + s + ")" : "");
            var M = C.select(".nv-groups").selectAll(".nv-group").data(function(e) {
                return e;
            }, function(e) {
                return e.key;
            });
            M.enter().append("g").style("stroke-opacity", 1e-6).style("fill-opacity", 1e-6);
            d3.transition(M.exit()).selectAll("rect.nv-bar").delay(function(e, t) {
                return t * h / w[0].values.length;
            }).attr("y", function(e) {
                return l ? b(e.y0) : b(0);
            }).attr("height", 0).remove();
            M.attr("class", function(e, t) {
                return "nv-group nv-series-" + t;
            }).classed("hover", function(e) {
                return e.hover;
            }).style("fill", function(e, t) {
                return c(e, t);
            }).style("stroke", function(e, t) {
                return c(e, t);
            });
            d3.transition(M).style("stroke-opacity", 1).style("fill-opacity", .75);
            var _ = M.selectAll("rect.nv-bar").data(function(e) {
                return e.values;
            });
            _.exit().remove();
            var D = 0;
            for (var P = 0; P < N.length; P += 1) D = Math.max(N[P].length, D);
            var H = E / D - .1, B = H / w.length, F = _.enter().append("rect").attr("class", function(e, t) {
                return u(e, t) < 0 ? "nv-bar negative" : "nv-bar positive";
            }).attr("x", function(e, t, n) {
                return l ? 0 : t * H + n * B;
            }).attr("y", function(e) {
                return b(l ? e.y0 : 0);
            }).attr("height", 0).attr("width", l ? H : B);
            _.on("mouseover", function(e, t) {
                d3.select(this).classed("hover", !0);
                g.elementMouseover({
                    value: u(e, t),
                    point: e,
                    series: w[e.series],
                    pos: [ r(o(e, t)) + B * (l ? w.length / 2 : e.series + .5) / w.length, i(u(e, t) + (l ? e.y0 : 0)) ],
                    pointIndex: t,
                    seriesIndex: e.series,
                    e: d3.event
                });
            }).on("mouseout", function(e, t) {
                d3.select(this).classed("hover", !1);
                g.elementMouseout({
                    value: u(e, t),
                    point: e,
                    series: w[e.series],
                    pointIndex: t,
                    seriesIndex: e.series,
                    e: d3.event
                });
            }).on("click", function(e, t) {
                g.elementClick({
                    value: u(e, t),
                    point: e,
                    series: w[e.series],
                    pos: [ r(o(e, t)) + B * (l ? w.length / 2 : e.series + .5) / w.length, i(u(e, t) + (l ? e.y0 : 0)) ],
                    pointIndex: t,
                    seriesIndex: e.series,
                    e: d3.event
                });
                d3.event.stopPropagation();
            }).on("dblclick", function(e, t) {
                g.elementDblClick({
                    value: u(e, t),
                    point: e,
                    series: w[e.series],
                    pos: [ r(o(e, t)) + B * (l ? w.length / 2 : e.series + .5) / w.length, i(u(e, t) + (l ? e.y0 : 0)) ],
                    pointIndex: t,
                    seriesIndex: e.series,
                    e: d3.event
                });
                d3.event.stopPropagation();
            });
            _.attr("class", function(e, t) {
                return u(e, t) < 0 ? "nv-bar negative" : "nv-bar positive";
            }).attr("transform", function(e, t) {
                return "translate(" + r(o(e, t)) + ",0)";
            });
            l ? d3.transition(_).delay(function(e, t) {
                return t * h / w[0].values.length;
            }).attr("y", function(e, t) {
                return i(u(e, t) + (l ? e.y0 : 0));
            }).attr("height", function(e, t) {
                return Math.abs(i(e.y + (l ? e.y0 : 0)) - i(l ? e.y0 : 0));
            }).each("end", function() {
                d3.transition(d3.select(this)).attr("x", function(e, t) {
                    return l ? 0 : t * H + j * B;
                }).attr("width", l ? H : B);
            }) : d3.transition(_).delay(function(e, t) {
                return t * h / w[0].values.length;
            }).attr("x", function(e, t) {
                return e.series * B;
            }).attr("width", B).each("end", function() {
                d3.transition(d3.select(this)).attr("y", function(e, t) {
                    return u(e, t) < 0 ? i(0) : i(u(e, t));
                }).attr("height", function(e, t) {
                    return Math.abs(i(u(e, t)) - i(0));
                });
            });
            y = r.copy();
            b = i.copy();
        });
        return w;
    }
    var e = {
        top: 0,
        right: 0,
        bottom: 0,
        left: 0
    }, t = 960, n = 500, r = d3.time.scale(), i = d3.scale.linear(), s = Math.floor(Math.random() * 1e4), o = function(e) {
        return e.x;
    }, u = function(e) {
        return e.y;
    }, a = [ 0 ], f = !0, l = !1, c = nv.utils.defaultColor(), h = 1200, p, d, v, m, g = d3.dispatch("chartClick", "elementClick", "elementDblClick", "elementMouseover", "elementMouseout"), y, b;
    w.dispatch = g;
    w.options = nv.utils.optionsFunc.bind(w);
    w.x = function(e) {
        if (!arguments.length) return o;
        o = e;
        return w;
    };
    w.y = function(e) {
        if (!arguments.length) return u;
        u = e;
        return w;
    };
    w.margin = function(t) {
        if (!arguments.length) return e;
        e.top = typeof t.top != "undefined" ? t.top : e.top;
        e.right = typeof t.right != "undefined" ? t.right : e.right;
        e.bottom = typeof t.bottom != "undefined" ? t.bottom : e.bottom;
        e.left = typeof t.left != "undefined" ? t.left : e.left;
        return w;
    };
    w.width = function(e) {
        if (!arguments.length) return t;
        t = e;
        return w;
    };
    w.height = function(e) {
        if (!arguments.length) return n;
        n = e;
        return w;
    };
    w.xScale = function(e) {
        if (!arguments.length) return r;
        r = e;
        return w;
    };
    w.yScale = function(e) {
        if (!arguments.length) return i;
        i = e;
        return w;
    };
    w.xDomain = function(e) {
        if (!arguments.length) return p;
        p = e;
        return w;
    };
    w.yDomain = function(e) {
        if (!arguments.length) return d;
        d = e;
        return w;
    };
    w.xRange = function(e) {
        if (!arguments.length) return v;
        v = e;
        return w;
    };
    w.yRange = function(e) {
        if (!arguments.length) return m;
        m = e;
        return w;
    };
    w.forceY = function(e) {
        if (!arguments.length) return a;
        a = e;
        return w;
    };
    w.stacked = function(e) {
        if (!arguments.length) return l;
        l = e;
        return w;
    };
    w.clipEdge = function(e) {
        if (!arguments.length) return f;
        f = e;
        return w;
    };
    w.color = function(e) {
        if (!arguments.length) return c;
        c = nv.utils.getColor(e);
        return w;
    };
    w.id = function(e) {
        if (!arguments.length) return s;
        s = e;
        return w;
    };
    w.delay = function(e) {
        if (!arguments.length) return h;
        h = e;
        return w;
    };
    return w;
};
//TODO: consider deprecating by adding necessary features to multiBar model
nv.models.discreteBar = function() {
    "use strict";
    function w(r) {
        r.each(function(r) {
            var w = t - e.left - e.right, E = n - e.top - e.bottom, S = d3.select(this);
            r = r.map(function(e, t) {
                e.values = e.values.map(function(e) {
                    e.series = t;
                    return e;
                });
                return e;
            });
            var T = h && p ? [] : r.map(function(e) {
                return e.values.map(function(e, t) {
                    return {
                        x: o(e, t),
                        y: u(e, t),
                        y0: e.y0
                    };
                });
            });
            i.domain(h || d3.merge(T).map(function(e) {
                return e.x;
            })).rangeBands(d || [ 0, w ], .1);
            s.domain(p || d3.extent(d3.merge(T).map(function(e) {
                return e.y;
            }).concat(a)));
            l ? s.range(v || [ E - (s.domain()[0] < 0 ? 12 : 0), s.domain()[1] > 0 ? 12 : 0 ]) : s.range(v || [ E, 0 ]);
            y = y || i;
            b = b || s.copy().range([ s(0), s(0) ]);
            var N = S.selectAll("g.nv-wrap.nv-discretebar").data([ r ]), C = N.enter().append("g").attr("class", "nvd3 nv-wrap nv-discretebar"), k = C.append("g"), L = N.select("g");
            k.append("g").attr("class", "nv-groups");
            N.attr("transform", "translate(" + e.left + "," + e.top + ")");
            var A = N.select(".nv-groups").selectAll(".nv-group").data(function(e) {
                return e;
            }, function(e) {
                return e.key;
            });
            A.enter().append("g").style("stroke-opacity", 1e-6).style("fill-opacity", 1e-6);
            A.exit().transition().style("stroke-opacity", 1e-6).style("fill-opacity", 1e-6).remove();
            A.attr("class", function(e, t) {
                return "nv-group nv-series-" + t;
            }).classed("hover", function(e) {
                return e.hover;
            });
            A.transition().style("stroke-opacity", 1).style("fill-opacity", .75);
            var O = A.selectAll("g.nv-bar").data(function(e) {
                return e.values;
            });
            O.exit().remove();
            var M = O.enter().append("g").attr("transform", function(e, t, n) {
                return "translate(" + (i(o(e, t)) + i.rangeBand() * .05) + ", " + s(0) + ")";
            }).on("mouseover", function(e, t) {
                d3.select(this).classed("hover", !0);
                m.elementMouseover({
                    value: u(e, t),
                    point: e,
                    series: r[e.series],
                    pos: [ i(o(e, t)) + i.rangeBand() * (e.series + .5) / r.length, s(u(e, t)) ],
                    pointIndex: t,
                    seriesIndex: e.series,
                    e: d3.event
                });
            }).on("mouseout", function(e, t) {
                d3.select(this).classed("hover", !1);
                m.elementMouseout({
                    value: u(e, t),
                    point: e,
                    series: r[e.series],
                    pointIndex: t,
                    seriesIndex: e.series,
                    e: d3.event
                });
            }).on("click", function(e, t) {
                m.elementClick({
                    value: u(e, t),
                    point: e,
                    series: r[e.series],
                    pos: [ i(o(e, t)) + i.rangeBand() * (e.series + .5) / r.length, s(u(e, t)) ],
                    pointIndex: t,
                    seriesIndex: e.series,
                    e: d3.event
                });
                d3.event.stopPropagation();
            }).on("dblclick", function(e, t) {
                m.elementDblClick({
                    value: u(e, t),
                    point: e,
                    series: r[e.series],
                    pos: [ i(o(e, t)) + i.rangeBand() * (e.series + .5) / r.length, s(u(e, t)) ],
                    pointIndex: t,
                    seriesIndex: e.series,
                    e: d3.event
                });
                d3.event.stopPropagation();
            });
            M.append("rect").attr("height", 0).attr("width", i.rangeBand() * .9 / r.length);
            if (l) {
                M.append("text").attr("text-anchor", "middle");
                O.select("text").text(function(e, t) {
                    return c(u(e, t));
                }).transition().attr("x", i.rangeBand() * .9 / 2).attr("y", function(e, t) {
                    return u(e, t) < 0 ? s(u(e, t)) - s(0) + 12 : -4;
                });
            } else O.selectAll("text").remove();
            O.attr("class", function(e, t) {
                return u(e, t) < 0 ? "nv-bar negative" : "nv-bar positive";
            }).style("fill", function(e, t) {
                return e.color || f(e, t);
            }).style("stroke", function(e, t) {
                return e.color || f(e, t);
            }).select("rect").attr("class", g).transition().attr("width", i.rangeBand() * .9 / r.length);
            O.transition().attr("transform", function(e, t) {
                var n = i(o(e, t)) + i.rangeBand() * .05, r = u(e, t) < 0 ? s(0) : s(0) - s(u(e, t)) < 1 ? s(0) - 1 : s(u(e, t));
                return "translate(" + n + ", " + r + ")";
            }).select("rect").attr("height", function(e, t) {
                return Math.max(Math.abs(s(u(e, t)) - s(p && p[0] || 0)) || 1);
            });
            y = i.copy();
            b = s.copy();
        });
        return w;
    }
    var e = {
        top: 0,
        right: 0,
        bottom: 0,
        left: 0
    }, t = 960, n = 500, r = Math.floor(Math.random() * 1e4), i = d3.scale.ordinal(), s = d3.scale.linear(), o = function(e) {
        return e.x;
    }, u = function(e) {
        return e.y;
    }, a = [ 0 ], f = nv.utils.defaultColor(), l = !1, c = d3.format(",.2f"), h, p, d, v, m = d3.dispatch("chartClick", "elementClick", "elementDblClick", "elementMouseover", "elementMouseout"), g = "discreteBar", y, b;
    w.dispatch = m;
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
        if (!arguments.length) return i;
        i = e;
        return w;
    };
    w.yScale = function(e) {
        if (!arguments.length) return s;
        s = e;
        return w;
    };
    w.xDomain = function(e) {
        if (!arguments.length) return h;
        h = e;
        return w;
    };
    w.yDomain = function(e) {
        if (!arguments.length) return p;
        p = e;
        return w;
    };
    w.xRange = function(e) {
        if (!arguments.length) return d;
        d = e;
        return w;
    };
    w.yRange = function(e) {
        if (!arguments.length) return v;
        v = e;
        return w;
    };
    w.forceY = function(e) {
        if (!arguments.length) return a;
        a = e;
        return w;
    };
    w.color = function(e) {
        if (!arguments.length) return f;
        f = nv.utils.getColor(e);
        return w;
    };
    w.id = function(e) {
        if (!arguments.length) return r;
        r = e;
        return w;
    };
    w.showValues = function(e) {
        if (!arguments.length) return l;
        l = e;
        return w;
    };
    w.valueFormat = function(e) {
        if (!arguments.length) return c;
        c = e;
        return w;
    };
    w.rectClass = function(e) {
        if (!arguments.length) return g;
        g = e;
        return w;
    };
    return w;
};
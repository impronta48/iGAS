nv.models.multiBarHorizontal = function() {
    "use strict";
    function T(r) {
        r.each(function(r) {
            var m = t - e.left - e.right, T = n - e.top - e.bottom, N = d3.select(this);
            h && (r = d3.layout.stack().offset("zero").values(function(e) {
                return e.values;
            }).y(u)(r));
            r = r.map(function(e, t) {
                e.values = e.values.map(function(e) {
                    e.series = t;
                    return e;
                });
                return e;
            });
            h && r[0].values.map(function(e, t) {
                var n = 0, i = 0;
                r.map(function(e) {
                    var r = e.values[t];
                    r.size = Math.abs(r.y);
                    if (r.y < 0) {
                        r.y1 = i - r.size;
                        i -= r.size;
                    } else {
                        r.y1 = n;
                        n += r.size;
                    }
                });
            });
            var C = g && y ? [] : r.map(function(e) {
                return e.values.map(function(e, t) {
                    return {
                        x: o(e, t),
                        y: u(e, t),
                        y0: e.y0,
                        y1: e.y1
                    };
                });
            });
            i.domain(g || d3.merge(C).map(function(e) {
                return e.x;
            })).rangeBands(b || [ 0, T ], .1);
            s.domain(y || d3.extent(d3.merge(C).map(function(e) {
                return h ? e.y > 0 ? e.y1 + e.y : e.y1 : e.y;
            }).concat(a)));
            p && !h ? s.range(w || [ s.domain()[0] < 0 ? d : 0, m - (s.domain()[1] > 0 ? d : 0) ]) : s.range(w || [ 0, m ]);
            S = S || i;
            x = x || d3.scale.linear().domain(s.domain()).range([ s(0), s(0) ]);
            var k = d3.select(this).selectAll("g.nv-wrap.nv-multibarHorizontal").data([ r ]), L = k.enter().append("g").attr("class", "nvd3 nv-wrap nv-multibarHorizontal"), A = L.append("defs"), O = L.append("g"), M = k.select("g");
            O.append("g").attr("class", "nv-groups");
            k.attr("transform", "translate(" + e.left + "," + e.top + ")");
            var _ = k.select(".nv-groups").selectAll(".nv-group").data(function(e) {
                return e;
            }, function(e, t) {
                return t;
            });
            _.enter().append("g").style("stroke-opacity", 1e-6).style("fill-opacity", 1e-6);
            _.exit().transition().style("stroke-opacity", 1e-6).style("fill-opacity", 1e-6).remove();
            _.attr("class", function(e, t) {
                return "nv-group nv-series-" + t;
            }).classed("hover", function(e) {
                return e.hover;
            }).style("fill", function(e, t) {
                return f(e, t);
            }).style("stroke", function(e, t) {
                return f(e, t);
            });
            _.transition().style("stroke-opacity", 1).style("fill-opacity", .75);
            var D = _.selectAll("g.nv-bar").data(function(e) {
                return e.values;
            });
            D.exit().remove();
            var P = D.enter().append("g").attr("transform", function(e, t, n) {
                return "translate(" + x(h ? e.y0 : 0) + "," + (h ? 0 : n * i.rangeBand() / r.length + i(o(e, t))) + ")";
            });
            P.append("rect").attr("width", 0).attr("height", i.rangeBand() / (h ? 1 : r.length));
            D.on("mouseover", function(e, t) {
                d3.select(this).classed("hover", !0);
                E.elementMouseover({
                    value: u(e, t),
                    point: e,
                    series: r[e.series],
                    pos: [ s(u(e, t) + (h ? e.y0 : 0)), i(o(e, t)) + i.rangeBand() * (h ? r.length / 2 : e.series + .5) / r.length ],
                    pointIndex: t,
                    seriesIndex: e.series,
                    e: d3.event
                });
            }).on("mouseout", function(e, t) {
                d3.select(this).classed("hover", !1);
                E.elementMouseout({
                    value: u(e, t),
                    point: e,
                    series: r[e.series],
                    pointIndex: t,
                    seriesIndex: e.series,
                    e: d3.event
                });
            }).on("click", function(e, t) {
                E.elementClick({
                    value: u(e, t),
                    point: e,
                    series: r[e.series],
                    pos: [ i(o(e, t)) + i.rangeBand() * (h ? r.length / 2 : e.series + .5) / r.length, s(u(e, t) + (h ? e.y0 : 0)) ],
                    pointIndex: t,
                    seriesIndex: e.series,
                    e: d3.event
                });
                d3.event.stopPropagation();
            }).on("dblclick", function(e, t) {
                E.elementDblClick({
                    value: u(e, t),
                    point: e,
                    series: r[e.series],
                    pos: [ i(o(e, t)) + i.rangeBand() * (h ? r.length / 2 : e.series + .5) / r.length, s(u(e, t) + (h ? e.y0 : 0)) ],
                    pointIndex: t,
                    seriesIndex: e.series,
                    e: d3.event
                });
                d3.event.stopPropagation();
            });
            P.append("text");
            if (p && !h) {
                D.select("text").attr("text-anchor", function(e, t) {
                    return u(e, t) < 0 ? "end" : "start";
                }).attr("y", i.rangeBand() / (r.length * 2)).attr("dy", ".32em").text(function(e, t) {
                    return v(u(e, t));
                });
                D.transition().select("text").attr("x", function(e, t) {
                    return u(e, t) < 0 ? -4 : s(u(e, t)) - s(0) + 4;
                });
            } else D.selectAll("text").text("");
            D.attr("class", function(e, t) {
                return u(e, t) < 0 ? "nv-bar negative" : "nv-bar positive";
            });
            if (l) {
                c || (c = r.map(function() {
                    return !0;
                }));
                D.style("fill", function(e, t, n) {
                    return d3.rgb(l(e, t)).darker(c.map(function(e, t) {
                        return t;
                    }).filter(function(e, t) {
                        return !c[t];
                    })[n]).toString();
                }).style("stroke", function(e, t, n) {
                    return d3.rgb(l(e, t)).darker(c.map(function(e, t) {
                        return t;
                    }).filter(function(e, t) {
                        return !c[t];
                    })[n]).toString();
                });
            }
            h ? D.transition().attr("transform", function(e, t) {
                return "translate(" + s(e.y1) + "," + i(o(e, t)) + ")";
            }).select("rect").attr("width", function(e, t) {
                return Math.abs(s(u(e, t) + e.y0) - s(e.y0));
            }).attr("height", i.rangeBand()) : D.transition().attr("transform", function(e, t) {
                return "translate(" + (u(e, t) < 0 ? s(u(e, t)) : s(0)) + "," + (e.series * i.rangeBand() / r.length + i(o(e, t))) + ")";
            }).select("rect").attr("height", i.rangeBand() / r.length).attr("width", function(e, t) {
                return Math.max(Math.abs(s(u(e, t)) - s(0)), 1);
            });
            S = i.copy();
            x = s.copy();
        });
        return T;
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
    }, a = [ 0 ], f = nv.utils.defaultColor(), l = null, c, h = !1, p = !1, d = 60, v = d3.format(",.2f"), m = 1200, g, y, b, w, E = d3.dispatch("chartClick", "elementClick", "elementDblClick", "elementMouseover", "elementMouseout"), S, x;
    T.dispatch = E;
    T.options = nv.utils.optionsFunc.bind(T);
    T.x = function(e) {
        if (!arguments.length) return o;
        o = e;
        return T;
    };
    T.y = function(e) {
        if (!arguments.length) return u;
        u = e;
        return T;
    };
    T.margin = function(t) {
        if (!arguments.length) return e;
        e.top = typeof t.top != "undefined" ? t.top : e.top;
        e.right = typeof t.right != "undefined" ? t.right : e.right;
        e.bottom = typeof t.bottom != "undefined" ? t.bottom : e.bottom;
        e.left = typeof t.left != "undefined" ? t.left : e.left;
        return T;
    };
    T.width = function(e) {
        if (!arguments.length) return t;
        t = e;
        return T;
    };
    T.height = function(e) {
        if (!arguments.length) return n;
        n = e;
        return T;
    };
    T.xScale = function(e) {
        if (!arguments.length) return i;
        i = e;
        return T;
    };
    T.yScale = function(e) {
        if (!arguments.length) return s;
        s = e;
        return T;
    };
    T.xDomain = function(e) {
        if (!arguments.length) return g;
        g = e;
        return T;
    };
    T.yDomain = function(e) {
        if (!arguments.length) return y;
        y = e;
        return T;
    };
    T.xRange = function(e) {
        if (!arguments.length) return b;
        b = e;
        return T;
    };
    T.yRange = function(e) {
        if (!arguments.length) return w;
        w = e;
        return T;
    };
    T.forceY = function(e) {
        if (!arguments.length) return a;
        a = e;
        return T;
    };
    T.stacked = function(e) {
        if (!arguments.length) return h;
        h = e;
        return T;
    };
    T.color = function(e) {
        if (!arguments.length) return f;
        f = nv.utils.getColor(e);
        return T;
    };
    T.barColor = function(e) {
        if (!arguments.length) return l;
        l = nv.utils.getColor(e);
        return T;
    };
    T.disabled = function(e) {
        if (!arguments.length) return c;
        c = e;
        return T;
    };
    T.id = function(e) {
        if (!arguments.length) return r;
        r = e;
        return T;
    };
    T.delay = function(e) {
        if (!arguments.length) return m;
        m = e;
        return T;
    };
    T.showValues = function(e) {
        if (!arguments.length) return p;
        p = e;
        return T;
    };
    T.valueFormat = function(e) {
        if (!arguments.length) return v;
        v = e;
        return T;
    };
    T.valuePadding = function(e) {
        if (!arguments.length) return d;
        d = e;
        return T;
    };
    return T;
};
nv.models.multiBar = function() {
    "use strict";
    function N(C) {
        C.each(function(N) {
            var C = t - e.left - e.right, k = n - e.top - e.bottom, L = d3.select(this);
            p && N.length && (p = [ {
                values: N[0].values.map(function(e) {
                    return {
                        x: e.x,
                        y: 0,
                        series: e.series,
                        size: .01
                    };
                })
            } ]);
            l && (N = d3.layout.stack().offset(c).values(function(e) {
                return e.values;
            }).y(u)(!N.length && p ? p : N));
            N = N.map(function(e, t) {
                e.values = e.values.map(function(e) {
                    e.series = t;
                    return e;
                });
                return e;
            });
            l && N[0].values.map(function(e, t) {
                var n = 0, r = 0;
                N.map(function(e) {
                    var i = e.values[t];
                    i.size = Math.abs(i.y);
                    if (i.y < 0) {
                        i.y1 = r;
                        r -= i.size;
                    } else {
                        i.y1 = i.size + n;
                        n += i.size;
                    }
                });
            });
            var A = g && y ? [] : N.map(function(e) {
                return e.values.map(function(e, t) {
                    return {
                        x: o(e, t),
                        y: u(e, t),
                        y0: e.y0,
                        y1: e.y1
                    };
                });
            });
            r.domain(g || d3.merge(A).map(function(e) {
                return e.x;
            })).rangeBands(b || [ 0, C ], E);
            i.domain(y || d3.extent(d3.merge(A).map(function(e) {
                return l ? e.y > 0 ? e.y1 : e.y1 + e.y : e.y;
            }).concat(a))).range(w || [ k, 0 ]);
            r.domain()[0] === r.domain()[1] && (r.domain()[0] ? r.domain([ r.domain()[0] - r.domain()[0] * .01, r.domain()[1] + r.domain()[1] * .01 ]) : r.domain([ -1, 1 ]));
            i.domain()[0] === i.domain()[1] && (i.domain()[0] ? i.domain([ i.domain()[0] + i.domain()[0] * .01, i.domain()[1] - i.domain()[1] * .01 ]) : i.domain([ -1, 1 ]));
            x = x || r;
            T = T || i;
            var O = L.selectAll("g.nv-wrap.nv-multibar").data([ N ]), M = O.enter().append("g").attr("class", "nvd3 nv-wrap nv-multibar"), _ = M.append("defs"), D = M.append("g"), P = O.select("g");
            D.append("g").attr("class", "nv-groups");
            O.attr("transform", "translate(" + e.left + "," + e.top + ")");
            _.append("clipPath").attr("id", "nv-edge-clip-" + s).append("rect");
            O.select("#nv-edge-clip-" + s + " rect").attr("width", C).attr("height", k);
            P.attr("clip-path", f ? "url(#nv-edge-clip-" + s + ")" : "");
            var H = O.select(".nv-groups").selectAll(".nv-group").data(function(e) {
                return e;
            }, function(e, t) {
                return t;
            });
            H.enter().append("g").style("stroke-opacity", 1e-6).style("fill-opacity", 1e-6);
            H.exit().transition().selectAll("rect.nv-bar").delay(function(e, t) {
                return t * m / N[0].values.length;
            }).attr("y", function(e) {
                return l ? T(e.y0) : T(0);
            }).attr("height", 0).remove();
            H.attr("class", function(e, t) {
                return "nv-group nv-series-" + t;
            }).classed("hover", function(e) {
                return e.hover;
            }).style("fill", function(e, t) {
                return h(e, t);
            }).style("stroke", function(e, t) {
                return h(e, t);
            });
            H.transition().style("stroke-opacity", 1).style("fill-opacity", .75);
            var B = H.selectAll("rect.nv-bar").data(function(e) {
                return p && !N.length ? p.values : e.values;
            });
            B.exit().remove();
            var j = B.enter().append("rect").attr("class", function(e, t) {
                return u(e, t) < 0 ? "nv-bar negative" : "nv-bar positive";
            }).attr("x", function(e, t, n) {
                return l ? 0 : n * r.rangeBand() / N.length;
            }).attr("y", function(e) {
                return T(l ? e.y0 : 0);
            }).attr("height", 0).attr("width", r.rangeBand() / (l ? 1 : N.length)).attr("transform", function(e, t) {
                return "translate(" + r(o(e, t)) + ",0)";
            });
            B.style("fill", function(e, t, n) {
                return h(e, n, t);
            }).style("stroke", function(e, t, n) {
                return h(e, n, t);
            }).on("mouseover", function(e, t) {
                d3.select(this).classed("hover", !0);
                S.elementMouseover({
                    value: u(e, t),
                    point: e,
                    series: N[e.series],
                    pos: [ r(o(e, t)) + r.rangeBand() * (l ? N.length / 2 : e.series + .5) / N.length, i(u(e, t) + (l ? e.y0 : 0)) ],
                    pointIndex: t,
                    seriesIndex: e.series,
                    e: d3.event
                });
            }).on("mouseout", function(e, t) {
                d3.select(this).classed("hover", !1);
                S.elementMouseout({
                    value: u(e, t),
                    point: e,
                    series: N[e.series],
                    pointIndex: t,
                    seriesIndex: e.series,
                    e: d3.event
                });
            }).on("click", function(e, t) {
                S.elementClick({
                    value: u(e, t),
                    point: e,
                    series: N[e.series],
                    pos: [ r(o(e, t)) + r.rangeBand() * (l ? N.length / 2 : e.series + .5) / N.length, i(u(e, t) + (l ? e.y0 : 0)) ],
                    pointIndex: t,
                    seriesIndex: e.series,
                    e: d3.event
                });
                d3.event.stopPropagation();
            }).on("dblclick", function(e, t) {
                S.elementDblClick({
                    value: u(e, t),
                    point: e,
                    series: N[e.series],
                    pos: [ r(o(e, t)) + r.rangeBand() * (l ? N.length / 2 : e.series + .5) / N.length, i(u(e, t) + (l ? e.y0 : 0)) ],
                    pointIndex: t,
                    seriesIndex: e.series,
                    e: d3.event
                });
                d3.event.stopPropagation();
            });
            B.attr("class", function(e, t) {
                return u(e, t) < 0 ? "nv-bar negative" : "nv-bar positive";
            }).transition().attr("transform", function(e, t) {
                return "translate(" + r(o(e, t)) + ",0)";
            });
            if (d) {
                v || (v = N.map(function() {
                    return !0;
                }));
                B.style("fill", function(e, t, n) {
                    return d3.rgb(d(e, t)).darker(v.map(function(e, t) {
                        return t;
                    }).filter(function(e, t) {
                        return !v[t];
                    })[n]).toString();
                }).style("stroke", function(e, t, n) {
                    return d3.rgb(d(e, t)).darker(v.map(function(e, t) {
                        return t;
                    }).filter(function(e, t) {
                        return !v[t];
                    })[n]).toString();
                });
            }
            l ? B.transition().delay(function(e, t) {
                return t * m / N[0].values.length;
            }).attr("y", function(e, t) {
                return i(l ? e.y1 : 0);
            }).attr("height", function(e, t) {
                return Math.max(Math.abs(i(e.y + (l ? e.y0 : 0)) - i(l ? e.y0 : 0)), 1);
            }).attr("x", function(e, t) {
                return l ? 0 : e.series * r.rangeBand() / N.length;
            }).attr("width", r.rangeBand() / (l ? 1 : N.length)) : B.transition().delay(function(e, t) {
                return t * m / N[0].values.length;
            }).attr("x", function(e, t) {
                return e.series * r.rangeBand() / N.length;
            }).attr("width", r.rangeBand() / N.length).attr("y", function(e, t) {
                return u(e, t) < 0 ? i(0) : i(0) - i(u(e, t)) < 1 ? i(0) - 1 : i(u(e, t)) || 0;
            }).attr("height", function(e, t) {
                return Math.max(Math.abs(i(u(e, t)) - i(0)), 1) || 0;
            });
            x = r.copy();
            T = i.copy();
        });
        return N;
    }
    var e = {
        top: 0,
        right: 0,
        bottom: 0,
        left: 0
    }, t = 960, n = 500, r = d3.scale.ordinal(), i = d3.scale.linear(), s = Math.floor(Math.random() * 1e4), o = function(e) {
        return e.x;
    }, u = function(e) {
        return e.y;
    }, a = [ 0 ], f = !0, l = !1, c = "zero", h = nv.utils.defaultColor(), p = !1, d = null, v, m = 1200, g, y, b, w, E = .1, S = d3.dispatch("chartClick", "elementClick", "elementDblClick", "elementMouseover", "elementMouseout"), x, T;
    N.dispatch = S;
    N.options = nv.utils.optionsFunc.bind(N);
    N.x = function(e) {
        if (!arguments.length) return o;
        o = e;
        return N;
    };
    N.y = function(e) {
        if (!arguments.length) return u;
        u = e;
        return N;
    };
    N.margin = function(t) {
        if (!arguments.length) return e;
        e.top = typeof t.top != "undefined" ? t.top : e.top;
        e.right = typeof t.right != "undefined" ? t.right : e.right;
        e.bottom = typeof t.bottom != "undefined" ? t.bottom : e.bottom;
        e.left = typeof t.left != "undefined" ? t.left : e.left;
        return N;
    };
    N.width = function(e) {
        if (!arguments.length) return t;
        t = e;
        return N;
    };
    N.height = function(e) {
        if (!arguments.length) return n;
        n = e;
        return N;
    };
    N.xScale = function(e) {
        if (!arguments.length) return r;
        r = e;
        return N;
    };
    N.yScale = function(e) {
        if (!arguments.length) return i;
        i = e;
        return N;
    };
    N.xDomain = function(e) {
        if (!arguments.length) return g;
        g = e;
        return N;
    };
    N.yDomain = function(e) {
        if (!arguments.length) return y;
        y = e;
        return N;
    };
    N.xRange = function(e) {
        if (!arguments.length) return b;
        b = e;
        return N;
    };
    N.yRange = function(e) {
        if (!arguments.length) return w;
        w = e;
        return N;
    };
    N.forceY = function(e) {
        if (!arguments.length) return a;
        a = e;
        return N;
    };
    N.stacked = function(e) {
        if (!arguments.length) return l;
        l = e;
        return N;
    };
    N.stackOffset = function(e) {
        if (!arguments.length) return c;
        c = e;
        return N;
    };
    N.clipEdge = function(e) {
        if (!arguments.length) return f;
        f = e;
        return N;
    };
    N.color = function(e) {
        if (!arguments.length) return h;
        h = nv.utils.getColor(e);
        return N;
    };
    N.barColor = function(e) {
        if (!arguments.length) return d;
        d = nv.utils.getColor(e);
        return N;
    };
    N.disabled = function(e) {
        if (!arguments.length) return v;
        v = e;
        return N;
    };
    N.id = function(e) {
        if (!arguments.length) return s;
        s = e;
        return N;
    };
    N.hideable = function(e) {
        if (!arguments.length) return p;
        p = e;
        return N;
    };
    N.delay = function(e) {
        if (!arguments.length) return m;
        m = e;
        return N;
    };
    N.groupSpacing = function(e) {
        if (!arguments.length) return E;
        E = e;
        return N;
    };
    return N;
};
nv.models.historicalBarChart = function() {
    "use strict";
    function S(p) {
        p.each(function(T) {
            var N = d3.select(this), C = this, k = (o || parseInt(N.style("width")) || 960) - i.left - i.right, L = (u || parseInt(N.style("height")) || 400) - i.top - i.bottom;
            S.update = function() {
                N.transition().duration(w).call(S);
            };
            S.container = this;
            m.disabled = T.map(function(e) {
                return !!e.disabled;
            });
            if (!g) {
                var A;
                g = {};
                for (A in m) m[A] instanceof Array ? g[A] = m[A].slice(0) : g[A] = m[A];
            }
            if (!T || !T.length || !T.filter(function(e) {
                return e.values.length;
            }).length) {
                var O = N.selectAll(".nv-noData").data([ y ]);
                O.enter().append("text").attr("class", "nvd3 nv-noData").attr("dy", "-.7em").style("text-anchor", "middle");
                O.attr("x", i.left + k / 2).attr("y", i.top + L / 2).text(function(e) {
                    return e;
                });
                return S;
            }
            N.selectAll(".nv-noData").remove();
            d = e.xScale();
            v = e.yScale();
            var M = N.selectAll("g.nv-wrap.nv-historicalBarChart").data([ T ]), _ = M.enter().append("g").attr("class", "nvd3 nv-wrap nv-historicalBarChart").append("g"), D = M.select("g");
            _.append("g").attr("class", "nv-x nv-axis");
            _.append("g").attr("class", "nv-y nv-axis");
            _.append("g").attr("class", "nv-barsWrap");
            _.append("g").attr("class", "nv-legendWrap");
            if (a) {
                r.width(k);
                D.select(".nv-legendWrap").datum(T).call(r);
                if (i.top != r.height()) {
                    i.top = r.height();
                    L = (u || parseInt(N.style("height")) || 400) - i.top - i.bottom;
                }
                M.select(".nv-legendWrap").attr("transform", "translate(0," + -i.top + ")");
            }
            M.attr("transform", "translate(" + i.left + "," + i.top + ")");
            c && D.select(".nv-y.nv-axis").attr("transform", "translate(" + k + ",0)");
            e.width(k).height(L).color(T.map(function(e, t) {
                return e.color || s(e, t);
            }).filter(function(e, t) {
                return !T[t].disabled;
            }));
            var P = D.select(".nv-barsWrap").datum(T.filter(function(e) {
                return !e.disabled;
            }));
            P.transition().call(e);
            if (f) {
                t.scale(d).tickSize(-L, 0);
                D.select(".nv-x.nv-axis").attr("transform", "translate(0," + v.range()[0] + ")");
                D.select(".nv-x.nv-axis").transition().call(t);
            }
            if (l) {
                n.scale(v).ticks(L / 36).tickSize(-k, 0);
                D.select(".nv-y.nv-axis").transition().call(n);
            }
            r.dispatch.on("legendClick", function(e, t) {
                e.disabled = !e.disabled;
                T.filter(function(e) {
                    return !e.disabled;
                }).length || T.map(function(e) {
                    e.disabled = !1;
                    M.selectAll(".nv-series").classed("disabled", !1);
                    return e;
                });
                m.disabled = T.map(function(e) {
                    return !!e.disabled;
                });
                b.stateChange(m);
                p.transition().call(S);
            });
            r.dispatch.on("legendDblclick", function(e) {
                T.forEach(function(e) {
                    e.disabled = !0;
                });
                e.disabled = !1;
                m.disabled = T.map(function(e) {
                    return !!e.disabled;
                });
                b.stateChange(m);
                S.update();
            });
            b.on("tooltipShow", function(e) {
                h && E(e, C.parentNode);
            });
            b.on("changeState", function(e) {
                if (typeof e.disabled != "undefined") {
                    T.forEach(function(t, n) {
                        t.disabled = e.disabled[n];
                    });
                    m.disabled = e.disabled;
                }
                p.call(S);
            });
        });
        return S;
    }
    var e = nv.models.historicalBar(), t = nv.models.axis(), n = nv.models.axis(), r = nv.models.legend(), i = {
        top: 30,
        right: 90,
        bottom: 50,
        left: 90
    }, s = nv.utils.defaultColor(), o = null, u = null, a = !1, f = !0, l = !0, c = !1, h = !0, p = function(e, t, n, r, i) {
        return "<h3>" + e + "</h3>" + "<p>" + n + " at " + t + "</p>";
    }, d, v, m = {}, g = null, y = "No Data Available.", b = d3.dispatch("tooltipShow", "tooltipHide", "stateChange", "changeState"), w = 250;
    t.orient("bottom").tickPadding(7);
    n.orient(c ? "right" : "left");
    var E = function(r, i) {
        if (i) {
            var s = d3.select(i).select("svg"), o = s.node() ? s.attr("viewBox") : null;
            if (o) {
                o = o.split(" ");
                var u = parseInt(s.style("width")) / o[2];
                r.pos[0] = r.pos[0] * u;
                r.pos[1] = r.pos[1] * u;
            }
        }
        var a = r.pos[0] + (i.offsetLeft || 0), f = r.pos[1] + (i.offsetTop || 0), l = t.tickFormat()(e.x()(r.point, r.pointIndex)), c = n.tickFormat()(e.y()(r.point, r.pointIndex)), h = p(r.series.key, l, c, r, S);
        nv.tooltip.show([ a, f ], h, null, null, i);
    };
    e.dispatch.on("elementMouseover.tooltip", function(e) {
        e.pos = [ e.pos[0] + i.left, e.pos[1] + i.top ];
        b.tooltipShow(e);
    });
    e.dispatch.on("elementMouseout.tooltip", function(e) {
        b.tooltipHide(e);
    });
    b.on("tooltipHide", function() {
        h && nv.tooltip.cleanup();
    });
    S.dispatch = b;
    S.bars = e;
    S.legend = r;
    S.xAxis = t;
    S.yAxis = n;
    d3.rebind(S, e, "defined", "isArea", "x", "y", "size", "xScale", "yScale", "xDomain", "yDomain", "xRange", "yRange", "forceX", "forceY", "interactive", "clipEdge", "clipVoronoi", "id", "interpolate", "highlightPoint", "clearHighlights", "interactive");
    S.options = nv.utils.optionsFunc.bind(S);
    S.margin = function(e) {
        if (!arguments.length) return i;
        i.top = typeof e.top != "undefined" ? e.top : i.top;
        i.right = typeof e.right != "undefined" ? e.right : i.right;
        i.bottom = typeof e.bottom != "undefined" ? e.bottom : i.bottom;
        i.left = typeof e.left != "undefined" ? e.left : i.left;
        return S;
    };
    S.width = function(e) {
        if (!arguments.length) return o;
        o = e;
        return S;
    };
    S.height = function(e) {
        if (!arguments.length) return u;
        u = e;
        return S;
    };
    S.color = function(e) {
        if (!arguments.length) return s;
        s = nv.utils.getColor(e);
        r.color(s);
        return S;
    };
    S.showLegend = function(e) {
        if (!arguments.length) return a;
        a = e;
        return S;
    };
    S.showXAxis = function(e) {
        if (!arguments.length) return f;
        f = e;
        return S;
    };
    S.showYAxis = function(e) {
        if (!arguments.length) return l;
        l = e;
        return S;
    };
    S.rightAlignYAxis = function(e) {
        if (!arguments.length) return c;
        c = e;
        n.orient(e ? "right" : "left");
        return S;
    };
    S.tooltips = function(e) {
        if (!arguments.length) return h;
        h = e;
        return S;
    };
    S.tooltipContent = function(e) {
        if (!arguments.length) return p;
        p = e;
        return S;
    };
    S.state = function(e) {
        if (!arguments.length) return m;
        m = e;
        return S;
    };
    S.defaultState = function(e) {
        if (!arguments.length) return g;
        g = e;
        return S;
    };
    S.noData = function(e) {
        if (!arguments.length) return y;
        y = e;
        return S;
    };
    S.transitionDuration = function(e) {
        if (!arguments.length) return w;
        w = e;
        return S;
    };
    return S;
};
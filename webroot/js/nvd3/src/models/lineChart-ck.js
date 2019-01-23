nv.models.lineChart = function() {
    "use strict";
    function T(v) {
        v.each(function(v) {
            var N = d3.select(this), C = this, k = (u || parseInt(N.style("width")) || 960) - s.left - s.right, L = (a || parseInt(N.style("height")) || 400) - s.top - s.bottom;
            T.update = function() {
                N.transition().duration(S).call(T);
            };
            T.container = this;
            y.disabled = v.map(function(e) {
                return !!e.disabled;
            });
            if (!b) {
                var A;
                b = {};
                for (A in y) y[A] instanceof Array ? b[A] = y[A].slice(0) : b[A] = y[A];
            }
            if (!v || !v.length || !v.filter(function(e) {
                return e.values.length;
            }).length) {
                var O = N.selectAll(".nv-noData").data([ w ]);
                O.enter().append("text").attr("class", "nvd3 nv-noData").attr("dy", "-.7em").style("text-anchor", "middle");
                O.attr("x", s.left + k / 2).attr("y", s.top + L / 2).text(function(e) {
                    return e;
                });
                return T;
            }
            N.selectAll(".nv-noData").remove();
            m = e.xScale();
            g = e.yScale();
            var M = N.selectAll("g.nv-wrap.nv-lineChart").data([ v ]), _ = M.enter().append("g").attr("class", "nvd3 nv-wrap nv-lineChart").append("g"), D = M.select("g");
            _.append("rect").style("opacity", 0);
            _.append("g").attr("class", "nv-x nv-axis");
            _.append("g").attr("class", "nv-y nv-axis");
            _.append("g").attr("class", "nv-linesWrap");
            _.append("g").attr("class", "nv-legendWrap");
            _.append("g").attr("class", "nv-interactive");
            D.select("rect").attr("width", k).attr("height", L);
            if (f) {
                r.width(k);
                D.select(".nv-legendWrap").datum(v).call(r);
                if (s.top != r.height()) {
                    s.top = r.height();
                    L = (a || parseInt(N.style("height")) || 400) - s.top - s.bottom;
                }
                M.select(".nv-legendWrap").attr("transform", "translate(0," + -s.top + ")");
            }
            M.attr("transform", "translate(" + s.left + "," + s.top + ")");
            h && D.select(".nv-y.nv-axis").attr("transform", "translate(" + k + ",0)");
            if (p) {
                i.width(k).height(L).margin({
                    left: s.left,
                    top: s.top
                }).svgContainer(N).xScale(m);
                M.select(".nv-interactive").call(i);
            }
            e.width(k).height(L).color(v.map(function(e, t) {
                return e.color || o(e, t);
            }).filter(function(e, t) {
                return !v[t].disabled;
            }));
            var P = D.select(".nv-linesWrap").datum(v.filter(function(e) {
                return !e.disabled;
            }));
            P.transition().call(e);
            if (l) {
                t.scale(m).ticks(k / 100).tickSize(-L, 0);
                D.select(".nv-x.nv-axis").attr("transform", "translate(0," + g.range()[0] + ")");
                D.select(".nv-x.nv-axis").transition().call(t);
            }
            if (c) {
                n.scale(g).ticks(L / 36).tickSize(-k, 0);
                D.select(".nv-y.nv-axis").transition().call(n);
            }
            r.dispatch.on("stateChange", function(e) {
                y = e;
                E.stateChange(y);
                T.update();
            });
            i.dispatch.on("elementMousemove", function(r) {
                e.clearHighlights();
                var u, a, f, l = [];
                v.filter(function(e, t) {
                    e.seriesIndex = t;
                    return !e.disabled;
                }).forEach(function(t, n) {
                    a = nv.interactiveBisect(t.values, r.pointXValue, T.x());
                    e.highlightPoint(n, a, !0);
                    var i = t.values[a];
                    if (typeof i == "undefined") return;
                    typeof u == "undefined" && (u = i);
                    typeof f == "undefined" && (f = T.xScale()(T.x()(i, a)));
                    l.push({
                        key: t.key,
                        value: T.y()(i, a),
                        color: o(t, t.seriesIndex)
                    });
                });
                var c = t.tickFormat()(T.x()(u, a));
                i.tooltip.position({
                    left: f + s.left,
                    top: r.mouseY + s.top
                }).chartContainer(C.parentNode).enabled(d).valueFormatter(function(e, t) {
                    return n.tickFormat()(e);
                }).data({
                    value: c,
                    series: l
                })();
                i.renderGuideLine(f);
            });
            i.dispatch.on("elementMouseout", function(t) {
                E.tooltipHide();
                e.clearHighlights();
            });
            E.on("tooltipShow", function(e) {
                d && x(e, C.parentNode);
            });
            E.on("changeState", function(e) {
                if (typeof e.disabled != "undefined") {
                    v.forEach(function(t, n) {
                        t.disabled = e.disabled[n];
                    });
                    y.disabled = e.disabled;
                }
                T.update();
            });
        });
        return T;
    }
    var e = nv.models.line(), t = nv.models.axis(), n = nv.models.axis(), r = nv.models.legend(), i = nv.interactiveGuideline(), s = {
        top: 30,
        right: 20,
        bottom: 50,
        left: 60
    }, o = nv.utils.defaultColor(), u = null, a = null, f = !0, l = !0, c = !0, h = !1, p = !1, d = !0, v = function(e, t, n, r, i) {
        return "<h3>" + e + "</h3>" + "<p>" + n + " at " + t + "</p>";
    }, m, g, y = {}, b = null, w = "No Data Available.", E = d3.dispatch("tooltipShow", "tooltipHide", "stateChange", "changeState"), S = 250;
    t.orient("bottom").tickPadding(7);
    n.orient(h ? "right" : "left");
    var x = function(r, i) {
        var s = r.pos[0] + (i.offsetLeft || 0), o = r.pos[1] + (i.offsetTop || 0), u = t.tickFormat()(e.x()(r.point, r.pointIndex)), a = n.tickFormat()(e.y()(r.point, r.pointIndex)), f = v(r.series.key, u, a, r, T);
        nv.tooltip.show([ s, o ], f, null, null, i);
    };
    e.dispatch.on("elementMouseover.tooltip", function(e) {
        e.pos = [ e.pos[0] + s.left, e.pos[1] + s.top ];
        E.tooltipShow(e);
    });
    e.dispatch.on("elementMouseout.tooltip", function(e) {
        E.tooltipHide(e);
    });
    E.on("tooltipHide", function() {
        d && nv.tooltip.cleanup();
    });
    T.dispatch = E;
    T.lines = e;
    T.legend = r;
    T.xAxis = t;
    T.yAxis = n;
    T.interactiveLayer = i;
    d3.rebind(T, e, "defined", "isArea", "x", "y", "size", "xScale", "yScale", "xDomain", "yDomain", "xRange", "yRange", "forceX", "forceY", "interactive", "clipEdge", "clipVoronoi", "useVoronoi", "id", "interpolate");
    T.options = nv.utils.optionsFunc.bind(T);
    T.margin = function(e) {
        if (!arguments.length) return s;
        s.top = typeof e.top != "undefined" ? e.top : s.top;
        s.right = typeof e.right != "undefined" ? e.right : s.right;
        s.bottom = typeof e.bottom != "undefined" ? e.bottom : s.bottom;
        s.left = typeof e.left != "undefined" ? e.left : s.left;
        return T;
    };
    T.width = function(e) {
        if (!arguments.length) return u;
        u = e;
        return T;
    };
    T.height = function(e) {
        if (!arguments.length) return a;
        a = e;
        return T;
    };
    T.color = function(e) {
        if (!arguments.length) return o;
        o = nv.utils.getColor(e);
        r.color(o);
        return T;
    };
    T.showLegend = function(e) {
        if (!arguments.length) return f;
        f = e;
        return T;
    };
    T.showXAxis = function(e) {
        if (!arguments.length) return l;
        l = e;
        return T;
    };
    T.showYAxis = function(e) {
        if (!arguments.length) return c;
        c = e;
        return T;
    };
    T.rightAlignYAxis = function(e) {
        if (!arguments.length) return h;
        h = e;
        n.orient(e ? "right" : "left");
        return T;
    };
    T.useInteractiveGuideline = function(e) {
        if (!arguments.length) return p;
        p = e;
        if (e === !0) {
            T.interactive(!1);
            T.useVoronoi(!1);
        }
        return T;
    };
    T.tooltips = function(e) {
        if (!arguments.length) return d;
        d = e;
        return T;
    };
    T.tooltipContent = function(e) {
        if (!arguments.length) return v;
        v = e;
        return T;
    };
    T.state = function(e) {
        if (!arguments.length) return y;
        y = e;
        return T;
    };
    T.defaultState = function(e) {
        if (!arguments.length) return b;
        b = e;
        return T;
    };
    T.noData = function(e) {
        if (!arguments.length) return w;
        w = e;
        return T;
    };
    T.transitionDuration = function(e) {
        if (!arguments.length) return S;
        S = e;
        return T;
    };
    return T;
};
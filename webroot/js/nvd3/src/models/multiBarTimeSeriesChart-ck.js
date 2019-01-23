nv.models.multiBarTimeSeriesChart = function() {
    "use strict";
    function w(d) {
        d.each(function(E) {
            var S = d3.select(this), T = this, N = (o || parseInt(S.style("width")) || 960) - s.left - s.right, C = (u || parseInt(S.style("height")) || 400) - s.top - s.bottom;
            w.update = function() {
                d.transition().call(w);
            };
            w.container = this;
            if (!E || !E.length || !E.filter(function(e) {
                return e.values.length;
            }).length) {
                var k = S.selectAll(".nv-noData").data([ g ]);
                k.enter().append("text").attr("class", "nvd3 nv-noData").attr("dy", "-.7em").style("text-anchor", "middle");
                k.attr("x", s.left + N / 2).attr("y", s.top + C / 2).text(function(e) {
                    return e;
                });
                return w;
            }
            S.selectAll(".nv-noData").remove();
            v = e.xScale();
            m = e.yScale();
            var L = S.selectAll("g.nv-wrap.nv-multiBarWithLegend").data([ E ]), A = L.enter().append("g").attr("class", "nvd3 nv-wrap nv-multiBarWithLegend").append("g"), O = L.select("g");
            A.append("g").attr("class", "nv-x nv-axis");
            A.append("g").attr("class", "nv-y nv-axis");
            A.append("g").attr("class", "nv-barsWrap");
            A.append("g").attr("class", "nv-legendWrap");
            A.append("g").attr("class", "nv-controlsWrap");
            if (l) {
                r.width(N / 2);
                O.select(".nv-legendWrap").datum(E).call(r);
                if (s.top != r.height()) {
                    s.top = r.height();
                    C = (u || parseInt(S.style("height")) || 400) - s.top - s.bottom;
                }
                O.select(".nv-legendWrap").attr("transform", "translate(" + N / 2 + "," + -s.top + ")");
            }
            if (f) {
                var M = [ {
                    key: "Grouped",
                    disabled: e.stacked()
                }, {
                    key: "Stacked",
                    disabled: !e.stacked()
                } ];
                i.width(180).color([ "#444", "#444", "#444" ]);
                O.select(".nv-controlsWrap").datum(M).attr("transform", "translate(0," + -s.top + ")").call(i);
            }
            L.attr("transform", "translate(" + s.left + "," + s.top + ")");
            e.width(N).height(C).color(E.map(function(e, t) {
                return e.color || a(e, t);
            }).filter(function(e, t) {
                return !E[t].disabled;
            }));
            var _ = O.select(".nv-barsWrap").datum(E.filter(function(e) {
                return !e.disabled;
            }));
            d3.transition(_).call(e);
            t.scale(v).ticks(N / 100).tickSize(-C, 0);
            O.select(".nv-x.nv-axis").attr("transform", "translate(0," + m.range()[0] + ")");
            d3.transition(O.select(".nv-x.nv-axis")).call(t);
            var D = O.select(".nv-x.nv-axis > g").selectAll("g");
            D.selectAll("line, text").style("opacity", 1);
            c && D.filter(function(e, t) {
                return t % Math.ceil(E[0].values.length / (N / 100)) !== 0;
            }).selectAll("text, line").style("opacity", 0);
            h && D.selectAll("text").attr("transform", function(e, t, n) {
                return "rotate(" + h + " 0,0)";
            }).attr("text-transform", h > 0 ? "start" : "end");
            n.scale(m).ticks(C / 36).tickSize(-N, 0);
            d3.transition(O.select(".nv-y.nv-axis")).call(n);
            r.dispatch.on("legendClick", function(e, t) {
                e.disabled = !e.disabled;
                E.filter(function(e) {
                    return !e.disabled;
                }).length || E.map(function(e) {
                    e.disabled = !1;
                    L.selectAll(".nv-series").classed("disabled", !1);
                    return e;
                });
                d.transition().call(w);
            });
            i.dispatch.on("legendClick", function(t, n) {
                if (!t.disabled) return;
                M = M.map(function(e) {
                    e.disabled = !0;
                    return e;
                });
                t.disabled = !1;
                switch (t.key) {
                  case "Grouped":
                    e.stacked(!1);
                    break;
                  case "Stacked":
                    e.stacked(!0);
                }
                d.transition().call(w);
            });
            y.on("tooltipShow", function(e) {
                p && b(e, T.parentNode);
            });
        });
        return w;
    }
    var e = nv.models.multiBarTimeSeries(), t = nv.models.axis(), n = nv.models.axis(), r = nv.models.legend(), i = nv.models.legend(), s = {
        top: 30,
        right: 20,
        bottom: 50,
        left: 60
    }, o = null, u = null, a = nv.utils.defaultColor(), f = !0, l = !0, c = !0, h = 0, p = !0, d = function(e, t, n, r, i) {
        return "<h3>" + e + "</h3>" + "<p>" + n + " on " + t + "</p>";
    }, v, m, g = "No Data Available.", y = d3.dispatch("tooltipShow", "tooltipHide");
    e.stacked(!1);
    t.orient("bottom").tickPadding(7).highlightZero(!1).showMaxMin(!1);
    n.orient("left").tickFormat(d3.format(",.1f"));
    var b = function(r, i) {
        var s = r.pos[0] + (i.offsetLeft || 0), o = r.pos[1] + (i.offsetTop || 0), u = t.tickFormat()(e.x()(r.point, r.pointIndex)), a = n.tickFormat()(e.y()(r.point, r.pointIndex)), f = d(r.series.key, u, a, r, w);
        nv.tooltip.show([ s, o ], f, r.value < 0 ? "n" : "s", null, i);
    };
    e.dispatch.on("elementMouseover.tooltip", function(e) {
        e.pos = [ e.pos[0] + s.left, e.pos[1] + s.top ];
        y.tooltipShow(e);
    });
    e.dispatch.on("elementMouseout.tooltip", function(e) {
        y.tooltipHide(e);
    });
    y.on("tooltipHide", function() {
        p && nv.tooltip.cleanup();
    });
    w.dispatch = y;
    w.multibar = e;
    w.legend = r;
    w.xAxis = t;
    w.yAxis = n;
    d3.rebind(w, e, "x", "y", "xDomain", "yDomain", "xRange", "yRange", "forceX", "forceY", "clipEdge", "id", "stacked", "delay");
    w.options = nv.utils.optionsFunc.bind(w);
    w.margin = function(e) {
        if (!arguments.length) return s;
        s.top = typeof e.top != "undefined" ? e.top : s.top;
        s.right = typeof e.right != "undefined" ? e.right : s.right;
        s.bottom = typeof e.bottom != "undefined" ? e.bottom : s.bottom;
        s.left = typeof e.left != "undefined" ? e.left : s.left;
        return w;
    };
    w.width = function(e) {
        if (!arguments.length) return o;
        o = e;
        return w;
    };
    w.height = function(e) {
        if (!arguments.length) return u;
        u = e;
        return w;
    };
    w.color = function(e) {
        if (!arguments.length) return a;
        a = nv.utils.getColor(e);
        r.color(a);
        return w;
    };
    w.showControls = function(e) {
        if (!arguments.length) return f;
        f = e;
        return w;
    };
    w.showLegend = function(e) {
        if (!arguments.length) return l;
        l = e;
        return w;
    };
    w.reduceXTicks = function(e) {
        if (!arguments.length) return c;
        c = e;
        return w;
    };
    w.rotateLabels = function(e) {
        if (!arguments.length) return h;
        h = e;
        return w;
    };
    w.tooltip = function(e) {
        if (!arguments.length) return d;
        d = e;
        return w;
    };
    w.tooltips = function(e) {
        if (!arguments.length) return p;
        p = e;
        return w;
    };
    w.tooltipContent = function(e) {
        if (!arguments.length) return d;
        d = e;
        return w;
    };
    w.noData = function(e) {
        if (!arguments.length) return g;
        g = e;
        return w;
    };
    return w;
};
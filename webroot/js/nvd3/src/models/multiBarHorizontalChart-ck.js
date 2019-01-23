nv.models.multiBarHorizontalChart = function() {
    "use strict";
    function x(c) {
        c.each(function(p) {
            var T = d3.select(this), N = this, C = (o || parseInt(T.style("width")) || 960) - s.left - s.right, k = (u || parseInt(T.style("height")) || 400) - s.top - s.bottom;
            x.update = function() {
                T.transition().duration(E).call(x);
            };
            x.container = this;
            m.disabled = p.map(function(e) {
                return !!e.disabled;
            });
            if (!g) {
                var L;
                g = {};
                for (L in m) m[L] instanceof Array ? g[L] = m[L].slice(0) : g[L] = m[L];
            }
            if (!p || !p.length || !p.filter(function(e) {
                return e.values.length;
            }).length) {
                var A = T.selectAll(".nv-noData").data([ y ]);
                A.enter().append("text").attr("class", "nvd3 nv-noData").attr("dy", "-.7em").style("text-anchor", "middle");
                A.attr("x", s.left + C / 2).attr("y", s.top + k / 2).text(function(e) {
                    return e;
                });
                return x;
            }
            T.selectAll(".nv-noData").remove();
            d = e.xScale();
            v = e.yScale();
            var O = T.selectAll("g.nv-wrap.nv-multiBarHorizontalChart").data([ p ]), M = O.enter().append("g").attr("class", "nvd3 nv-wrap nv-multiBarHorizontalChart").append("g"), _ = O.select("g");
            M.append("g").attr("class", "nv-x nv-axis");
            M.append("g").attr("class", "nv-y nv-axis");
            M.append("g").attr("class", "nv-barsWrap");
            M.append("g").attr("class", "nv-legendWrap");
            M.append("g").attr("class", "nv-controlsWrap");
            if (l) {
                r.width(C - w());
                e.barColor() && p.forEach(function(e, t) {
                    e.color = d3.rgb("#ccc").darker(t * 1.5).toString();
                });
                _.select(".nv-legendWrap").datum(p).call(r);
                if (s.top != r.height()) {
                    s.top = r.height();
                    k = (u || parseInt(T.style("height")) || 400) - s.top - s.bottom;
                }
                _.select(".nv-legendWrap").attr("transform", "translate(" + w() + "," + -s.top + ")");
            }
            if (f) {
                var D = [ {
                    key: "Grouped",
                    disabled: e.stacked()
                }, {
                    key: "Stacked",
                    disabled: !e.stacked()
                } ];
                i.width(w()).color([ "#444", "#444", "#444" ]);
                _.select(".nv-controlsWrap").datum(D).attr("transform", "translate(0," + -s.top + ")").call(i);
            }
            O.attr("transform", "translate(" + s.left + "," + s.top + ")");
            e.disabled(p.map(function(e) {
                return e.disabled;
            })).width(C).height(k).color(p.map(function(e, t) {
                return e.color || a(e, t);
            }).filter(function(e, t) {
                return !p[t].disabled;
            }));
            var P = _.select(".nv-barsWrap").datum(p.filter(function(e) {
                return !e.disabled;
            }));
            P.transition().call(e);
            t.scale(d).ticks(k / 24).tickSize(-C, 0);
            _.select(".nv-x.nv-axis").transition().call(t);
            var H = _.select(".nv-x.nv-axis").selectAll("g");
            H.selectAll("line, text").style("opacity", 1);
            n.scale(v).ticks(C / 100).tickSize(-k, 0);
            _.select(".nv-y.nv-axis").attr("transform", "translate(0," + k + ")");
            _.select(".nv-y.nv-axis").transition().call(n);
            r.dispatch.on("stateChange", function(e) {
                m = e;
                b.stateChange(m);
                x.update();
            });
            i.dispatch.on("legendClick", function(t, n) {
                if (!t.disabled) return;
                D = D.map(function(e) {
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
                m.stacked = e.stacked();
                b.stateChange(m);
                x.update();
            });
            b.on("tooltipShow", function(e) {
                h && S(e, N.parentNode);
            });
            b.on("changeState", function(t) {
                if (typeof t.disabled != "undefined") {
                    p.forEach(function(e, n) {
                        e.disabled = t.disabled[n];
                    });
                    m.disabled = t.disabled;
                }
                if (typeof t.stacked != "undefined") {
                    e.stacked(t.stacked);
                    m.stacked = t.stacked;
                }
                c.call(x);
            });
        });
        return x;
    }
    var e = nv.models.multiBarHorizontal(), t = nv.models.axis(), n = nv.models.axis(), r = nv.models.legend().height(30), i = nv.models.legend().height(30), s = {
        top: 30,
        right: 20,
        bottom: 50,
        left: 60
    }, o = null, u = null, a = nv.utils.defaultColor(), f = !0, l = !0, c = !1, h = !0, p = function(e, t, n, r, i) {
        return "<h3>" + e + " - " + t + "</h3>" + "<p>" + n + "</p>";
    }, d, v, m = {
        stacked: c
    }, g = null, y = "No Data Available.", b = d3.dispatch("tooltipShow", "tooltipHide", "stateChange", "changeState"), w = function() {
        return f ? 180 : 0;
    }, E = 250;
    e.stacked(c);
    t.orient("left").tickPadding(5).highlightZero(!1).showMaxMin(!1).tickFormat(function(e) {
        return e;
    });
    n.orient("bottom").tickFormat(d3.format(",.1f"));
    i.updateState(!1);
    var S = function(r, i) {
        var s = r.pos[0] + (i.offsetLeft || 0), o = r.pos[1] + (i.offsetTop || 0), u = t.tickFormat()(e.x()(r.point, r.pointIndex)), a = n.tickFormat()(e.y()(r.point, r.pointIndex)), f = p(r.series.key, u, a, r, x);
        nv.tooltip.show([ s, o ], f, r.value < 0 ? "e" : "w", null, i);
    };
    e.dispatch.on("elementMouseover.tooltip", function(e) {
        e.pos = [ e.pos[0] + s.left, e.pos[1] + s.top ];
        b.tooltipShow(e);
    });
    e.dispatch.on("elementMouseout.tooltip", function(e) {
        b.tooltipHide(e);
    });
    b.on("tooltipHide", function() {
        h && nv.tooltip.cleanup();
    });
    x.dispatch = b;
    x.multibar = e;
    x.legend = r;
    x.xAxis = t;
    x.yAxis = n;
    d3.rebind(x, e, "x", "y", "xDomain", "yDomain", "xRange", "yRange", "forceX", "forceY", "clipEdge", "id", "delay", "showValues", "valueFormat", "stacked", "barColor");
    x.options = nv.utils.optionsFunc.bind(x);
    x.margin = function(e) {
        if (!arguments.length) return s;
        s.top = typeof e.top != "undefined" ? e.top : s.top;
        s.right = typeof e.right != "undefined" ? e.right : s.right;
        s.bottom = typeof e.bottom != "undefined" ? e.bottom : s.bottom;
        s.left = typeof e.left != "undefined" ? e.left : s.left;
        return x;
    };
    x.width = function(e) {
        if (!arguments.length) return o;
        o = e;
        return x;
    };
    x.height = function(e) {
        if (!arguments.length) return u;
        u = e;
        return x;
    };
    x.color = function(e) {
        if (!arguments.length) return a;
        a = nv.utils.getColor(e);
        r.color(a);
        return x;
    };
    x.showControls = function(e) {
        if (!arguments.length) return f;
        f = e;
        return x;
    };
    x.showLegend = function(e) {
        if (!arguments.length) return l;
        l = e;
        return x;
    };
    x.tooltip = function(e) {
        if (!arguments.length) return p;
        p = e;
        return x;
    };
    x.tooltips = function(e) {
        if (!arguments.length) return h;
        h = e;
        return x;
    };
    x.tooltipContent = function(e) {
        if (!arguments.length) return p;
        p = e;
        return x;
    };
    x.state = function(e) {
        if (!arguments.length) return m;
        m = e;
        return x;
    };
    x.defaultState = function(e) {
        if (!arguments.length) return g;
        g = e;
        return x;
    };
    x.noData = function(e) {
        if (!arguments.length) return y;
        y = e;
        return x;
    };
    x.transitionDuration = function(e) {
        if (!arguments.length) return E;
        E = e;
        return x;
    };
    return x;
};
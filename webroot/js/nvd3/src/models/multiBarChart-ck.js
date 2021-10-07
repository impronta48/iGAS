nv.models.multiBarChart = function() {
    "use strict";
    function L(y) {
        y.each(function(y) {
            var A = d3.select(this), O = this, M = (o || parseInt(A.style("width")) || 960) - s.left - s.right, _ = (u || parseInt(A.style("height")) || 400) - s.top - s.bottom;
            L.update = function() {
                A.transition().duration(C).call(L);
            };
            L.container = this;
            E.disabled = y.map(function(e) {
                return !!e.disabled;
            });
            if (!S) {
                var D;
                S = {};
                for (D in E) E[D] instanceof Array ? S[D] = E[D].slice(0) : S[D] = E[D];
            }
            if (!y || !y.length || !y.filter(function(e) {
                return e.values.length;
            }).length) {
                var P = A.selectAll(".nv-noData").data([ x ]);
                P.enter().append("text").attr("class", "nvd3 nv-noData").attr("dy", "-.7em").style("text-anchor", "middle");
                P.attr("x", s.left + M / 2).attr("y", s.top + _ / 2).text(function(e) {
                    return e;
                });
                return L;
            }
            A.selectAll(".nv-noData").remove();
            b = e.xScale();
            w = e.yScale();
            var H = A.selectAll("g.nv-wrap.nv-multiBarWithLegend").data([ y ]), B = H.enter().append("g").attr("class", "nvd3 nv-wrap nv-multiBarWithLegend").append("g"), j = H.select("g");
            B.append("g").attr("class", "nv-x nv-axis");
            B.append("g").attr("class", "nv-y nv-axis");
            B.append("g").attr("class", "nv-barsWrap");
            B.append("g").attr("class", "nv-legendWrap");
            B.append("g").attr("class", "nv-controlsWrap");
            if (l) {
                r.width(M - N());
                e.barColor() && y.forEach(function(e, t) {
                    e.color = d3.rgb("#ccc").darker(t * 1.5).toString();
                });
                j.select(".nv-legendWrap").datum(y).call(r);
                if (s.top != r.height()) {
                    s.top = r.height();
                    _ = (u || parseInt(A.style("height")) || 400) - s.top - s.bottom;
                }
                j.select(".nv-legendWrap").attr("transform", "translate(" + N() + "," + -s.top + ")");
            }
            if (f) {
                var F = [ {
                    key: "Grouped",
                    disabled: e.stacked()
                }, {
                    key: "Stacked",
                    disabled: !e.stacked()
                } ];
                i.width(N()).color([ "#444", "#444", "#444" ]);
                j.select(".nv-controlsWrap").datum(F).attr("transform", "translate(0," + -s.top + ")").call(i);
            }
            H.attr("transform", "translate(" + s.left + "," + s.top + ")");
            p && j.select(".nv-y.nv-axis").attr("transform", "translate(" + M + ",0)");
            e.disabled(y.map(function(e) {
                return e.disabled;
            })).width(M).height(_).color(y.map(function(e, t) {
                return e.color || a(e, t);
            }).filter(function(e, t) {
                return !y[t].disabled;
            }));
            var I = j.select(".nv-barsWrap").datum(y.filter(function(e) {
                return !e.disabled;
            }));
            I.transition().call(e);
            if (c) {
                t.scale(b).ticks(M / 100).tickSize(-_, 0);
                j.select(".nv-x.nv-axis").attr("transform", "translate(0," + w.range()[0] + ")");
                j.select(".nv-x.nv-axis").transition().call(t);
                var q = j.select(".nv-x.nv-axis > g").selectAll("g");
                q.selectAll("line, text").style("opacity", 1);
                if (v) {
                    var R = function(e, t) {
                        return "translate(" + e + "," + t + ")";
                    }, U = 5, z = 17;
                    q.selectAll("text").attr("transform", function(e, t, n) {
                        return R(0, n % 2 == 0 ? U : z);
                    });
                    var W = d3.selectAll(".nv-x.nv-axis .nv-wrap g g text")[0].length;
                    j.selectAll(".nv-x.nv-axis .nv-axisMaxMin text").attr("transform", function(e, t) {
                        return R(0, t === 0 || W % 2 !== 0 ? z : U);
                    });
                }
                d && q.filter(function(e, t) {
                    return t % Math.ceil(y[0].values.length / (M / 100)) !== 0;
                }).selectAll("text, line").style("opacity", 0);
                m && q.selectAll(".tick text").attr("transform", "rotate(" + m + " 0,0)").style("text-anchor", m > 0 ? "start" : "end");
                j.select(".nv-x.nv-axis").selectAll("g.nv-axisMaxMin text").style("opacity", 1);
            }
            if (h) {
                n.scale(w).ticks(_ / 36).tickSize(-M, 0);
                j.select(".nv-y.nv-axis").transition().call(n);
            }
            r.dispatch.on("stateChange", function(e) {
                E = e;
                T.stateChange(E);
                L.update();
            });
            i.dispatch.on("legendClick", function(t, n) {
                if (!t.disabled) return;
                F = F.map(function(e) {
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
                E.stacked = e.stacked();
                T.stateChange(E);
                L.update();
            });
            T.on("tooltipShow", function(e) {
                g && k(e, O.parentNode);
            });
            T.on("changeState", function(t) {
                if (typeof t.disabled != "undefined") {
                    y.forEach(function(e, n) {
                        e.disabled = t.disabled[n];
                    });
                    E.disabled = t.disabled;
                }
                if (typeof t.stacked != "undefined") {
                    e.stacked(t.stacked);
                    E.stacked = t.stacked;
                }
                L.update();
            });
        });
        return L;
    }
    var e = nv.models.multiBar(), t = nv.models.axis(), n = nv.models.axis(), r = nv.models.legend(), i = nv.models.legend(), s = {
        top: 30,
        right: 20,
        bottom: 50,
        left: 60
    }, o = null, u = null, a = nv.utils.defaultColor(), f = !0, l = !0, c = !0, h = !0, p = !1, d = !0, v = !1, m = 0, g = !0, y = function(e, t, n, r, i) {
        return "<h3>" + e + "</h3>" + "<p>" + n + " on " + t + "</p>";
    }, b, w, E = {
        stacked: !1
    }, S = null, x = "No Data Available.", T = d3.dispatch("tooltipShow", "tooltipHide", "stateChange", "changeState"), N = function() {
        return f ? 180 : 0;
    }, C = 250;
    e.stacked(!1);
    t.orient("bottom").tickPadding(7).highlightZero(!0).showMaxMin(!1).tickFormat(function(e) {
        return e;
    });
    n.orient(p ? "right" : "left").tickFormat(d3.format(",.1f"));
    i.updateState(!1);
    var k = function(r, i) {
        var s = r.pos[0] + (i.offsetLeft || 0), o = r.pos[1] + (i.offsetTop || 0), u = t.tickFormat()(e.x()(r.point, r.pointIndex)), a = n.tickFormat()(e.y()(r.point, r.pointIndex)), f = y(r.series.key, u, a, r, L);
        nv.tooltip.show([ s, o ], f, r.value < 0 ? "n" : "s", null, i);
    };
    e.dispatch.on("elementMouseover.tooltip", function(e) {
        e.pos = [ e.pos[0] + s.left, e.pos[1] + s.top ];
        T.tooltipShow(e);
    });
    e.dispatch.on("elementMouseout.tooltip", function(e) {
        T.tooltipHide(e);
    });
    T.on("tooltipHide", function() {
        g && nv.tooltip.cleanup();
    });
    L.dispatch = T;
    L.multibar = e;
    L.legend = r;
    L.xAxis = t;
    L.yAxis = n;
    d3.rebind(L, e, "x", "y", "xDomain", "yDomain", "xRange", "yRange", "forceX", "forceY", "clipEdge", "id", "stacked", "stackOffset", "delay", "barColor", "groupSpacing");
    L.options = nv.utils.optionsFunc.bind(L);
    L.margin = function(e) {
        if (!arguments.length) return s;
        s.top = typeof e.top != "undefined" ? e.top : s.top;
        s.right = typeof e.right != "undefined" ? e.right : s.right;
        s.bottom = typeof e.bottom != "undefined" ? e.bottom : s.bottom;
        s.left = typeof e.left != "undefined" ? e.left : s.left;
        return L;
    };
    L.width = function(e) {
        if (!arguments.length) return o;
        o = e;
        return L;
    };
    L.height = function(e) {
        if (!arguments.length) return u;
        u = e;
        return L;
    };
    L.color = function(e) {
        if (!arguments.length) return a;
        a = nv.utils.getColor(e);
        r.color(a);
        return L;
    };
    L.showControls = function(e) {
        if (!arguments.length) return f;
        f = e;
        return L;
    };
    L.showLegend = function(e) {
        if (!arguments.length) return l;
        l = e;
        return L;
    };
    L.showXAxis = function(e) {
        if (!arguments.length) return c;
        c = e;
        return L;
    };
    L.showYAxis = function(e) {
        if (!arguments.length) return h;
        h = e;
        return L;
    };
    L.rightAlignYAxis = function(e) {
        if (!arguments.length) return p;
        p = e;
        n.orient(e ? "right" : "left");
        return L;
    };
    L.reduceXTicks = function(e) {
        if (!arguments.length) return d;
        d = e;
        return L;
    };
    L.rotateLabels = function(e) {
        if (!arguments.length) return m;
        m = e;
        return L;
    };
    L.staggerLabels = function(e) {
        if (!arguments.length) return v;
        v = e;
        return L;
    };
    L.tooltip = function(e) {
        if (!arguments.length) return y;
        y = e;
        return L;
    };
    L.tooltips = function(e) {
        if (!arguments.length) return g;
        g = e;
        return L;
    };
    L.tooltipContent = function(e) {
        if (!arguments.length) return y;
        y = e;
        return L;
    };
    L.state = function(e) {
        if (!arguments.length) return E;
        E = e;
        return L;
    };
    L.defaultState = function(e) {
        if (!arguments.length) return S;
        S = e;
        return L;
    };
    L.noData = function(e) {
        if (!arguments.length) return x;
        x = e;
        return L;
    };
    L.transitionDuration = function(e) {
        if (!arguments.length) return C;
        C = e;
        return L;
    };
    return L;
};
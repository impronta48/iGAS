nv.models.cumulativeLineChart = function() {
    "use strict";
    function M(y) {
        y.each(function(y) {
            function I(e, t) {
                d3.select(M.container).style("cursor", "ew-resize");
            }
            function q(e, t) {
                A.x = d3.event.x;
                A.i = Math.round(L.invert(A.x));
                nt();
            }
            function R(e, t) {
                d3.select(M.container).style("cursor", "auto");
                S.index = A.i;
                C.stateChange(S);
            }
            function nt() {
                tt.data([ A ]);
                var e = M.transitionDuration();
                M.transitionDuration(0);
                M.update();
                M.transitionDuration(e);
            }
            var D = d3.select(this).classed("nv-chart-" + E, !0), P = this, H = (a || parseInt(D.style("width")) || 960) - o.left - o.right, B = (f || parseInt(D.style("height")) || 400) - o.top - o.bottom;
            M.update = function() {
                D.transition().duration(k).call(M);
            };
            M.container = this;
            S.disabled = y.map(function(e) {
                return !!e.disabled;
            });
            if (!x) {
                var j;
                x = {};
                for (j in S) S[j] instanceof Array ? x[j] = S[j].slice(0) : x[j] = S[j];
            }
            var F = d3.behavior.drag().on("dragstart", I).on("drag", q).on("dragend", R);
            if (!y || !y.length || !y.filter(function(e) {
                return e.values.length;
            }).length) {
                var U = D.selectAll(".nv-noData").data([ T ]);
                U.enter().append("text").attr("class", "nvd3 nv-noData").attr("dy", "-.7em").style("text-anchor", "middle");
                U.attr("x", o.left + H / 2).attr("y", o.top + B / 2).text(function(e) {
                    return e;
                });
                return M;
            }
            D.selectAll(".nv-noData").remove();
            b = e.xScale();
            w = e.yScale();
            if (!g) {
                var z = y.filter(function(e) {
                    return !e.disabled;
                }).map(function(t, n) {
                    var r = d3.extent(t.values, e.y());
                    r[0] < -0.95 && (r[0] = -0.95);
                    return [ (r[0] - r[1]) / (1 + r[1]), (r[1] - r[0]) / (1 + r[0]) ];
                }), W = [ d3.min(z, function(e) {
                    return e[0];
                }), d3.max(z, function(e) {
                    return e[1];
                }) ];
                e.yDomain(W);
            } else e.yDomain(null);
            L.domain([ 0, y[0].values.length - 1 ]).range([ 0, H ]).clamp(!0);
            var y = _(A.i, y), X = m ? "none" : "all", V = D.selectAll("g.nv-wrap.nv-cumulativeLine").data([ y ]), $ = V.enter().append("g").attr("class", "nvd3 nv-wrap nv-cumulativeLine").append("g"), J = V.select("g");
            $.append("g").attr("class", "nv-interactive");
            $.append("g").attr("class", "nv-x nv-axis").style("pointer-events", "none");
            $.append("g").attr("class", "nv-y nv-axis");
            $.append("g").attr("class", "nv-background");
            $.append("g").attr("class", "nv-linesWrap").style("pointer-events", X);
            $.append("g").attr("class", "nv-avgLinesWrap").style("pointer-events", "none");
            $.append("g").attr("class", "nv-legendWrap");
            $.append("g").attr("class", "nv-controlsWrap");
            if (l) {
                r.width(H);
                J.select(".nv-legendWrap").datum(y).call(r);
                if (o.top != r.height()) {
                    o.top = r.height();
                    B = (f || parseInt(D.style("height")) || 400) - o.top - o.bottom;
                }
                J.select(".nv-legendWrap").attr("transform", "translate(0," + -o.top + ")");
            }
            if (v) {
                var K = [ {
                    key: "Re-scale y-axis",
                    disabled: !g
                } ];
                i.width(140).color([ "#444", "#444", "#444" ]);
                J.select(".nv-controlsWrap").datum(K).attr("transform", "translate(0," + -o.top + ")").call(i);
            }
            V.attr("transform", "translate(" + o.left + "," + o.top + ")");
            p && J.select(".nv-y.nv-axis").attr("transform", "translate(" + H + ",0)");
            var Q = y.filter(function(e) {
                return e.tempDisabled;
            });
            V.select(".tempDisabled").remove();
            Q.length && V.append("text").attr("class", "tempDisabled").attr("x", H / 2).attr("y", "-.71em").style("text-anchor", "end").text(Q.map(function(e) {
                return e.key;
            }).join(", ") + " values cannot be calculated for this time period.");
            if (m) {
                s.width(H).height(B).margin({
                    left: o.left,
                    top: o.top
                }).svgContainer(D).xScale(b);
                V.select(".nv-interactive").call(s);
            }
            $.select(".nv-background").append("rect");
            J.select(".nv-background rect").attr("width", H).attr("height", B);
            e.y(function(e) {
                return e.display.y;
            }).width(H).height(B).color(y.map(function(e, t) {
                return e.color || u(e, t);
            }).filter(function(e, t) {
                return !y[t].disabled && !y[t].tempDisabled;
            }));
            var G = J.select(".nv-linesWrap").datum(y.filter(function(e) {
                return !e.disabled && !e.tempDisabled;
            }));
            G.call(e);
            y.forEach(function(e, t) {
                e.seriesIndex = t;
            });
            var Y = y.filter(function(e) {
                return !e.disabled && !!N(e);
            }), Z = J.select(".nv-avgLinesWrap").selectAll("line").data(Y, function(e) {
                return e.key;
            }), et = function(e) {
                var t = w(N(e));
                return t < 0 ? 0 : t > B ? B : t;
            };
            Z.enter().append("line").style("stroke-width", 2).style("stroke-dasharray", "10,10").style("stroke", function(t, n) {
                return e.color()(t, t.seriesIndex);
            }).attr("x1", 0).attr("x2", H).attr("y1", et).attr("y2", et);
            Z.style("stroke-opacity", function(e) {
                var t = w(N(e));
                return t < 0 || t > B ? 0 : 1;
            }).attr("x1", 0).attr("x2", H).attr("y1", et).attr("y2", et);
            Z.exit().remove();
            var tt = G.selectAll(".nv-indexLine").data([ A ]);
            tt.enter().append("rect").attr("class", "nv-indexLine").attr("width", 3).attr("x", -2).attr("fill", "red").attr("fill-opacity", .5).style("pointer-events", "all").call(F);
            tt.attr("transform", function(e) {
                return "translate(" + L(e.i) + ",0)";
            }).attr("height", B);
            if (c) {
                t.scale(b).ticks(Math.min(y[0].values.length, H / 70)).tickSize(-B, 0);
                J.select(".nv-x.nv-axis").attr("transform", "translate(0," + w.range()[0] + ")");
                d3.transition(J.select(".nv-x.nv-axis")).call(t);
            }
            if (h) {
                n.scale(w).ticks(B / 36).tickSize(-H, 0);
                d3.transition(J.select(".nv-y.nv-axis")).call(n);
            }
            J.select(".nv-background rect").on("click", function() {
                A.x = d3.mouse(this)[0];
                A.i = Math.round(L.invert(A.x));
                S.index = A.i;
                C.stateChange(S);
                nt();
            });
            e.dispatch.on("elementClick", function(e) {
                A.i = e.pointIndex;
                A.x = L(A.i);
                S.index = A.i;
                C.stateChange(S);
                nt();
            });
            i.dispatch.on("legendClick", function(e, t) {
                e.disabled = !e.disabled;
                g = !e.disabled;
                S.rescaleY = g;
                C.stateChange(S);
                M.update();
            });
            r.dispatch.on("stateChange", function(e) {
                S.disabled = e.disabled;
                C.stateChange(S);
                M.update();
            });
            s.dispatch.on("elementMousemove", function(r) {
                e.clearHighlights();
                var i, a, f, l = [];
                y.filter(function(e, t) {
                    e.seriesIndex = t;
                    return !e.disabled;
                }).forEach(function(t, n) {
                    a = nv.interactiveBisect(t.values, r.pointXValue, M.x());
                    e.highlightPoint(n, a, !0);
                    var s = t.values[a];
                    if (typeof s == "undefined") return;
                    typeof i == "undefined" && (i = s);
                    typeof f == "undefined" && (f = M.xScale()(M.x()(s, a)));
                    l.push({
                        key: t.key,
                        value: M.y()(s, a),
                        color: u(t, t.seriesIndex)
                    });
                });
                var c = t.tickFormat()(M.x()(i, a));
                s.tooltip.position({
                    left: f + o.left,
                    top: r.mouseY + o.top
                }).chartContainer(P.parentNode).enabled(d).valueFormatter(function(e, t) {
                    return n.tickFormat()(e);
                }).data({
                    value: c,
                    series: l
                })();
                s.renderGuideLine(f);
            });
            s.dispatch.on("elementMouseout", function(t) {
                C.tooltipHide();
                e.clearHighlights();
            });
            C.on("tooltipShow", function(e) {
                d && O(e, P.parentNode);
            });
            C.on("changeState", function(e) {
                if (typeof e.disabled != "undefined") {
                    y.forEach(function(t, n) {
                        t.disabled = e.disabled[n];
                    });
                    S.disabled = e.disabled;
                }
                if (typeof e.index != "undefined") {
                    A.i = e.index;
                    A.x = L(A.i);
                    S.index = e.index;
                    tt.data([ A ]);
                }
                typeof e.rescaleY != "undefined" && (g = e.rescaleY);
                M.update();
            });
        });
        return M;
    }
    function _(t, n) {
        return n.map(function(n, r) {
            if (!n.values) return n;
            var i = e.y()(n.values[t], t);
            if (i < -0.95) {
                n.tempDisabled = !0;
                return n;
            }
            n.tempDisabled = !1;
            n.values = n.values.map(function(t, n) {
                t.display = {
                    y: (e.y()(t, n) - i) / (1 + i)
                };
                return t;
            });
            return n;
        });
    }
    var e = nv.models.line(), t = nv.models.axis(), n = nv.models.axis(), r = nv.models.legend(), i = nv.models.legend(), s = nv.interactiveGuideline(), o = {
        top: 30,
        right: 30,
        bottom: 50,
        left: 60
    }, u = nv.utils.defaultColor(), a = null, f = null, l = !0, c = !0, h = !0, p = !1, d = !0, v = !0, m = !1, g = !0, y = function(e, t, n, r, i) {
        return "<h3>" + e + "</h3>" + "<p>" + n + " at " + t + "</p>";
    }, b, w, E = e.id(), S = {
        index: 0,
        rescaleY: g
    }, x = null, T = "No Data Available.", N = function(e) {
        return e.average;
    }, C = d3.dispatch("tooltipShow", "tooltipHide", "stateChange", "changeState"), k = 250;
    t.orient("bottom").tickPadding(7);
    n.orient(p ? "right" : "left");
    i.updateState(!1);
    var L = d3.scale.linear(), A = {
        i: 0,
        x: 0
    }, O = function(r, i) {
        var s = r.pos[0] + (i.offsetLeft || 0), o = r.pos[1] + (i.offsetTop || 0), u = t.tickFormat()(e.x()(r.point, r.pointIndex)), a = n.tickFormat()(e.y()(r.point, r.pointIndex)), f = y(r.series.key, u, a, r, M);
        nv.tooltip.show([ s, o ], f, null, null, i);
    };
    e.dispatch.on("elementMouseover.tooltip", function(e) {
        e.pos = [ e.pos[0] + o.left, e.pos[1] + o.top ];
        C.tooltipShow(e);
    });
    e.dispatch.on("elementMouseout.tooltip", function(e) {
        C.tooltipHide(e);
    });
    C.on("tooltipHide", function() {
        d && nv.tooltip.cleanup();
    });
    M.dispatch = C;
    M.lines = e;
    M.legend = r;
    M.xAxis = t;
    M.yAxis = n;
    M.interactiveLayer = s;
    d3.rebind(M, e, "defined", "isArea", "x", "y", "xScale", "yScale", "size", "xDomain", "yDomain", "xRange", "yRange", "forceX", "forceY", "interactive", "clipEdge", "clipVoronoi", "useVoronoi", "id");
    M.options = nv.utils.optionsFunc.bind(M);
    M.margin = function(e) {
        if (!arguments.length) return o;
        o.top = typeof e.top != "undefined" ? e.top : o.top;
        o.right = typeof e.right != "undefined" ? e.right : o.right;
        o.bottom = typeof e.bottom != "undefined" ? e.bottom : o.bottom;
        o.left = typeof e.left != "undefined" ? e.left : o.left;
        return M;
    };
    M.width = function(e) {
        if (!arguments.length) return a;
        a = e;
        return M;
    };
    M.height = function(e) {
        if (!arguments.length) return f;
        f = e;
        return M;
    };
    M.color = function(e) {
        if (!arguments.length) return u;
        u = nv.utils.getColor(e);
        r.color(u);
        return M;
    };
    M.rescaleY = function(e) {
        if (!arguments.length) return g;
        g = e;
        return M;
    };
    M.showControls = function(e) {
        if (!arguments.length) return v;
        v = e;
        return M;
    };
    M.useInteractiveGuideline = function(e) {
        if (!arguments.length) return m;
        m = e;
        if (e === !0) {
            M.interactive(!1);
            M.useVoronoi(!1);
        }
        return M;
    };
    M.showLegend = function(e) {
        if (!arguments.length) return l;
        l = e;
        return M;
    };
    M.showXAxis = function(e) {
        if (!arguments.length) return c;
        c = e;
        return M;
    };
    M.showYAxis = function(e) {
        if (!arguments.length) return h;
        h = e;
        return M;
    };
    M.rightAlignYAxis = function(e) {
        if (!arguments.length) return p;
        p = e;
        n.orient(e ? "right" : "left");
        return M;
    };
    M.tooltips = function(e) {
        if (!arguments.length) return d;
        d = e;
        return M;
    };
    M.tooltipContent = function(e) {
        if (!arguments.length) return y;
        y = e;
        return M;
    };
    M.state = function(e) {
        if (!arguments.length) return S;
        S = e;
        return M;
    };
    M.defaultState = function(e) {
        if (!arguments.length) return x;
        x = e;
        return M;
    };
    M.noData = function(e) {
        if (!arguments.length) return T;
        T = e;
        return M;
    };
    M.average = function(e) {
        if (!arguments.length) return N;
        N = e;
        return M;
    };
    M.transitionDuration = function(e) {
        if (!arguments.length) return k;
        k = e;
        return M;
    };
    return M;
};
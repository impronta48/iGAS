nv.models.stackedAreaChart = function() {
    "use strict";
    function A(g) {
        g.each(function(g) {
            var O = d3.select(this), M = this, _ = (u || parseInt(O.style("width")) || 960) - o.left - o.right, D = (a || parseInt(O.style("height")) || 400) - o.top - o.bottom;
            A.update = function() {
                O.transition().duration(k).call(A);
            };
            A.container = this;
            E.disabled = g.map(function(e) {
                return !!e.disabled;
            });
            if (!S) {
                var P;
                S = {};
                for (P in E) E[P] instanceof Array ? S[P] = E[P].slice(0) : S[P] = E[P];
            }
            if (!g || !g.length || !g.filter(function(e) {
                return e.values.length;
            }).length) {
                var H = O.selectAll(".nv-noData").data([ x ]);
                H.enter().append("text").attr("class", "nvd3 nv-noData").attr("dy", "-.7em").style("text-anchor", "middle");
                H.attr("x", o.left + _ / 2).attr("y", o.top + D / 2).text(function(e) {
                    return e;
                });
                return A;
            }
            O.selectAll(".nv-noData").remove();
            y = e.xScale();
            b = e.yScale();
            var B = O.selectAll("g.nv-wrap.nv-stackedAreaChart").data([ g ]), j = B.enter().append("g").attr("class", "nvd3 nv-wrap nv-stackedAreaChart").append("g"), F = B.select("g");
            j.append("rect").style("opacity", 0);
            j.append("g").attr("class", "nv-x nv-axis");
            j.append("g").attr("class", "nv-y nv-axis");
            j.append("g").attr("class", "nv-stackedWrap");
            j.append("g").attr("class", "nv-legendWrap");
            j.append("g").attr("class", "nv-controlsWrap");
            j.append("g").attr("class", "nv-interactive");
            F.select("rect").attr("width", _).attr("height", D);
            if (c) {
                var I = l ? _ - N : _;
                r.width(I);
                F.select(".nv-legendWrap").datum(g).call(r);
                if (o.top != r.height()) {
                    o.top = r.height();
                    D = (a || parseInt(O.style("height")) || 400) - o.top - o.bottom;
                }
                F.select(".nv-legendWrap").attr("transform", "translate(" + (_ - I) + "," + -o.top + ")");
            }
            if (l) {
                var q = [ {
                    key: "Stacked",
                    disabled: e.offset() != "zero"
                }, {
                    key: "Stream",
                    disabled: e.offset() != "wiggle"
                }, {
                    key: "Expanded",
                    disabled: e.offset() != "expand"
                } ];
                N = C.length / 3 * 260;
                q = q.filter(function(e) {
                    return C.indexOf(e.key) > -1;
                });
                i.width(N).color([ "#444", "#444", "#444" ]);
                F.select(".nv-controlsWrap").datum(q).call(i);
                if (o.top != Math.max(i.height(), r.height())) {
                    o.top = Math.max(i.height(), r.height());
                    D = (a || parseInt(O.style("height")) || 400) - o.top - o.bottom;
                }
                F.select(".nv-controlsWrap").attr("transform", "translate(0," + -o.top + ")");
            }
            B.attr("transform", "translate(" + o.left + "," + o.top + ")");
            d && F.select(".nv-y.nv-axis").attr("transform", "translate(" + _ + ",0)");
            if (v) {
                s.width(_).height(D).margin({
                    left: o.left,
                    top: o.top
                }).svgContainer(O).xScale(y);
                B.select(".nv-interactive").call(s);
            }
            e.width(_).height(D);
            var R = F.select(".nv-stackedWrap").datum(g);
            R.transition().call(e);
            if (h) {
                t.scale(y).ticks(_ / 100).tickSize(-D, 0);
                F.select(".nv-x.nv-axis").attr("transform", "translate(0," + D + ")");
                F.select(".nv-x.nv-axis").transition().duration(0).call(t);
            }
            if (p) {
                n.scale(b).ticks(e.offset() == "wiggle" ? 0 : D / 36).tickSize(-_, 0).setTickFormat(e.offset() == "expand" ? d3.format("%") : w);
                F.select(".nv-y.nv-axis").transition().duration(0).call(n);
            }
            e.dispatch.on("areaClick.toggle", function(e) {
                g.filter(function(e) {
                    return !e.disabled;
                }).length === 1 ? g = g.map(function(e) {
                    e.disabled = !1;
                    return e;
                }) : g = g.map(function(t, n) {
                    t.disabled = n != e.seriesIndex;
                    return t;
                });
                E.disabled = g.map(function(e) {
                    return !!e.disabled;
                });
                T.stateChange(E);
                A.update();
            });
            r.dispatch.on("stateChange", function(e) {
                E.disabled = e.disabled;
                T.stateChange(E);
                A.update();
            });
            i.dispatch.on("legendClick", function(t, n) {
                if (!t.disabled) return;
                q = q.map(function(e) {
                    e.disabled = !0;
                    return e;
                });
                t.disabled = !1;
                switch (t.key) {
                  case "Stacked":
                    e.style("stack");
                    break;
                  case "Stream":
                    e.style("stream");
                    break;
                  case "Expanded":
                    e.style("expand");
                }
                E.style = e.style();
                T.stateChange(E);
                A.update();
            });
            s.dispatch.on("elementMousemove", function(r) {
                e.clearHighlights();
                var i, u, a, l = [];
                g.filter(function(e, t) {
                    e.seriesIndex = t;
                    return !e.disabled;
                }).forEach(function(t, n) {
                    u = nv.interactiveBisect(t.values, r.pointXValue, A.x());
                    e.highlightPoint(n, u, !0);
                    var s = t.values[u];
                    if (typeof s == "undefined") return;
                    typeof i == "undefined" && (i = s);
                    typeof a == "undefined" && (a = A.xScale()(A.x()(s, u)));
                    l.push({
                        key: t.key,
                        value: A.y()(s, u),
                        color: f(t, t.seriesIndex)
                    });
                });
                var c = t.tickFormat()(A.x()(i, u));
                s.tooltip.position({
                    left: a + o.left,
                    top: r.mouseY + o.top
                }).chartContainer(M.parentNode).enabled(m).valueFormatter(function(e, t) {
                    return n.tickFormat()(e);
                }).data({
                    value: c,
                    series: l
                })();
                s.renderGuideLine(a);
            });
            s.dispatch.on("elementMouseout", function(t) {
                T.tooltipHide();
                e.clearHighlights();
            });
            T.on("tooltipShow", function(e) {
                m && L(e, M.parentNode);
            });
            T.on("changeState", function(t) {
                if (typeof t.disabled != "undefined") {
                    g.forEach(function(e, n) {
                        e.disabled = t.disabled[n];
                    });
                    E.disabled = t.disabled;
                }
                typeof t.style != "undefined" && e.style(t.style);
                A.update();
            });
        });
        return A;
    }
    var e = nv.models.stackedArea(), t = nv.models.axis(), n = nv.models.axis(), r = nv.models.legend(), i = nv.models.legend(), s = nv.interactiveGuideline(), o = {
        top: 30,
        right: 25,
        bottom: 50,
        left: 60
    }, u = null, a = null, f = nv.utils.defaultColor(), l = !0, c = !0, h = !0, p = !0, d = !1, v = !1, m = !0, g = function(e, t, n, r, i) {
        return "<h3>" + e + "</h3>" + "<p>" + n + " on " + t + "</p>";
    }, y, b, w = d3.format(",.2f"), E = {
        style: e.style()
    }, S = null, x = "No Data Available.", T = d3.dispatch("tooltipShow", "tooltipHide", "stateChange", "changeState"), N = 250, C = [ "Stacked", "Stream", "Expanded" ], k = 250;
    t.orient("bottom").tickPadding(7);
    n.orient(d ? "right" : "left");
    i.updateState(!1);
    var L = function(r, i) {
        var s = r.pos[0] + (i.offsetLeft || 0), o = r.pos[1] + (i.offsetTop || 0), u = t.tickFormat()(e.x()(r.point, r.pointIndex)), a = n.tickFormat()(e.y()(r.point, r.pointIndex)), f = g(r.series.key, u, a, r, A);
        nv.tooltip.show([ s, o ], f, r.value < 0 ? "n" : "s", null, i);
    };
    e.dispatch.on("tooltipShow", function(e) {
        e.pos = [ e.pos[0] + o.left, e.pos[1] + o.top ], T.tooltipShow(e);
    });
    e.dispatch.on("tooltipHide", function(e) {
        T.tooltipHide(e);
    });
    T.on("tooltipHide", function() {
        m && nv.tooltip.cleanup();
    });
    A.dispatch = T;
    A.stacked = e;
    A.legend = r;
    A.controls = i;
    A.xAxis = t;
    A.yAxis = n;
    A.interactiveLayer = s;
    d3.rebind(A, e, "x", "y", "size", "xScale", "yScale", "xDomain", "yDomain", "xRange", "yRange", "sizeDomain", "interactive", "useVoronoi", "offset", "order", "style", "clipEdge", "forceX", "forceY", "forceSize", "interpolate");
    A.options = nv.utils.optionsFunc.bind(A);
    A.margin = function(e) {
        if (!arguments.length) return o;
        o.top = typeof e.top != "undefined" ? e.top : o.top;
        o.right = typeof e.right != "undefined" ? e.right : o.right;
        o.bottom = typeof e.bottom != "undefined" ? e.bottom : o.bottom;
        o.left = typeof e.left != "undefined" ? e.left : o.left;
        return A;
    };
    A.width = function(e) {
        if (!arguments.length) return u;
        u = e;
        return A;
    };
    A.height = function(e) {
        if (!arguments.length) return a;
        a = e;
        return A;
    };
    A.color = function(t) {
        if (!arguments.length) return f;
        f = nv.utils.getColor(t);
        r.color(f);
        e.color(f);
        return A;
    };
    A.showControls = function(e) {
        if (!arguments.length) return l;
        l = e;
        return A;
    };
    A.showLegend = function(e) {
        if (!arguments.length) return c;
        c = e;
        return A;
    };
    A.showXAxis = function(e) {
        if (!arguments.length) return h;
        h = e;
        return A;
    };
    A.showYAxis = function(e) {
        if (!arguments.length) return p;
        p = e;
        return A;
    };
    A.rightAlignYAxis = function(e) {
        if (!arguments.length) return d;
        d = e;
        n.orient(e ? "right" : "left");
        return A;
    };
    A.useInteractiveGuideline = function(e) {
        if (!arguments.length) return v;
        v = e;
        if (e === !0) {
            A.interactive(!1);
            A.useVoronoi(!1);
        }
        return A;
    };
    A.tooltip = function(e) {
        if (!arguments.length) return g;
        g = e;
        return A;
    };
    A.tooltips = function(e) {
        if (!arguments.length) return m;
        m = e;
        return A;
    };
    A.tooltipContent = function(e) {
        if (!arguments.length) return g;
        g = e;
        return A;
    };
    A.state = function(e) {
        if (!arguments.length) return E;
        E = e;
        return A;
    };
    A.defaultState = function(e) {
        if (!arguments.length) return S;
        S = e;
        return A;
    };
    A.noData = function(e) {
        if (!arguments.length) return x;
        x = e;
        return A;
    };
    A.transitionDuration = function(e) {
        if (!arguments.length) return k;
        k = e;
        return A;
    };
    A.controlsData = function(e) {
        if (!arguments.length) return C;
        C = e;
        return A;
    };
    n.setTickFormat = n.tickFormat;
    n.tickFormat = function(e) {
        if (!arguments.length) return w;
        w = e;
        return n;
    };
    return A;
};
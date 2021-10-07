nv.models.linePlusBarChart = function() {
    "use strict";
    function x(f) {
        f.each(function(f) {
            var l = d3.select(this), d = this, T = (u || parseInt(l.style("width")) || 960) - o.left - o.right, N = (a || parseInt(l.style("height")) || 400) - o.top - o.bottom;
            x.update = function() {
                l.transition().call(x);
            };
            y.disabled = f.map(function(e) {
                return !!e.disabled;
            });
            if (!b) {
                var C;
                b = {};
                for (C in y) y[C] instanceof Array ? b[C] = y[C].slice(0) : b[C] = y[C];
            }
            if (!f || !f.length || !f.filter(function(e) {
                return e.values.length;
            }).length) {
                var k = l.selectAll(".nv-noData").data([ w ]);
                k.enter().append("text").attr("class", "nvd3 nv-noData").attr("dy", "-.7em").style("text-anchor", "middle");
                k.attr("x", o.left + T / 2).attr("y", o.top + N / 2).text(function(e) {
                    return e;
                });
                return x;
            }
            l.selectAll(".nv-noData").remove();
            var L = f.filter(function(e) {
                return !e.disabled && e.bar;
            }), A = f.filter(function(e) {
                return !e.bar;
            });
            v = A.filter(function(e) {
                return !e.disabled;
            }).length && A.filter(function(e) {
                return !e.disabled;
            })[0].values.length ? e.xScale() : t.xScale();
            m = t.yScale();
            g = e.yScale();
            var O = d3.select(this).selectAll("g.nv-wrap.nv-linePlusBar").data([ f ]), M = O.enter().append("g").attr("class", "nvd3 nv-wrap nv-linePlusBar").append("g"), _ = O.select("g");
            M.append("g").attr("class", "nv-x nv-axis");
            M.append("g").attr("class", "nv-y1 nv-axis");
            M.append("g").attr("class", "nv-y2 nv-axis");
            M.append("g").attr("class", "nv-barsWrap");
            M.append("g").attr("class", "nv-linesWrap");
            M.append("g").attr("class", "nv-legendWrap");
            if (h) {
                s.width(T / 2);
                _.select(".nv-legendWrap").datum(f.map(function(e) {
                    e.originalKey = e.originalKey === undefined ? e.key : e.originalKey;
                    e.key = e.originalKey + (e.bar ? " (left axis)" : " (right axis)");
                    return e;
                })).call(s);
                if (o.top != s.height()) {
                    o.top = s.height();
                    N = (a || parseInt(l.style("height")) || 400) - o.top - o.bottom;
                }
                _.select(".nv-legendWrap").attr("transform", "translate(" + T / 2 + "," + -o.top + ")");
            }
            O.attr("transform", "translate(" + o.left + "," + o.top + ")");
            e.width(T).height(N).color(f.map(function(e, t) {
                return e.color || c(e, t);
            }).filter(function(e, t) {
                return !f[t].disabled && !f[t].bar;
            }));
            t.width(T).height(N).color(f.map(function(e, t) {
                return e.color || c(e, t);
            }).filter(function(e, t) {
                return !f[t].disabled && f[t].bar;
            }));
            var D = _.select(".nv-barsWrap").datum(L.length ? L : [ {
                values: []
            } ]), P = _.select(".nv-linesWrap").datum(A[0] && !A[0].disabled ? A : [ {
                values: []
            } ]);
            d3.transition(D).call(t);
            d3.transition(P).call(e);
            n.scale(v).ticks(T / 100).tickSize(-N, 0);
            _.select(".nv-x.nv-axis").attr("transform", "translate(0," + m.range()[0] + ")");
            d3.transition(_.select(".nv-x.nv-axis")).call(n);
            r.scale(m).ticks(N / 36).tickSize(-T, 0);
            d3.transition(_.select(".nv-y1.nv-axis")).style("opacity", L.length ? 1 : 0).call(r);
            i.scale(g).ticks(N / 36).tickSize(L.length ? 0 : -T, 0);
            _.select(".nv-y2.nv-axis").style("opacity", A.length ? 1 : 0).attr("transform", "translate(" + T + ",0)");
            d3.transition(_.select(".nv-y2.nv-axis")).call(i);
            s.dispatch.on("stateChange", function(e) {
                y = e;
                E.stateChange(y);
                x.update();
            });
            E.on("tooltipShow", function(e) {
                p && S(e, d.parentNode);
            });
            E.on("changeState", function(e) {
                if (typeof e.disabled != "undefined") {
                    f.forEach(function(t, n) {
                        t.disabled = e.disabled[n];
                    });
                    y.disabled = e.disabled;
                }
                x.update();
            });
        });
        return x;
    }
    var e = nv.models.line(), t = nv.models.historicalBar(), n = nv.models.axis(), r = nv.models.axis(), i = nv.models.axis(), s = nv.models.legend(), o = {
        top: 30,
        right: 60,
        bottom: 50,
        left: 60
    }, u = null, a = null, f = function(e) {
        return e.x;
    }, l = function(e) {
        return e.y;
    }, c = nv.utils.defaultColor(), h = !0, p = !0, d = function(e, t, n, r, i) {
        return "<h3>" + e + "</h3>" + "<p>" + n + " at " + t + "</p>";
    }, v, m, g, y = {}, b = null, w = "No Data Available.", E = d3.dispatch("tooltipShow", "tooltipHide", "stateChange", "changeState");
    t.padData(!0);
    e.clipEdge(!1).padData(!0);
    n.orient("bottom").tickPadding(7).highlightZero(!1);
    r.orient("left");
    i.orient("right");
    var S = function(t, s) {
        var o = t.pos[0] + (s.offsetLeft || 0), u = t.pos[1] + (s.offsetTop || 0), a = n.tickFormat()(e.x()(t.point, t.pointIndex)), f = (t.series.bar ? r : i).tickFormat()(e.y()(t.point, t.pointIndex)), l = d(t.series.key, a, f, t, x);
        nv.tooltip.show([ o, u ], l, t.value < 0 ? "n" : "s", null, s);
    };
    e.dispatch.on("elementMouseover.tooltip", function(e) {
        e.pos = [ e.pos[0] + o.left, e.pos[1] + o.top ];
        E.tooltipShow(e);
    });
    e.dispatch.on("elementMouseout.tooltip", function(e) {
        E.tooltipHide(e);
    });
    t.dispatch.on("elementMouseover.tooltip", function(e) {
        e.pos = [ e.pos[0] + o.left, e.pos[1] + o.top ];
        E.tooltipShow(e);
    });
    t.dispatch.on("elementMouseout.tooltip", function(e) {
        E.tooltipHide(e);
    });
    E.on("tooltipHide", function() {
        p && nv.tooltip.cleanup();
    });
    x.dispatch = E;
    x.legend = s;
    x.lines = e;
    x.bars = t;
    x.xAxis = n;
    x.y1Axis = r;
    x.y2Axis = i;
    d3.rebind(x, e, "defined", "size", "clipVoronoi", "interpolate");
    x.options = nv.utils.optionsFunc.bind(x);
    x.x = function(n) {
        if (!arguments.length) return f;
        f = n;
        e.x(n);
        t.x(n);
        return x;
    };
    x.y = function(n) {
        if (!arguments.length) return l;
        l = n;
        e.y(n);
        t.y(n);
        return x;
    };
    x.margin = function(e) {
        if (!arguments.length) return o;
        o.top = typeof e.top != "undefined" ? e.top : o.top;
        o.right = typeof e.right != "undefined" ? e.right : o.right;
        o.bottom = typeof e.bottom != "undefined" ? e.bottom : o.bottom;
        o.left = typeof e.left != "undefined" ? e.left : o.left;
        return x;
    };
    x.width = function(e) {
        if (!arguments.length) return u;
        u = e;
        return x;
    };
    x.height = function(e) {
        if (!arguments.length) return a;
        a = e;
        return x;
    };
    x.color = function(e) {
        if (!arguments.length) return c;
        c = nv.utils.getColor(e);
        s.color(c);
        return x;
    };
    x.showLegend = function(e) {
        if (!arguments.length) return h;
        h = e;
        return x;
    };
    x.tooltips = function(e) {
        if (!arguments.length) return p;
        p = e;
        return x;
    };
    x.tooltipContent = function(e) {
        if (!arguments.length) return d;
        d = e;
        return x;
    };
    x.state = function(e) {
        if (!arguments.length) return y;
        y = e;
        return x;
    };
    x.defaultState = function(e) {
        if (!arguments.length) return b;
        b = e;
        return x;
    };
    x.noData = function(e) {
        if (!arguments.length) return w;
        w = e;
        return x;
    };
    return x;
};
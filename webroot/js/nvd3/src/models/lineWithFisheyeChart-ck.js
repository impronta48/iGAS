nv.models.lineChart = function() {
    "use strict";
    function E(f) {
        f.each(function(f) {
            function M() {
                if (u) {
                    A.select(".nv-point-paths").style("pointer-events", "all");
                    return !1;
                }
                A.select(".nv-background").style("pointer-events", "all");
                A.select(".nv-point-paths").style("pointer-events", "none");
                var e = d3.mouse(this);
                O.call(h);
                A.select(".nv-x.nv-axis").call(d);
                c.distortion(o).focus(e[0]);
            }
            var S = d3.select(this), T = this, N = (n || parseInt(S.style("width")) || 960) - e.left - e.right, C = (r || parseInt(S.style("height")) || 400) - e.top - e.bottom;
            E.update = function() {
                S.transition().call(E);
            };
            E.container = this;
            if (!f || !f.length || !f.filter(function(e) {
                return e.values.length;
            }).length) {
                S.append("text").attr("class", "nvd3 nv-noData").attr("x", N / 2).attr("y", C / 2).attr("dy", "-.7em").style("text-anchor", "middle").text(l);
                return E;
            }
            S.select(".nv-noData").remove();
            var k = S.selectAll("g.nv-wrap.nv-lineChart").data([ f ]), L = k.enter().append("g").attr("class", "nvd3 nv-wrap nv-lineChart").append("g");
            L.append("rect").attr("class", "nvd3 nv-background").attr("width", N).attr("height", C);
            L.append("g").attr("class", "nv-x nv-axis");
            L.append("g").attr("class", "nv-y nv-axis");
            L.append("g").attr("class", "nv-linesWrap");
            L.append("g").attr("class", "nv-legendWrap");
            L.append("g").attr("class", "nv-controlsWrap");
            L.append("g").attr("class", "nv-controlsWrap");
            var A = k.select("g");
            if (i) {
                m.width(N);
                A.select(".nv-legendWrap").datum(f).call(m);
                if (e.top != m.height()) {
                    e.top = m.height();
                    C = (r || parseInt(S.style("height")) || 400) - e.top - e.bottom;
                }
                A.select(".nv-legendWrap").attr("transform", "translate(0," + -e.top + ")");
            }
            if (s) {
                g.width(180).color([ "#444" ]);
                A.select(".nv-controlsWrap").datum(w).attr("transform", "translate(0," + -e.top + ")").call(g);
            }
            h.width(N).height(C).color(f.map(function(e, n) {
                return e.color || t(e, n);
            }).filter(function(e, t) {
                return !f[t].disabled;
            }));
            A.attr("transform", "translate(" + e.left + "," + e.top + ")");
            var O = A.select(".nv-linesWrap").datum(f.filter(function(e) {
                return !e.disabled;
            }));
            d3.transition(O).call(h);
            d.ticks(N / 100).tickSize(-C, 0);
            A.select(".nv-x.nv-axis").attr("transform", "translate(0," + p.range()[0] + ")");
            d3.transition(A.select(".nv-x.nv-axis")).call(d);
            v.ticks(C / 36).tickSize(-N, 0);
            d3.transition(A.select(".nv-y.nv-axis")).call(v);
            A.select(".nv-background").on("mousemove", M);
            A.select(".nv-background").on("click", function() {
                u = !u;
            });
            g.dispatch.on("legendClick", function(e, t) {
                e.disabled = !e.disabled;
                o = e.disabled ? 0 : 5;
                A.select(".nv-background").style("pointer-events", e.disabled ? "none" : "all");
                A.select(".nv-point-paths").style("pointer-events", e.disabled ? "all" : "none");
                if (e.disabled) {
                    c.distortion(o).focus(0);
                    O.call(h);
                    A.select(".nv-x.nv-axis").call(d);
                } else u = !1;
                E.update();
            });
            m.dispatch.on("stateChange", function(e) {
                E.update();
            });
            h.dispatch.on("elementMouseover.tooltip", function(t) {
                t.pos = [ t.pos[0] + e.left, t.pos[1] + e.top ];
                y.tooltipShow(t);
            });
            a && y.on("tooltipShow", function(e) {
                b(e, T.parentNode);
            });
            h.dispatch.on("elementMouseout.tooltip", function(e) {
                y.tooltipHide(e);
            });
            a && y.on("tooltipHide", nv.tooltip.cleanup);
        });
        return E;
    }
    var e = {
        top: 30,
        right: 20,
        bottom: 50,
        left: 60
    }, t = nv.utils.defaultColor(), n = null, r = null, i = !0, s = !0, o = 0, u = !1, a = !0, f = function(e, t, n, r, i) {
        return "<h3>" + e + "</h3>" + "<p>" + n + " at " + t + "</p>";
    }, l = "No Data Available.", c = d3.fisheye.scale(d3.scale.linear).distortion(0), h = nv.models.line().xScale(c), p = h.yScale(), d = nv.models.axis().scale(c).orient("bottom").tickPadding(5), v = nv.models.axis().scale(p).orient("left"), m = nv.models.legend().height(30), g = nv.models.legend().height(30).updateState(!1), y = d3.dispatch("tooltipShow", "tooltipHide"), b = function(e, t) {
        var n = e.pos[0] + (t.offsetLeft || 0), r = e.pos[1] + (t.offsetTop || 0), i = d.tickFormat()(h.x()(e.point, e.pointIndex)), s = v.tickFormat()(h.y()(e.point, e.pointIndex)), o = f(e.series.key, i, s, e, E);
        nv.tooltip.show([ n, r ], o, null, null, t);
    }, w = [ {
        key: "Magnify",
        disabled: !0
    } ];
    E.dispatch = y;
    E.legend = m;
    E.xAxis = d;
    E.yAxis = v;
    d3.rebind(E, h, "defined", "x", "y", "size", "xDomain", "yDomain", "xRange", "yRange", "forceX", "forceY", "interactive", "clipEdge", "clipVoronoi", "id", "interpolate");
    E.options = nv.utils.optionsFunc.bind(E);
    E.margin = function(t) {
        if (!arguments.length) return e;
        e = t;
        return E;
    };
    E.width = function(e) {
        if (!arguments.length) return n;
        n = e;
        return E;
    };
    E.height = function(e) {
        if (!arguments.length) return r;
        r = e;
        return E;
    };
    E.color = function(e) {
        if (!arguments.length) return t;
        t = nv.utils.getColor(e);
        m.color(t);
        return E;
    };
    E.showLegend = function(e) {
        if (!arguments.length) return i;
        i = e;
        return E;
    };
    E.tooltips = function(e) {
        if (!arguments.length) return a;
        a = e;
        return E;
    };
    E.tooltipContent = function(e) {
        if (!arguments.length) return f;
        f = e;
        return E;
    };
    E.noData = function(e) {
        if (!arguments.length) return l;
        l = e;
        return E;
    };
    return E;
};
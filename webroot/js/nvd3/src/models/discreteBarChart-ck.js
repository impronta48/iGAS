nv.models.discreteBarChart = function() {
    "use strict";
    function b(o) {
        o.each(function(o) {
            var h = d3.select(this), w = this, E = (i || parseInt(h.style("width")) || 960) - r.left - r.right, S = (s || parseInt(h.style("height")) || 400) - r.top - r.bottom;
            b.update = function() {
                m.beforeUpdate();
                h.transition().duration(g).call(b);
            };
            b.container = this;
            if (!o || !o.length || !o.filter(function(e) {
                return e.values.length;
            }).length) {
                var T = h.selectAll(".nv-noData").data([ v ]);
                T.enter().append("text").attr("class", "nvd3 nv-noData").attr("dy", "-.7em").style("text-anchor", "middle");
                T.attr("x", r.left + E / 2).attr("y", r.top + S / 2).text(function(e) {
                    return e;
                });
                return b;
            }
            h.selectAll(".nv-noData").remove();
            p = e.xScale();
            d = e.yScale().clamp(!0);
            var N = h.selectAll("g.nv-wrap.nv-discreteBarWithAxes").data([ o ]), C = N.enter().append("g").attr("class", "nvd3 nv-wrap nv-discreteBarWithAxes").append("g"), k = C.append("defs"), L = N.select("g");
            C.append("g").attr("class", "nv-x nv-axis");
            C.append("g").attr("class", "nv-y nv-axis");
            C.append("g").attr("class", "nv-barsWrap");
            L.attr("transform", "translate(" + r.left + "," + r.top + ")");
            f && L.select(".nv-y.nv-axis").attr("transform", "translate(" + E + ",0)");
            e.width(E).height(S);
            var A = L.select(".nv-barsWrap").datum(o.filter(function(e) {
                return !e.disabled;
            }));
            A.transition().call(e);
            k.append("clipPath").attr("id", "nv-x-label-clip-" + e.id()).append("rect");
            L.select("#nv-x-label-clip-" + e.id() + " rect").attr("width", p.rangeBand() * (l ? 2 : 1)).attr("height", 16).attr("x", -p.rangeBand() / (l ? 1 : 2));
            if (u) {
                t.scale(p).ticks(E / 100).tickSize(-S, 0);
                L.select(".nv-x.nv-axis").attr("transform", "translate(0," + (d.range()[0] + (e.showValues() && d.domain()[0] < 0 ? 16 : 0)) + ")");
                L.select(".nv-x.nv-axis").transition().call(t);
                var O = L.select(".nv-x.nv-axis").selectAll("g");
                l && O.selectAll("text").attr("transform", function(e, t, n) {
                    return "translate(0," + (n % 2 == 0 ? "5" : "17") + ")";
                });
            }
            if (a) {
                n.scale(d).ticks(S / 36).tickSize(-E, 0);
                L.select(".nv-y.nv-axis").transition().call(n);
            }
            m.on("tooltipShow", function(e) {
                c && y(e, w.parentNode);
            });
        });
        return b;
    }
    var e = nv.models.discreteBar(), t = nv.models.axis(), n = nv.models.axis(), r = {
        top: 15,
        right: 10,
        bottom: 50,
        left: 60
    }, i = null, s = null, o = nv.utils.getColor(), u = !0, a = !0, f = !1, l = !1, c = !0, h = function(e, t, n, r, i) {
        return "<h3>" + t + "</h3>" + "<p>" + n + "</p>";
    }, p, d, v = "No Data Available.", m = d3.dispatch("tooltipShow", "tooltipHide", "beforeUpdate"), g = 250;
    t.orient("bottom").highlightZero(!1).showMaxMin(!1).tickFormat(function(e) {
        return e;
    });
    n.orient(f ? "right" : "left").tickFormat(d3.format(",.1f"));
    var y = function(r, i) {
        var s = r.pos[0] + (i.offsetLeft || 0), o = r.pos[1] + (i.offsetTop || 0), u = t.tickFormat()(e.x()(r.point, r.pointIndex)), a = n.tickFormat()(e.y()(r.point, r.pointIndex)), f = h(r.series.key, u, a, r, b);
        nv.tooltip.show([ s, o ], f, r.value < 0 ? "n" : "s", null, i);
    };
    e.dispatch.on("elementMouseover.tooltip", function(e) {
        e.pos = [ e.pos[0] + r.left, e.pos[1] + r.top ];
        m.tooltipShow(e);
    });
    e.dispatch.on("elementMouseout.tooltip", function(e) {
        m.tooltipHide(e);
    });
    m.on("tooltipHide", function() {
        c && nv.tooltip.cleanup();
    });
    b.dispatch = m;
    b.discretebar = e;
    b.xAxis = t;
    b.yAxis = n;
    d3.rebind(b, e, "x", "y", "xDomain", "yDomain", "xRange", "yRange", "forceX", "forceY", "id", "showValues", "valueFormat");
    b.options = nv.utils.optionsFunc.bind(b);
    b.margin = function(e) {
        if (!arguments.length) return r;
        r.top = typeof e.top != "undefined" ? e.top : r.top;
        r.right = typeof e.right != "undefined" ? e.right : r.right;
        r.bottom = typeof e.bottom != "undefined" ? e.bottom : r.bottom;
        r.left = typeof e.left != "undefined" ? e.left : r.left;
        return b;
    };
    b.width = function(e) {
        if (!arguments.length) return i;
        i = e;
        return b;
    };
    b.height = function(e) {
        if (!arguments.length) return s;
        s = e;
        return b;
    };
    b.color = function(t) {
        if (!arguments.length) return o;
        o = nv.utils.getColor(t);
        e.color(o);
        return b;
    };
    b.showXAxis = function(e) {
        if (!arguments.length) return u;
        u = e;
        return b;
    };
    b.showYAxis = function(e) {
        if (!arguments.length) return a;
        a = e;
        return b;
    };
    b.rightAlignYAxis = function(e) {
        if (!arguments.length) return f;
        f = e;
        n.orient(e ? "right" : "left");
        return b;
    };
    b.staggerLabels = function(e) {
        if (!arguments.length) return l;
        l = e;
        return b;
    };
    b.tooltips = function(e) {
        if (!arguments.length) return c;
        c = e;
        return b;
    };
    b.tooltipContent = function(e) {
        if (!arguments.length) return h;
        h = e;
        return b;
    };
    b.noData = function(e) {
        if (!arguments.length) return v;
        v = e;
        return b;
    };
    b.transitionDuration = function(e) {
        if (!arguments.length) return g;
        g = e;
        return b;
    };
    return b;
};
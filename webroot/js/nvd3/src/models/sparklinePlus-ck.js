nv.models.sparklinePlus = function() {
    "use strict";
    function d(l) {
        l.each(function(v) {
            function O() {
                if (u) return;
                var n = C.selectAll(".nv-hoverValue").data(o), r = n.enter().append("g").attr("class", "nv-hoverValue").style("stroke-opacity", 0).style("fill-opacity", 0);
                n.exit().transition().duration(250).style("stroke-opacity", 0).style("fill-opacity", 0).remove();
                n.attr("transform", function(t) {
                    return "translate(" + i(e.x()(v[t], t)) + ",0)";
                }).transition().duration(250).style("stroke-opacity", 1).style("fill-opacity", 1);
                if (!o.length) return;
                r.append("line").attr("x1", 0).attr("y1", -t.top).attr("x2", 0).attr("y2", b);
                r.append("text").attr("class", "nv-xValue").attr("x", -6).attr("y", -t.top).attr("text-anchor", "end").attr("dy", ".9em");
                C.select(".nv-hoverValue .nv-xValue").text(a(e.x()(v[o[0]], o[0])));
                r.append("text").attr("class", "nv-yValue").attr("x", 6).attr("y", -t.top).attr("text-anchor", "start").attr("dy", ".9em");
                C.select(".nv-hoverValue .nv-yValue").text(f(e.y()(v[o[0]], o[0])));
            }
            function M() {
                function r(t, n) {
                    var r = Math.abs(e.x()(t[0], 0) - n), i = 0;
                    for (var s = 0; s < t.length; s++) if (Math.abs(e.x()(t[s], s) - n) < r) {
                        r = Math.abs(e.x()(t[s], s) - n);
                        i = s;
                    }
                    return i;
                }
                if (u) return;
                var n = d3.mouse(this)[0] - t.left;
                o = [ r(v, Math.round(i.invert(n))) ];
                O();
            }
            var m = d3.select(this), g = (n || parseInt(m.style("width")) || 960) - t.left - t.right, b = (r || parseInt(m.style("height")) || 400) - t.top - t.bottom;
            d.update = function() {
                d(l);
            };
            d.container = this;
            if (!v || !v.length) {
                var w = m.selectAll(".nv-noData").data([ p ]);
                w.enter().append("text").attr("class", "nvd3 nv-noData").attr("dy", "-.7em").style("text-anchor", "middle");
                w.attr("x", t.left + g / 2).attr("y", t.top + b / 2).text(function(e) {
                    return e;
                });
                return d;
            }
            m.selectAll(".nv-noData").remove();
            var E = e.y()(v[v.length - 1], v.length - 1);
            i = e.xScale();
            s = e.yScale();
            var S = m.selectAll("g.nv-wrap.nv-sparklineplus").data([ v ]), T = S.enter().append("g").attr("class", "nvd3 nv-wrap nv-sparklineplus"), N = T.append("g"), C = S.select("g");
            N.append("g").attr("class", "nv-sparklineWrap");
            N.append("g").attr("class", "nv-valueWrap");
            N.append("g").attr("class", "nv-hoverArea");
            S.attr("transform", "translate(" + t.left + "," + t.top + ")");
            var k = C.select(".nv-sparklineWrap");
            e.width(g).height(b);
            k.call(e);
            var L = C.select(".nv-valueWrap"), A = L.selectAll(".nv-currentValue").data([ E ]);
            A.enter().append("text").attr("class", "nv-currentValue").attr("dx", h ? -8 : 8).attr("dy", ".9em").style("text-anchor", h ? "end" : "start");
            A.attr("x", g + (h ? t.right : 0)).attr("y", c ? function(e) {
                return s(e);
            } : 0).style("fill", e.color()(v[v.length - 1], v.length - 1)).text(f(E));
            N.select(".nv-hoverArea").append("rect").on("mousemove", M).on("click", function() {
                u = !u;
            }).on("mouseout", function() {
                o = [];
                O();
            });
            C.select(".nv-hoverArea rect").attr("transform", function(e) {
                return "translate(" + -t.left + "," + -t.top + ")";
            }).attr("width", g + t.left + t.right).attr("height", b + t.top);
        });
        return d;
    }
    var e = nv.models.sparkline(), t = {
        top: 15,
        right: 100,
        bottom: 10,
        left: 50
    }, n = null, r = null, i, s, o = [], u = !1, a = d3.format(",r"), f = d3.format(",.2f"), l = !0, c = !0, h = !1, p = "No Data Available.";
    d.sparkline = e;
    d3.rebind(d, e, "x", "y", "xScale", "yScale", "color");
    d.options = nv.utils.optionsFunc.bind(d);
    d.margin = function(e) {
        if (!arguments.length) return t;
        t.top = typeof e.top != "undefined" ? e.top : t.top;
        t.right = typeof e.right != "undefined" ? e.right : t.right;
        t.bottom = typeof e.bottom != "undefined" ? e.bottom : t.bottom;
        t.left = typeof e.left != "undefined" ? e.left : t.left;
        return d;
    };
    d.width = function(e) {
        if (!arguments.length) return n;
        n = e;
        return d;
    };
    d.height = function(e) {
        if (!arguments.length) return r;
        r = e;
        return d;
    };
    d.xTickFormat = function(e) {
        if (!arguments.length) return a;
        a = e;
        return d;
    };
    d.yTickFormat = function(e) {
        if (!arguments.length) return f;
        f = e;
        return d;
    };
    d.showValue = function(e) {
        if (!arguments.length) return l;
        l = e;
        return d;
    };
    d.alignValue = function(e) {
        if (!arguments.length) return c;
        c = e;
        return d;
    };
    d.rightAlignValue = function(e) {
        if (!arguments.length) return h;
        h = e;
        return d;
    };
    d.noData = function(e) {
        if (!arguments.length) return p;
        p = e;
        return d;
    };
    return d;
};
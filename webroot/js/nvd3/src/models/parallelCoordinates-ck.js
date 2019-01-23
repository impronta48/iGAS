//Code adapted from Jason Davies' "Parallel Coordinates"
// http://bl.ocks.org/jasondavies/1341281
nv.models.parallelCoordinates = function() {
    "use strict";
    function c(o) {
        o.each(function(o) {
            function N(e) {
                return b(s.map(function(t) {
                    return [ r(t), i[t](e[t]) ];
                }));
            }
            function C() {
                var e = s.filter(function(e) {
                    return !i[e].brush.empty();
                }), t = e.map(function(e) {
                    return i[e].brush.extent();
                });
                a = [];
                e.forEach(function(e, n) {
                    a[n] = {
                        dimension: e,
                        extent: t[n]
                    };
                });
                f = [];
                S.style("display", function(n) {
                    var r = e.every(function(e, r) {
                        return t[r][0] <= n[e] && n[e] <= t[r][1];
                    });
                    r && f.push(n);
                    return r ? null : "none";
                });
                l.brush({
                    filters: a,
                    active: f
                });
            }
            var u = t - e.left - e.right, h = n - e.top - e.bottom, p = d3.select(this);
            f = o;
            c.update = function() {};
            r.rangePoints([ 0, u ], 1).domain(s);
            s.forEach(function(e) {
                i[e] = d3.scale.linear().domain(d3.extent(o, function(t) {
                    return +t[e];
                })).range([ h, 0 ]);
                i[e].brush = d3.svg.brush().y(i[e]).on("brush", C);
                return e != "name";
            });
            var d = p.selectAll("g.nv-wrap.nv-parallelCoordinates").data([ o ]), v = d.enter().append("g").attr("class", "nvd3 nv-wrap nv-parallelCoordinates"), m = v.append("g"), g = d.select("g");
            m.append("g").attr("class", "nv-parallelCoordinatesWrap");
            d.attr("transform", "translate(" + e.left + "," + e.top + ")");
            var b = d3.svg.line(), w = d3.svg.axis().orient("left"), E, S;
            E = m.append("g").attr("class", "background").selectAll("path").data(o).enter().append("path").attr("d", N);
            S = m.append("g").attr("class", "foreground").selectAll("path").data(o).enter().append("path").attr("d", N);
            var T = g.selectAll(".dimension").data(s).enter().append("g").attr("class", "dimension").attr("transform", function(e) {
                return "translate(" + r(e) + ",0)";
            });
            T.append("g").attr("class", "axis").each(function(e) {
                d3.select(this).call(w.scale(i[e]));
            }).append("text").attr("text-anchor", "middle").attr("y", -9).text(String);
            T.append("g").attr("class", "brush").each(function(e) {
                d3.select(this).call(i[e].brush);
            }).selectAll("rect").attr("x", -8).attr("width", 16);
        });
        return c;
    }
    var e = {
        top: 30,
        right: 10,
        bottom: 10,
        left: 10
    }, t = 960, n = 500, r = d3.scale.ordinal(), i = {}, s = [], o = nv.utils.getColor(d3.scale.category20c().range()), u = function(e) {
        return e;
    }, a = [], f = [], l = d3.dispatch("brush");
    c.dispatch = l;
    c.options = nv.utils.optionsFunc.bind(c);
    c.margin = function(t) {
        if (!arguments.length) return e;
        e.top = typeof t.top != "undefined" ? t.top : e.top;
        e.right = typeof t.right != "undefined" ? t.right : e.right;
        e.bottom = typeof t.bottom != "undefined" ? t.bottom : e.bottom;
        e.left = typeof t.left != "undefined" ? t.left : e.left;
        return c;
    };
    c.width = function(e) {
        if (!arguments.length) return t;
        t = e;
        return c;
    };
    c.height = function(e) {
        if (!arguments.length) return n;
        n = e;
        return c;
    };
    c.color = function(e) {
        if (!arguments.length) return o;
        o = nv.utils.getColor(e);
        return c;
    };
    c.xScale = function(e) {
        if (!arguments.length) return r;
        r = e;
        return c;
    };
    c.yScale = function(e) {
        if (!arguments.length) return i;
        i = e;
        return c;
    };
    c.dimensions = function(e) {
        if (!arguments.length) return s;
        s = e;
        return c;
    };
    c.filters = function() {
        return a;
    };
    c.active = function() {
        return f;
    };
    return c;
};
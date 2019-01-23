nv.models.distribution = function() {
    "use strict";
    function f(u) {
        u.each(function(u) {
            var f = t - (r === "x" ? e.left + e.right : e.top + e.bottom), l = r == "x" ? "y" : "x", c = d3.select(this);
            a = a || o;
            var h = c.selectAll("g.nv-distribution").data([ u ]), p = h.enter().append("g").attr("class", "nvd3 nv-distribution"), d = p.append("g"), v = h.select("g");
            h.attr("transform", "translate(" + e.left + "," + e.top + ")");
            var m = v.selectAll("g.nv-dist").data(function(e) {
                return e;
            }, function(e) {
                return e.key;
            });
            m.enter().append("g");
            m.attr("class", function(e, t) {
                return "nv-dist nv-series-" + t;
            }).style("stroke", function(e, t) {
                return s(e, t);
            });
            var g = m.selectAll("line.nv-dist" + r).data(function(e) {
                return e.values;
            });
            g.enter().append("line").attr(r + "1", function(e, t) {
                return a(i(e, t));
            }).attr(r + "2", function(e, t) {
                return a(i(e, t));
            });
            m.exit().selectAll("line.nv-dist" + r).transition().attr(r + "1", function(e, t) {
                return o(i(e, t));
            }).attr(r + "2", function(e, t) {
                return o(i(e, t));
            }).style("stroke-opacity", 0).remove();
            g.attr("class", function(e, t) {
                return "nv-dist" + r + " nv-dist" + r + "-" + t;
            }).attr(l + "1", 0).attr(l + "2", n);
            g.transition().attr(r + "1", function(e, t) {
                return o(i(e, t));
            }).attr(r + "2", function(e, t) {
                return o(i(e, t));
            });
            a = o.copy();
        });
        return f;
    }
    var e = {
        top: 0,
        right: 0,
        bottom: 0,
        left: 0
    }, t = 400, n = 8, r = "x", i = function(e) {
        return e[r];
    }, s = nv.utils.defaultColor(), o = d3.scale.linear(), u, a;
    f.options = nv.utils.optionsFunc.bind(f);
    f.margin = function(t) {
        if (!arguments.length) return e;
        e.top = typeof t.top != "undefined" ? t.top : e.top;
        e.right = typeof t.right != "undefined" ? t.right : e.right;
        e.bottom = typeof t.bottom != "undefined" ? t.bottom : e.bottom;
        e.left = typeof t.left != "undefined" ? t.left : e.left;
        return f;
    };
    f.width = function(e) {
        if (!arguments.length) return t;
        t = e;
        return f;
    };
    f.axis = function(e) {
        if (!arguments.length) return r;
        r = e;
        return f;
    };
    f.size = function(e) {
        if (!arguments.length) return n;
        n = e;
        return f;
    };
    f.getData = function(e) {
        if (!arguments.length) return i;
        i = d3.functor(e);
        return f;
    };
    f.scale = function(e) {
        if (!arguments.length) return o;
        o = e;
        return f;
    };
    f.color = function(e) {
        if (!arguments.length) return s;
        s = nv.utils.getColor(e);
        return f;
    };
    return f;
};
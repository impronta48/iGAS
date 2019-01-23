nv.models.sparkline = function() {
    "use strict";
    function p(r) {
        r.each(function(r) {
            var p = t - e.left - e.right, d = n - e.top - e.bottom, v = d3.select(this);
            i.domain(f || d3.extent(r, o)).range(c || [ 0, p ]);
            s.domain(l || d3.extent(r, u)).range(h || [ d, 0 ]);
            var m = v.selectAll("g.nv-wrap.nv-sparkline").data([ r ]), g = m.enter().append("g").attr("class", "nvd3 nv-wrap nv-sparkline"), b = g.append("g"), w = m.select("g");
            m.attr("transform", "translate(" + e.left + "," + e.top + ")");
            var E = m.selectAll("path").data(function(e) {
                return [ e ];
            });
            E.enter().append("path");
            E.exit().remove();
            E.style("stroke", function(e, t) {
                return e.color || a(e, t);
            }).attr("d", d3.svg.line().x(function(e, t) {
                return i(o(e, t));
            }).y(function(e, t) {
                return s(u(e, t));
            }));
            var S = m.selectAll("circle.nv-point").data(function(e) {
                function n(t) {
                    if (t != -1) {
                        var n = e[t];
                        n.pointIndex = t;
                        return n;
                    }
                    return null;
                }
                var t = e.map(function(e, t) {
                    return u(e, t);
                }), r = n(t.lastIndexOf(s.domain()[1])), i = n(t.indexOf(s.domain()[0])), o = n(t.length - 1);
                return [ i, r, o ].filter(function(e) {
                    return e != null;
                });
            });
            S.enter().append("circle");
            S.exit().remove();
            S.attr("cx", function(e, t) {
                return i(o(e, e.pointIndex));
            }).attr("cy", function(e, t) {
                return s(u(e, e.pointIndex));
            }).attr("r", 2).attr("class", function(e, t) {
                return o(e, e.pointIndex) == i.domain()[1] ? "nv-point nv-currentValue" : u(e, e.pointIndex) == s.domain()[0] ? "nv-point nv-minValue" : "nv-point nv-maxValue";
            });
        });
        return p;
    }
    var e = {
        top: 2,
        right: 0,
        bottom: 2,
        left: 0
    }, t = 400, n = 32, r = !0, i = d3.scale.linear(), s = d3.scale.linear(), o = function(e) {
        return e.x;
    }, u = function(e) {
        return e.y;
    }, a = nv.utils.getColor([ "#000" ]), f, l, c, h;
    p.options = nv.utils.optionsFunc.bind(p);
    p.margin = function(t) {
        if (!arguments.length) return e;
        e.top = typeof t.top != "undefined" ? t.top : e.top;
        e.right = typeof t.right != "undefined" ? t.right : e.right;
        e.bottom = typeof t.bottom != "undefined" ? t.bottom : e.bottom;
        e.left = typeof t.left != "undefined" ? t.left : e.left;
        return p;
    };
    p.width = function(e) {
        if (!arguments.length) return t;
        t = e;
        return p;
    };
    p.height = function(e) {
        if (!arguments.length) return n;
        n = e;
        return p;
    };
    p.x = function(e) {
        if (!arguments.length) return o;
        o = d3.functor(e);
        return p;
    };
    p.y = function(e) {
        if (!arguments.length) return u;
        u = d3.functor(e);
        return p;
    };
    p.xScale = function(e) {
        if (!arguments.length) return i;
        i = e;
        return p;
    };
    p.yScale = function(e) {
        if (!arguments.length) return s;
        s = e;
        return p;
    };
    p.xDomain = function(e) {
        if (!arguments.length) return f;
        f = e;
        return p;
    };
    p.yDomain = function(e) {
        if (!arguments.length) return l;
        l = e;
        return p;
    };
    p.xRange = function(e) {
        if (!arguments.length) return c;
        c = e;
        return p;
    };
    p.yRange = function(e) {
        if (!arguments.length) return h;
        h = e;
        return p;
    };
    p.animate = function(e) {
        if (!arguments.length) return r;
        r = e;
        return p;
    };
    p.color = function(e) {
        if (!arguments.length) return a;
        a = nv.utils.getColor(e);
        return p;
    };
    return p;
};
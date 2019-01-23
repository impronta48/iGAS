nv.models.line = function() {
    "use strict";
    function v(m) {
        m.each(function(v) {
            var m = n - t.left - t.right, g = r - t.top - t.bottom, b = d3.select(this);
            l = e.xScale();
            c = e.yScale();
            p = p || l;
            d = d || c;
            var w = b.selectAll("g.nv-wrap.nv-line").data([ v ]), E = w.enter().append("g").attr("class", "nvd3 nv-wrap nv-line"), S = E.append("defs"), T = E.append("g"), N = w.select("g");
            T.append("g").attr("class", "nv-groups");
            T.append("g").attr("class", "nv-scatterWrap");
            w.attr("transform", "translate(" + t.left + "," + t.top + ")");
            e.width(m).height(g);
            var C = w.select(".nv-scatterWrap");
            C.transition().call(e);
            S.append("clipPath").attr("id", "nv-edge-clip-" + e.id()).append("rect");
            w.select("#nv-edge-clip-" + e.id() + " rect").attr("width", m).attr("height", g);
            N.attr("clip-path", f ? "url(#nv-edge-clip-" + e.id() + ")" : "");
            C.attr("clip-path", f ? "url(#nv-edge-clip-" + e.id() + ")" : "");
            var k = w.select(".nv-groups").selectAll(".nv-group").data(function(e) {
                return e;
            }, function(e) {
                return e.key;
            });
            k.enter().append("g").style("stroke-opacity", 1e-6).style("fill-opacity", 1e-6);
            k.exit().transition().style("stroke-opacity", 1e-6).style("fill-opacity", 1e-6).remove();
            k.attr("class", function(e, t) {
                return "nv-group nv-series-" + t;
            }).classed("hover", function(e) {
                return e.hover;
            }).style("fill", function(e, t) {
                return i(e, t);
            }).style("stroke", function(e, t) {
                return i(e, t);
            });
            k.transition().style("stroke-opacity", 1).style("fill-opacity", .5);
            var L = k.selectAll("path.nv-area").data(function(e) {
                return a(e) ? [ e ] : [];
            });
            L.enter().append("path").attr("class", "nv-area").attr("d", function(e) {
                return d3.svg.area().interpolate(h).defined(u).x(function(e, t) {
                    return nv.utils.NaNtoZero(p(s(e, t)));
                }).y0(function(e, t) {
                    return nv.utils.NaNtoZero(d(o(e, t)));
                }).y1(function(e, t) {
                    return d(c.domain()[0] <= 0 ? c.domain()[1] >= 0 ? 0 : c.domain()[1] : c.domain()[0]);
                }).apply(this, [ e.values ]);
            });
            k.exit().selectAll("path.nv-area").remove();
            L.transition().attr("d", function(e) {
                return d3.svg.area().interpolate(h).defined(u).x(function(e, t) {
                    return nv.utils.NaNtoZero(l(s(e, t)));
                }).y0(function(e, t) {
                    return nv.utils.NaNtoZero(c(o(e, t)));
                }).y1(function(e, t) {
                    return c(c.domain()[0] <= 0 ? c.domain()[1] >= 0 ? 0 : c.domain()[1] : c.domain()[0]);
                }).apply(this, [ e.values ]);
            });
            var A = k.selectAll("path.nv-line").data(function(e) {
                return [ e.values ];
            });
            A.enter().append("path").attr("class", "nv-line").attr("d", d3.svg.line().interpolate(h).defined(u).x(function(e, t) {
                return nv.utils.NaNtoZero(p(s(e, t)));
            }).y(function(e, t) {
                return nv.utils.NaNtoZero(d(o(e, t)));
            }));
            k.exit().selectAll("path.nv-line").transition().attr("d", d3.svg.line().interpolate(h).defined(u).x(function(e, t) {
                return nv.utils.NaNtoZero(l(s(e, t)));
            }).y(function(e, t) {
                return nv.utils.NaNtoZero(c(o(e, t)));
            }));
            A.transition().attr("d", d3.svg.line().interpolate(h).defined(u).x(function(e, t) {
                return nv.utils.NaNtoZero(l(s(e, t)));
            }).y(function(e, t) {
                return nv.utils.NaNtoZero(c(o(e, t)));
            }));
            p = l.copy();
            d = c.copy();
        });
        return v;
    }
    var e = nv.models.scatter(), t = {
        top: 0,
        right: 0,
        bottom: 0,
        left: 0
    }, n = 960, r = 500, i = nv.utils.defaultColor(), s = function(e) {
        return e.x;
    }, o = function(e) {
        return e.y;
    }, u = function(e, t) {
        return !isNaN(o(e, t)) && o(e, t) !== null;
    }, a = function(e) {
        return e.area;
    }, f = !1, l, c, h = "linear";
    e.size(16).sizeDomain([ 16, 256 ]);
    var p, d;
    v.dispatch = e.dispatch;
    v.scatter = e;
    d3.rebind(v, e, "id", "interactive", "size", "xScale", "yScale", "zScale", "xDomain", "yDomain", "xRange", "yRange", "sizeDomain", "forceX", "forceY", "forceSize", "clipVoronoi", "useVoronoi", "clipRadius", "padData", "highlightPoint", "clearHighlights");
    v.options = nv.utils.optionsFunc.bind(v);
    v.margin = function(e) {
        if (!arguments.length) return t;
        t.top = typeof e.top != "undefined" ? e.top : t.top;
        t.right = typeof e.right != "undefined" ? e.right : t.right;
        t.bottom = typeof e.bottom != "undefined" ? e.bottom : t.bottom;
        t.left = typeof e.left != "undefined" ? e.left : t.left;
        return v;
    };
    v.width = function(e) {
        if (!arguments.length) return n;
        n = e;
        return v;
    };
    v.height = function(e) {
        if (!arguments.length) return r;
        r = e;
        return v;
    };
    v.x = function(t) {
        if (!arguments.length) return s;
        s = t;
        e.x(t);
        return v;
    };
    v.y = function(t) {
        if (!arguments.length) return o;
        o = t;
        e.y(t);
        return v;
    };
    v.clipEdge = function(e) {
        if (!arguments.length) return f;
        f = e;
        return v;
    };
    v.color = function(t) {
        if (!arguments.length) return i;
        i = nv.utils.getColor(t);
        e.color(i);
        return v;
    };
    v.interpolate = function(e) {
        if (!arguments.length) return h;
        h = e;
        return v;
    };
    v.defined = function(e) {
        if (!arguments.length) return u;
        u = e;
        return v;
    };
    v.isArea = function(e) {
        if (!arguments.length) return a;
        a = d3.functor(e);
        return v;
    };
    return v;
};
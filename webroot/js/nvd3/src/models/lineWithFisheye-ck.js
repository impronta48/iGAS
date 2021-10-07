nv.models.line = function() {
    "use strict";
    function v(d) {
        d.each(function(d) {
            var v = t - e.left - e.right, m = n - e.top - e.bottom;
            l = l || f.xScale();
            c = c || f.yScale();
            h = h || l;
            p = p || c;
            var g = d3.select(this).selectAll("g.nv-wrap.nv-line").data([ d ]), b = g.enter().append("g").attr("class", "nvd3 nv-wrap nv-line"), w = b.append("defs"), E = b.append("g"), S = g.select("g");
            b.append("g").attr("class", "nv-scatterWrap");
            var T = g.select(".nv-scatterWrap").datum(d);
            E.append("g").attr("class", "nv-groups");
            f.width(v).height(m);
            d3.transition(T).call(f);
            g.attr("transform", "translate(" + e.left + "," + e.top + ")");
            w.append("clipPath").attr("id", "nv-edge-clip-" + i).append("rect");
            g.select("#nv-edge-clip-" + i + " rect").attr("width", v).attr("height", m);
            S.attr("clip-path", u ? "url(#nv-edge-clip-" + i + ")" : "");
            T.attr("clip-path", u ? "url(#nv-edge-clip-" + i + ")" : "");
            var N = g.select(".nv-groups").selectAll(".nv-group").data(function(e) {
                return e;
            }, function(e) {
                return e.key;
            });
            N.enter().append("g").style("stroke-opacity", 1e-6).style("fill-opacity", 1e-6);
            d3.transition(N.exit()).style("stroke-opacity", 1e-6).style("fill-opacity", 1e-6).remove();
            N.attr("class", function(e, t) {
                return "nv-group nv-series-" + t;
            }).classed("hover", function(e) {
                return e.hover;
            }).style("fill", function(e, t) {
                return r(e, t);
            }).style("stroke", function(e, t) {
                return r(e, t);
            });
            d3.transition(N).style("stroke-opacity", 1).style("fill-opacity", .5);
            var C = N.selectAll("path").data(function(e, t) {
                return [ e.values ];
            });
            C.enter().append("path").attr("class", "nv-line").attr("d", d3.svg.line().interpolate(a).x(function(e, t) {
                return h(s(e, t));
            }).y(function(e, t) {
                return p(o(e, t));
            }));
            d3.transition(N.exit().selectAll("path")).attr("d", d3.svg.line().interpolate(a).x(function(e, t) {
                return l(s(e, t));
            }).y(function(e, t) {
                return c(o(e, t));
            })).remove();
            d3.transition(C).attr("d", d3.svg.line().interpolate(a).x(function(e, t) {
                return l(s(e, t));
            }).y(function(e, t) {
                return c(o(e, t));
            }));
            h = l.copy();
            p = c.copy();
        });
        return v;
    }
    var e = {
        top: 0,
        right: 0,
        bottom: 0,
        left: 0
    }, t = 960, n = 500, r = nv.utils.defaultColor(), i = Math.floor(Math.random() * 1e4), s = function(e) {
        return e.x;
    }, o = function(e) {
        return e.y;
    }, u = !1, a = "linear", f = nv.models.scatter().id(i).size(16).sizeDomain([ 16, 256 ]), l, c, h, p, d;
    v.dispatch = f.dispatch;
    d3.rebind(v, f, "interactive", "size", "xScale", "yScale", "zScale", "xDomain", "yDomain", "xRange", "yRange", "sizeDomain", "forceX", "forceY", "forceSize", "clipVoronoi", "clipRadius");
    v.options = nv.utils.optionsFunc.bind(v);
    v.margin = function(t) {
        if (!arguments.length) return e;
        e = t;
        return v;
    };
    v.width = function(e) {
        if (!arguments.length) return t;
        t = e;
        return v;
    };
    v.height = function(e) {
        if (!arguments.length) return n;
        n = e;
        return v;
    };
    v.x = function(e) {
        if (!arguments.length) return s;
        s = e;
        f.x(e);
        return v;
    };
    v.y = function(e) {
        if (!arguments.length) return o;
        o = e;
        f.y(e);
        return v;
    };
    v.clipEdge = function(e) {
        if (!arguments.length) return u;
        u = e;
        return v;
    };
    v.color = function(e) {
        if (!arguments.length) return r;
        r = nv.utils.getColor(e);
        f.color(r);
        return v;
    };
    v.id = function(e) {
        if (!arguments.length) return i;
        i = e;
        return v;
    };
    v.interpolate = function(e) {
        if (!arguments.length) return a;
        a = e;
        return v;
    };
    v.defined = function(e) {
        if (!arguments.length) return defined;
        defined = e;
        return v;
    };
    return v;
};
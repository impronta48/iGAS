nv.models.stackedArea = function() {
    "use strict";
    function m(u) {
        u.each(function(u) {
            var m = t - e.left - e.right, g = n - e.top - e.bottom, b = d3.select(this);
            h = d.xScale();
            p = d.yScale();
            u = u.map(function(e, t) {
                e.seriesIndex = t;
                e.values = e.values.map(function(e, n) {
                    e.index = n;
                    e.seriesIndex = t;
                    return e;
                });
                return e;
            });
            var w = u.filter(function(e) {
                return !e.disabled;
            });
            u = d3.layout.stack().order(f).offset(a).values(function(e) {
                return e.values;
            }).x(s).y(o).out(function(e, t, n) {
                var r = o(e) === 0 ? 0 : n;
                e.display = {
                    y: r,
                    y0: t
                };
            })(w);
            var E = b.selectAll("g.nv-wrap.nv-stackedarea").data([ u ]), S = E.enter().append("g").attr("class", "nvd3 nv-wrap nv-stackedarea"), T = S.append("defs"), N = S.append("g"), C = E.select("g");
            N.append("g").attr("class", "nv-areaWrap");
            N.append("g").attr("class", "nv-scatterWrap");
            E.attr("transform", "translate(" + e.left + "," + e.top + ")");
            d.width(m).height(g).x(s).y(function(e) {
                return e.display.y + e.display.y0;
            }).forceY([ 0 ]).color(u.map(function(e, t) {
                return e.color || r(e, e.seriesIndex);
            }));
            var k = C.select(".nv-scatterWrap").datum(u);
            k.call(d);
            T.append("clipPath").attr("id", "nv-edge-clip-" + i).append("rect");
            E.select("#nv-edge-clip-" + i + " rect").attr("width", m).attr("height", g);
            C.attr("clip-path", c ? "url(#nv-edge-clip-" + i + ")" : "");
            var L = d3.svg.area().x(function(e, t) {
                return h(s(e, t));
            }).y0(function(e) {
                return p(e.display.y0);
            }).y1(function(e) {
                return p(e.display.y + e.display.y0);
            }).interpolate(l), A = d3.svg.area().x(function(e, t) {
                return h(s(e, t));
            }).y0(function(e) {
                return p(e.display.y0);
            }).y1(function(e) {
                return p(e.display.y0);
            }), O = C.select(".nv-areaWrap").selectAll("path.nv-area").data(function(e) {
                return e;
            });
            O.enter().append("path").attr("class", function(e, t) {
                return "nv-area nv-area-" + t;
            }).attr("d", function(e, t) {
                return A(e.values, e.seriesIndex);
            }).on("mouseover", function(e, t) {
                d3.select(this).classed("hover", !0);
                v.areaMouseover({
                    point: e,
                    series: e.key,
                    pos: [ d3.event.pageX, d3.event.pageY ],
                    seriesIndex: t
                });
            }).on("mouseout", function(e, t) {
                d3.select(this).classed("hover", !1);
                v.areaMouseout({
                    point: e,
                    series: e.key,
                    pos: [ d3.event.pageX, d3.event.pageY ],
                    seriesIndex: t
                });
            }).on("click", function(e, t) {
                d3.select(this).classed("hover", !1);
                v.areaClick({
                    point: e,
                    series: e.key,
                    pos: [ d3.event.pageX, d3.event.pageY ],
                    seriesIndex: t
                });
            });
            O.exit().transition().attr("d", function(e, t) {
                return A(e.values, t);
            }).remove();
            O.style("fill", function(e, t) {
                return e.color || r(e, e.seriesIndex);
            }).style("stroke", function(e, t) {
                return e.color || r(e, e.seriesIndex);
            });
            O.transition().attr("d", function(e, t) {
                return L(e.values, t);
            });
            d.dispatch.on("elementMouseover.area", function(e) {
                C.select(".nv-chart-" + i + " .nv-area-" + e.seriesIndex).classed("hover", !0);
            });
            d.dispatch.on("elementMouseout.area", function(e) {
                C.select(".nv-chart-" + i + " .nv-area-" + e.seriesIndex).classed("hover", !1);
            });
        });
        return m;
    }
    var e = {
        top: 0,
        right: 0,
        bottom: 0,
        left: 0
    }, t = 960, n = 500, r = nv.utils.defaultColor(), i = Math.floor(Math.random() * 1e5), s = function(e) {
        return e.x;
    }, o = function(e) {
        return e.y;
    }, u = "stack", a = "zero", f = "default", l = "linear", c = !1, h, p, d = nv.models.scatter(), v = d3.dispatch("tooltipShow", "tooltipHide", "areaClick", "areaMouseover", "areaMouseout");
    d.size(2.2).sizeDomain([ 2.2, 2.2 ]);
    d.dispatch.on("elementClick.area", function(e) {
        v.areaClick(e);
    });
    d.dispatch.on("elementMouseover.tooltip", function(t) {
        t.pos = [ t.pos[0] + e.left, t.pos[1] + e.top ], v.tooltipShow(t);
    });
    d.dispatch.on("elementMouseout.tooltip", function(e) {
        v.tooltipHide(e);
    });
    m.dispatch = v;
    m.scatter = d;
    d3.rebind(m, d, "interactive", "size", "xScale", "yScale", "zScale", "xDomain", "yDomain", "xRange", "yRange", "sizeDomain", "forceX", "forceY", "forceSize", "clipVoronoi", "useVoronoi", "clipRadius", "highlightPoint", "clearHighlights");
    m.options = nv.utils.optionsFunc.bind(m);
    m.x = function(e) {
        if (!arguments.length) return s;
        s = d3.functor(e);
        return m;
    };
    m.y = function(e) {
        if (!arguments.length) return o;
        o = d3.functor(e);
        return m;
    };
    m.margin = function(t) {
        if (!arguments.length) return e;
        e.top = typeof t.top != "undefined" ? t.top : e.top;
        e.right = typeof t.right != "undefined" ? t.right : e.right;
        e.bottom = typeof t.bottom != "undefined" ? t.bottom : e.bottom;
        e.left = typeof t.left != "undefined" ? t.left : e.left;
        return m;
    };
    m.width = function(e) {
        if (!arguments.length) return t;
        t = e;
        return m;
    };
    m.height = function(e) {
        if (!arguments.length) return n;
        n = e;
        return m;
    };
    m.clipEdge = function(e) {
        if (!arguments.length) return c;
        c = e;
        return m;
    };
    m.color = function(e) {
        if (!arguments.length) return r;
        r = nv.utils.getColor(e);
        return m;
    };
    m.offset = function(e) {
        if (!arguments.length) return a;
        a = e;
        return m;
    };
    m.order = function(e) {
        if (!arguments.length) return f;
        f = e;
        return m;
    };
    m.style = function(e) {
        if (!arguments.length) return u;
        u = e;
        switch (u) {
          case "stack":
            m.offset("zero");
            m.order("default");
            break;
          case "stream":
            m.offset("wiggle");
            m.order("inside-out");
            break;
          case "stream-center":
            m.offset("silhouette");
            m.order("inside-out");
            break;
          case "expand":
            m.offset("expand");
            m.order("default");
        }
        return m;
    };
    m.interpolate = function(e) {
        if (!arguments.length) return l;
        l = e;
        return m;
    };
    return m;
};
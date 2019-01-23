nv.models.lineWithFocusChart = function() {
    "use strict";
    function C(E) {
        E.each(function(E) {
            function U(e) {
                var t = +(e == "e"), n = t ? 1 : -1, r = M / 3;
                return "M" + .5 * n + "," + r + "A6,6 0 0 " + t + " " + 6.5 * n + "," + (r + 6) + "V" + (2 * r - 6) + "A6,6 0 0 " + t + " " + .5 * n + "," + 2 * r + "Z" + "M" + 2.5 * n + "," + (r + 8) + "V" + (2 * r - 8) + "M" + 4.5 * n + "," + (r + 8) + "V" + (2 * r - 8);
            }
            function z() {
                u.empty() || u.extent(b);
                I.data([ u.empty() ? m.domain() : b ]).each(function(e, t) {
                    var n = m(e[0]) - d.range()[0], r = d.range()[1] - m(e[1]);
                    d3.select(this).select(".left").attr("width", n < 0 ? 0 : n);
                    d3.select(this).select(".right").attr("x", m(e[1])).attr("width", r < 0 ? 0 : r);
                });
            }
            function W() {
                b = u.empty() ? null : u.extent();
                var t = u.empty() ? m.domain() : u.extent();
                if (Math.abs(t[0] - t[1]) <= 1) return;
                x.brush({
                    extent: t,
                    brush: u
                });
                z();
                var i = H.select(".nv-focus .nv-linesWrap").datum(E.filter(function(e) {
                    return !e.disabled;
                }).map(function(n, r) {
                    return {
                        key: n.key,
                        values: n.values.filter(function(n, r) {
                            return e.x()(n, r) >= t[0] && e.x()(n, r) <= t[1];
                        })
                    };
                }));
                i.transition().duration(T).call(e);
                H.select(".nv-focus .nv-x.nv-axis").transition().duration(T).call(n);
                H.select(".nv-focus .nv-y.nv-axis").transition().duration(T).call(r);
            }
            var k = d3.select(this), L = this, A = (c || parseInt(k.style("width")) || 960) - a.left - a.right, O = (h || parseInt(k.style("height")) || 400) - a.top - a.bottom - p, M = p - f.top - f.bottom;
            C.update = function() {
                k.transition().duration(T).call(C);
            };
            C.container = this;
            if (!E || !E.length || !E.filter(function(e) {
                return e.values.length;
            }).length) {
                var _ = k.selectAll(".nv-noData").data([ S ]);
                _.enter().append("text").attr("class", "nvd3 nv-noData").attr("dy", "-.7em").style("text-anchor", "middle");
                _.attr("x", a.left + A / 2).attr("y", a.top + O / 2).text(function(e) {
                    return e;
                });
                return C;
            }
            k.selectAll(".nv-noData").remove();
            d = e.xScale();
            v = e.yScale();
            m = t.xScale();
            g = t.yScale();
            var D = k.selectAll("g.nv-wrap.nv-lineWithFocusChart").data([ E ]), P = D.enter().append("g").attr("class", "nvd3 nv-wrap nv-lineWithFocusChart").append("g"), H = D.select("g");
            P.append("g").attr("class", "nv-legendWrap");
            var B = P.append("g").attr("class", "nv-focus");
            B.append("g").attr("class", "nv-x nv-axis");
            B.append("g").attr("class", "nv-y nv-axis");
            B.append("g").attr("class", "nv-linesWrap");
            var j = P.append("g").attr("class", "nv-context");
            j.append("g").attr("class", "nv-x nv-axis");
            j.append("g").attr("class", "nv-y nv-axis");
            j.append("g").attr("class", "nv-linesWrap");
            j.append("g").attr("class", "nv-brushBackground");
            j.append("g").attr("class", "nv-x nv-brush");
            if (y) {
                o.width(A);
                H.select(".nv-legendWrap").datum(E).call(o);
                if (a.top != o.height()) {
                    a.top = o.height();
                    O = (h || parseInt(k.style("height")) || 400) - a.top - a.bottom - p;
                }
                H.select(".nv-legendWrap").attr("transform", "translate(0," + -a.top + ")");
            }
            D.attr("transform", "translate(" + a.left + "," + a.top + ")");
            e.width(A).height(O).color(E.map(function(e, t) {
                return e.color || l(e, t);
            }).filter(function(e, t) {
                return !E[t].disabled;
            }));
            t.defined(e.defined()).width(A).height(M).color(E.map(function(e, t) {
                return e.color || l(e, t);
            }).filter(function(e, t) {
                return !E[t].disabled;
            }));
            H.select(".nv-context").attr("transform", "translate(0," + (O + a.bottom + f.top) + ")");
            var F = H.select(".nv-context .nv-linesWrap").datum(E.filter(function(e) {
                return !e.disabled;
            }));
            d3.transition(F).call(t);
            n.scale(d).ticks(A / 100).tickSize(-O, 0);
            r.scale(v).ticks(O / 36).tickSize(-A, 0);
            H.select(".nv-focus .nv-x.nv-axis").attr("transform", "translate(0," + O + ")");
            u.x(m).on("brush", function() {
                var e = C.transitionDuration();
                C.transitionDuration(0);
                W();
                C.transitionDuration(e);
            });
            b && u.extent(b);
            var I = H.select(".nv-brushBackground").selectAll("g").data([ b || u.extent() ]), q = I.enter().append("g");
            q.append("rect").attr("class", "left").attr("x", 0).attr("y", 0).attr("height", M);
            q.append("rect").attr("class", "right").attr("x", 0).attr("y", 0).attr("height", M);
            var R = H.select(".nv-x.nv-brush").call(u);
            R.selectAll("rect").attr("height", M);
            R.selectAll(".resize").append("path").attr("d", U);
            W();
            i.scale(m).ticks(A / 100).tickSize(-M, 0);
            H.select(".nv-context .nv-x.nv-axis").attr("transform", "translate(0," + g.range()[0] + ")");
            d3.transition(H.select(".nv-context .nv-x.nv-axis")).call(i);
            s.scale(g).ticks(M / 36).tickSize(-A, 0);
            d3.transition(H.select(".nv-context .nv-y.nv-axis")).call(s);
            H.select(".nv-context .nv-x.nv-axis").attr("transform", "translate(0," + g.range()[0] + ")");
            o.dispatch.on("stateChange", function(e) {
                C.update();
            });
            x.on("tooltipShow", function(e) {
                w && N(e, L.parentNode);
            });
        });
        return C;
    }
    var e = nv.models.line(), t = nv.models.line(), n = nv.models.axis(), r = nv.models.axis(), i = nv.models.axis(), s = nv.models.axis(), o = nv.models.legend(), u = d3.svg.brush(), a = {
        top: 30,
        right: 30,
        bottom: 30,
        left: 60
    }, f = {
        top: 0,
        right: 30,
        bottom: 20,
        left: 60
    }, l = nv.utils.defaultColor(), c = null, h = null, p = 100, d, v, m, g, y = !0, b = null, w = !0, E = function(e, t, n, r, i) {
        return "<h3>" + e + "</h3>" + "<p>" + n + " at " + t + "</p>";
    }, S = "No Data Available.", x = d3.dispatch("tooltipShow", "tooltipHide", "brush"), T = 250;
    e.clipEdge(!0);
    t.interactive(!1);
    n.orient("bottom").tickPadding(5);
    r.orient("left");
    i.orient("bottom").tickPadding(5);
    s.orient("left");
    var N = function(t, i) {
        var s = t.pos[0] + (i.offsetLeft || 0), o = t.pos[1] + (i.offsetTop || 0), u = n.tickFormat()(e.x()(t.point, t.pointIndex)), a = r.tickFormat()(e.y()(t.point, t.pointIndex)), f = E(t.series.key, u, a, t, C);
        nv.tooltip.show([ s, o ], f, null, null, i);
    };
    e.dispatch.on("elementMouseover.tooltip", function(e) {
        e.pos = [ e.pos[0] + a.left, e.pos[1] + a.top ];
        x.tooltipShow(e);
    });
    e.dispatch.on("elementMouseout.tooltip", function(e) {
        x.tooltipHide(e);
    });
    x.on("tooltipHide", function() {
        w && nv.tooltip.cleanup();
    });
    C.dispatch = x;
    C.legend = o;
    C.lines = e;
    C.lines2 = t;
    C.xAxis = n;
    C.yAxis = r;
    C.x2Axis = i;
    C.y2Axis = s;
    d3.rebind(C, e, "defined", "isArea", "size", "xDomain", "yDomain", "xRange", "yRange", "forceX", "forceY", "interactive", "clipEdge", "clipVoronoi", "id");
    C.options = nv.utils.optionsFunc.bind(C);
    C.x = function(n) {
        if (!arguments.length) return e.x;
        e.x(n);
        t.x(n);
        return C;
    };
    C.y = function(n) {
        if (!arguments.length) return e.y;
        e.y(n);
        t.y(n);
        return C;
    };
    C.margin = function(e) {
        if (!arguments.length) return a;
        a.top = typeof e.top != "undefined" ? e.top : a.top;
        a.right = typeof e.right != "undefined" ? e.right : a.right;
        a.bottom = typeof e.bottom != "undefined" ? e.bottom : a.bottom;
        a.left = typeof e.left != "undefined" ? e.left : a.left;
        return C;
    };
    C.margin2 = function(e) {
        if (!arguments.length) return f;
        f = e;
        return C;
    };
    C.width = function(e) {
        if (!arguments.length) return c;
        c = e;
        return C;
    };
    C.height = function(e) {
        if (!arguments.length) return h;
        h = e;
        return C;
    };
    C.height2 = function(e) {
        if (!arguments.length) return p;
        p = e;
        return C;
    };
    C.color = function(e) {
        if (!arguments.length) return l;
        l = nv.utils.getColor(e);
        o.color(l);
        return C;
    };
    C.showLegend = function(e) {
        if (!arguments.length) return y;
        y = e;
        return C;
    };
    C.tooltips = function(e) {
        if (!arguments.length) return w;
        w = e;
        return C;
    };
    C.tooltipContent = function(e) {
        if (!arguments.length) return E;
        E = e;
        return C;
    };
    C.interpolate = function(n) {
        if (!arguments.length) return e.interpolate();
        e.interpolate(n);
        t.interpolate(n);
        return C;
    };
    C.noData = function(e) {
        if (!arguments.length) return S;
        S = e;
        return C;
    };
    C.xTickFormat = function(e) {
        if (!arguments.length) return n.tickFormat();
        n.tickFormat(e);
        i.tickFormat(e);
        return C;
    };
    C.yTickFormat = function(e) {
        if (!arguments.length) return r.tickFormat();
        r.tickFormat(e);
        s.tickFormat(e);
        return C;
    };
    C.brushExtent = function(e) {
        if (!arguments.length) return b;
        b = e;
        return C;
    };
    C.transitionDuration = function(e) {
        if (!arguments.length) return T;
        T = e;
        return C;
    };
    return C;
};
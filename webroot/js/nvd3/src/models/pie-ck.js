nv.models.pie = function() {
    "use strict";
    function w(s) {
        s.each(function(s) {
            function P(e) {
                var t = (e.startAngle + e.endAngle) * 90 / Math.PI - 90;
                return t > 90 ? t - 180 : t;
            }
            function H(e) {
                e.endAngle = isNaN(e.endAngle) ? 0 : e.endAngle;
                e.startAngle = isNaN(e.startAngle) ? 0 : e.startAngle;
                d || (e.innerRadius = 0);
                var t = d3.interpolate(this._current, e);
                this._current = t(0);
                return function(e) {
                    return L(t(e));
                };
            }
            function B(e) {
                e.innerRadius = 0;
                var t = d3.interpolate({
                    startAngle: 0,
                    endAngle: 0
                }, e);
                return function(e) {
                    return L(t(e));
                };
            }
            var a = t - e.left - e.right, w = n - e.top - e.bottom, E = Math.min(a, w) / 2, S = E - E / 5, x = d3.select(this), T = x.selectAll(".nv-wrap.nv-pie").data(s), N = T.enter().append("g").attr("class", "nvd3 nv-wrap nv-pie nv-chart-" + o), C = N.append("g"), k = T.select("g");
            C.append("g").attr("class", "nv-pie");
            T.attr("transform", "translate(" + e.left + "," + e.top + ")");
            k.select(".nv-pie").attr("transform", "translate(" + a / 2 + "," + w / 2 + ")");
            x.on("click", function(e, t) {
                b.chartClick({
                    data: e,
                    index: t,
                    pos: d3.event,
                    id: o
                });
            });
            var L = d3.svg.arc().outerRadius(S);
            m && L.startAngle(m);
            g && L.endAngle(g);
            d && L.innerRadius(E * y);
            var A = d3.layout.pie().sort(null).value(function(e) {
                return e.disabled ? 0 : i(e);
            }), O = T.select(".nv-pie").selectAll(".nv-slice").data(A);
            O.exit().remove();
            var M = O.enter().append("g").attr("class", "nv-slice").on("mouseover", function(e, t) {
                d3.select(this).classed("hover", !0);
                b.elementMouseover({
                    label: r(e.data),
                    value: i(e.data),
                    point: e.data,
                    pointIndex: t,
                    pos: [ d3.event.pageX, d3.event.pageY ],
                    id: o
                });
            }).on("mouseout", function(e, t) {
                d3.select(this).classed("hover", !1);
                b.elementMouseout({
                    label: r(e.data),
                    value: i(e.data),
                    point: e.data,
                    index: t,
                    id: o
                });
            }).on("click", function(e, t) {
                b.elementClick({
                    label: r(e.data),
                    value: i(e.data),
                    point: e.data,
                    index: t,
                    pos: d3.event,
                    id: o
                });
                d3.event.stopPropagation();
            }).on("dblclick", function(e, t) {
                b.elementDblClick({
                    label: r(e.data),
                    value: i(e.data),
                    point: e.data,
                    index: t,
                    pos: d3.event,
                    id: o
                });
                d3.event.stopPropagation();
            });
            O.attr("fill", function(e, t) {
                return u(e, t);
            }).attr("stroke", function(e, t) {
                return u(e, t);
            });
            var _ = M.append("path").each(function(e) {
                this._current = e;
            });
            d3.transition(O.select("path")).attr("d", L).attrTween("d", H);
            if (f) {
                var D = d3.svg.arc().innerRadius(0);
                l && (D = L);
                c && (D = d3.svg.arc().outerRadius(L.outerRadius()));
                M.append("g").classed("nv-label", !0).each(function(e, t) {
                    var n = d3.select(this);
                    n.attr("transform", function(e) {
                        if (v) {
                            e.outerRadius = S + 10;
                            e.innerRadius = S + 15;
                            var t = (e.startAngle + e.endAngle) / 2 * (180 / Math.PI);
                            (e.startAngle + e.endAngle) / 2 < Math.PI ? t -= 90 : t += 90;
                            return "translate(" + D.centroid(e) + ") rotate(" + t + ")";
                        }
                        e.outerRadius = E + 10;
                        e.innerRadius = E + 15;
                        return "translate(" + D.centroid(e) + ")";
                    });
                    n.append("rect").style("stroke", "#fff").style("fill", "#fff").attr("rx", 3).attr("ry", 3);
                    n.append("text").style("text-anchor", v ? (e.startAngle + e.endAngle) / 2 < Math.PI ? "start" : "end" : "middle").style("fill", "#000");
                });
                O.select(".nv-label").transition().attr("transform", function(e) {
                    if (v) {
                        e.outerRadius = S + 10;
                        e.innerRadius = S + 15;
                        var t = (e.startAngle + e.endAngle) / 2 * (180 / Math.PI);
                        (e.startAngle + e.endAngle) / 2 < Math.PI ? t -= 90 : t += 90;
                        return "translate(" + D.centroid(e) + ") rotate(" + t + ")";
                    }
                    e.outerRadius = E + 10;
                    e.innerRadius = E + 15;
                    return "translate(" + D.centroid(e) + ")";
                });
                O.each(function(e, t) {
                    var n = d3.select(this);
                    n.select(".nv-label text").style("text-anchor", v ? (e.startAngle + e.endAngle) / 2 < Math.PI ? "start" : "end" : "middle").text(function(e, t) {
                        var n = (e.endAngle - e.startAngle) / (2 * Math.PI), s = {
                            key: r(e.data),
                            value: i(e.data),
                            percent: d3.format("%")(n)
                        };
                        return e.value && n > p ? s[h] : "";
                    });
                    var s = n.select("text").node().getBBox();
                    n.select(".nv-label rect").attr("width", s.width + 10).attr("height", s.height + 10).attr("transform", function() {
                        return "translate(" + [ s.x - 5, s.y - 5 ] + ")";
                    });
                });
            }
        });
        return w;
    }
    var e = {
        top: 0,
        right: 0,
        bottom: 0,
        left: 0
    }, t = 500, n = 500, r = function(e) {
        return e.x;
    }, i = function(e) {
        return e.y;
    }, s = function(e) {
        return e.description;
    }, o = Math.floor(Math.random() * 1e4), u = nv.utils.defaultColor(), a = d3.format(",.2f"), f = !0, l = !0, c = !1, h = "key", p = .02, d = !1, v = !1, m = !1, g = !1, y = .5, b = d3.dispatch("chartClick", "elementClick", "elementDblClick", "elementMouseover", "elementMouseout");
    w.dispatch = b;
    w.options = nv.utils.optionsFunc.bind(w);
    w.margin = function(t) {
        if (!arguments.length) return e;
        e.top = typeof t.top != "undefined" ? t.top : e.top;
        e.right = typeof t.right != "undefined" ? t.right : e.right;
        e.bottom = typeof t.bottom != "undefined" ? t.bottom : e.bottom;
        e.left = typeof t.left != "undefined" ? t.left : e.left;
        return w;
    };
    w.width = function(e) {
        if (!arguments.length) return t;
        t = e;
        return w;
    };
    w.height = function(e) {
        if (!arguments.length) return n;
        n = e;
        return w;
    };
    w.values = function(e) {
        nv.log("pie.values() is no longer supported.");
        return w;
    };
    w.x = function(e) {
        if (!arguments.length) return r;
        r = e;
        return w;
    };
    w.y = function(e) {
        if (!arguments.length) return i;
        i = d3.functor(e);
        return w;
    };
    w.description = function(e) {
        if (!arguments.length) return s;
        s = e;
        return w;
    };
    w.showLabels = function(e) {
        if (!arguments.length) return f;
        f = e;
        return w;
    };
    w.labelSunbeamLayout = function(e) {
        if (!arguments.length) return v;
        v = e;
        return w;
    };
    w.donutLabelsOutside = function(e) {
        if (!arguments.length) return c;
        c = e;
        return w;
    };
    w.pieLabelsOutside = function(e) {
        if (!arguments.length) return l;
        l = e;
        return w;
    };
    w.labelType = function(e) {
        if (!arguments.length) return h;
        h = e;
        h = h || "key";
        return w;
    };
    w.donut = function(e) {
        if (!arguments.length) return d;
        d = e;
        return w;
    };
    w.donutRatio = function(e) {
        if (!arguments.length) return y;
        y = e;
        return w;
    };
    w.startAngle = function(e) {
        if (!arguments.length) return m;
        m = e;
        return w;
    };
    w.endAngle = function(e) {
        if (!arguments.length) return g;
        g = e;
        return w;
    };
    w.id = function(e) {
        if (!arguments.length) return o;
        o = e;
        return w;
    };
    w.color = function(e) {
        if (!arguments.length) return u;
        u = nv.utils.getColor(e);
        return w;
    };
    w.valueFormat = function(e) {
        if (!arguments.length) return a;
        a = e;
        return w;
    };
    w.labelThreshold = function(e) {
        if (!arguments.length) return p;
        p = e;
        return w;
    };
    return w;
};
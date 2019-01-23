nv.models.linePlusBarWithFocusChart = function() {
    "use strict";
    function H(T) {
        T.each(function(T) {
            function nt(e) {
                var t = +(e == "e"), n = t ? 1 : -1, r = q / 3;
                return "M" + .5 * n + "," + r + "A6,6 0 0 " + t + " " + 6.5 * n + "," + (r + 6) + "V" + (2 * r - 6) + "A6,6 0 0 " + t + " " + .5 * n + "," + 2 * r + "Z" + "M" + 2.5 * n + "," + (r + 8) + "V" + (2 * r - 8) + "M" + 4.5 * n + "," + (r + 8) + "V" + (2 * r - 8);
            }
            function rt() {
                c.empty() || c.extent(S);
                Z.data([ c.empty() ? C.domain() : S ]).each(function(e, t) {
                    var n = C(e[0]) - C.range()[0], r = C.range()[1] - C(e[1]);
                    d3.select(this).select(".left").attr("width", n < 0 ? 0 : n);
                    d3.select(this).select(".right").attr("x", C(e[1])).attr("width", r < 0 ? 0 : r);
                });
            }
            function it() {
                S = c.empty() ? null : c.extent();
                E = c.empty() ? C.domain() : c.extent();
                _.brush({
                    extent: E,
                    brush: c
                });
                rt();
                n.width(F).height(I).color(T.map(function(e, t) {
                    return e.color || b(e, t);
                }).filter(function(e, t) {
                    return !T[t].disabled && T[t].bar;
                }));
                e.width(F).height(I).color(T.map(function(e, t) {
                    return e.color || b(e, t);
                }).filter(function(e, t) {
                    return !T[t].disabled && !T[t].bar;
                }));
                var t = J.select(".nv-focus .nv-barsWrap").datum(U.length ? U.map(function(e, t) {
                    return {
                        key: e.key,
                        values: e.values.filter(function(e, t) {
                            return n.x()(e, t) >= E[0] && n.x()(e, t) <= E[1];
                        })
                    };
                }) : [ {
                    values: []
                } ]), r = J.select(".nv-focus .nv-linesWrap").datum(z[0].disabled ? [ {
                    values: []
                } ] : z.map(function(t, n) {
                    return {
                        key: t.key,
                        values: t.values.filter(function(t, n) {
                            return e.x()(t, n) >= E[0] && e.x()(t, n) <= E[1];
                        })
                    };
                }));
                U.length ? N = n.xScale() : N = e.xScale();
                i.scale(N).ticks(F / 100).tickSize(-I, 0);
                i.domain([ Math.ceil(E[0]), Math.floor(E[1]) ]);
                J.select(".nv-x.nv-axis").transition().duration(D).call(i);
                t.transition().duration(D).call(n);
                r.transition().duration(D).call(e);
                J.select(".nv-focus .nv-x.nv-axis").attr("transform", "translate(0," + k.range()[0] + ")");
                o.scale(k).ticks(I / 36).tickSize(-F, 0);
                J.select(".nv-focus .nv-y1.nv-axis").style("opacity", U.length ? 1 : 0);
                u.scale(L).ticks(I / 36).tickSize(U.length ? 0 : -F, 0);
                J.select(".nv-focus .nv-y2.nv-axis").style("opacity", z.length ? 1 : 0).attr("transform", "translate(" + N.range()[1] + ",0)");
                J.select(".nv-focus .nv-y1.nv-axis").transition().duration(D).call(o);
                J.select(".nv-focus .nv-y2.nv-axis").transition().duration(D).call(u);
            }
            var B = d3.select(this), j = this, F = (d || parseInt(B.style("width")) || 960) - h.left - h.right, I = (v || parseInt(B.style("height")) || 400) - h.top - h.bottom - m, q = m - p.top - p.bottom;
            H.update = function() {
                B.transition().duration(D).call(H);
            };
            H.container = this;
            if (!T || !T.length || !T.filter(function(e) {
                return e.values.length;
            }).length) {
                var R = B.selectAll(".nv-noData").data([ M ]);
                R.enter().append("text").attr("class", "nvd3 nv-noData").attr("dy", "-.7em").style("text-anchor", "middle");
                R.attr("x", h.left + F / 2).attr("y", h.top + I / 2).text(function(e) {
                    return e;
                });
                return H;
            }
            B.selectAll(".nv-noData").remove();
            var U = T.filter(function(e) {
                return !e.disabled && e.bar;
            }), z = T.filter(function(e) {
                return !e.bar;
            });
            N = n.xScale();
            C = s.scale();
            k = n.yScale();
            L = e.yScale();
            A = r.yScale();
            O = t.yScale();
            var W = T.filter(function(e) {
                return !e.disabled && e.bar;
            }).map(function(e) {
                return e.values.map(function(e, t) {
                    return {
                        x: g(e, t),
                        y: y(e, t)
                    };
                });
            }), X = T.filter(function(e) {
                return !e.disabled && !e.bar;
            }).map(function(e) {
                return e.values.map(function(e, t) {
                    return {
                        x: g(e, t),
                        y: y(e, t)
                    };
                });
            });
            N.range([ 0, F ]);
            C.domain(d3.extent(d3.merge(W.concat(X)), function(e) {
                return e.x;
            })).range([ 0, F ]);
            var V = B.selectAll("g.nv-wrap.nv-linePlusBar").data([ T ]), $ = V.enter().append("g").attr("class", "nvd3 nv-wrap nv-linePlusBar").append("g"), J = V.select("g");
            $.append("g").attr("class", "nv-legendWrap");
            var K = $.append("g").attr("class", "nv-focus");
            K.append("g").attr("class", "nv-x nv-axis");
            K.append("g").attr("class", "nv-y1 nv-axis");
            K.append("g").attr("class", "nv-y2 nv-axis");
            K.append("g").attr("class", "nv-barsWrap");
            K.append("g").attr("class", "nv-linesWrap");
            var Q = $.append("g").attr("class", "nv-context");
            Q.append("g").attr("class", "nv-x nv-axis");
            Q.append("g").attr("class", "nv-y1 nv-axis");
            Q.append("g").attr("class", "nv-y2 nv-axis");
            Q.append("g").attr("class", "nv-barsWrap");
            Q.append("g").attr("class", "nv-linesWrap");
            Q.append("g").attr("class", "nv-brushBackground");
            Q.append("g").attr("class", "nv-x nv-brush");
            if (w) {
                l.width(F / 2);
                J.select(".nv-legendWrap").datum(T.map(function(e) {
                    e.originalKey = e.originalKey === undefined ? e.key : e.originalKey;
                    e.key = e.originalKey + (e.bar ? " (left axis)" : " (right axis)");
                    return e;
                })).call(l);
                if (h.top != l.height()) {
                    h.top = l.height();
                    I = (v || parseInt(B.style("height")) || 400) - h.top - h.bottom - m;
                }
                J.select(".nv-legendWrap").attr("transform", "translate(" + F / 2 + "," + -h.top + ")");
            }
            V.attr("transform", "translate(" + h.left + "," + h.top + ")");
            r.width(F).height(q).color(T.map(function(e, t) {
                return e.color || b(e, t);
            }).filter(function(e, t) {
                return !T[t].disabled && T[t].bar;
            }));
            t.width(F).height(q).color(T.map(function(e, t) {
                return e.color || b(e, t);
            }).filter(function(e, t) {
                return !T[t].disabled && !T[t].bar;
            }));
            var G = J.select(".nv-context .nv-barsWrap").datum(U.length ? U : [ {
                values: []
            } ]), Y = J.select(".nv-context .nv-linesWrap").datum(z[0].disabled ? [ {
                values: []
            } ] : z);
            J.select(".nv-context").attr("transform", "translate(0," + (I + h.bottom + p.top) + ")");
            G.transition().call(r);
            Y.transition().call(t);
            c.x(C).on("brush", it);
            S && c.extent(S);
            var Z = J.select(".nv-brushBackground").selectAll("g").data([ S || c.extent() ]), et = Z.enter().append("g");
            et.append("rect").attr("class", "left").attr("x", 0).attr("y", 0).attr("height", q);
            et.append("rect").attr("class", "right").attr("x", 0).attr("y", 0).attr("height", q);
            var tt = J.select(".nv-x.nv-brush").call(c);
            tt.selectAll("rect").attr("height", q);
            tt.selectAll(".resize").append("path").attr("d", nt);
            s.ticks(F / 100).tickSize(-q, 0);
            J.select(".nv-context .nv-x.nv-axis").attr("transform", "translate(0," + A.range()[0] + ")");
            J.select(".nv-context .nv-x.nv-axis").transition().call(s);
            a.scale(A).ticks(q / 36).tickSize(-F, 0);
            J.select(".nv-context .nv-y1.nv-axis").style("opacity", U.length ? 1 : 0).attr("transform", "translate(0," + C.range()[0] + ")");
            J.select(".nv-context .nv-y1.nv-axis").transition().call(a);
            f.scale(O).ticks(q / 36).tickSize(U.length ? 0 : -F, 0);
            J.select(".nv-context .nv-y2.nv-axis").style("opacity", z.length ? 1 : 0).attr("transform", "translate(" + C.range()[1] + ",0)");
            J.select(".nv-context .nv-y2.nv-axis").transition().call(f);
            l.dispatch.on("stateChange", function(e) {
                H.update();
            });
            _.on("tooltipShow", function(e) {
                x && P(e, j.parentNode);
            });
            it();
        });
        return H;
    }
    var e = nv.models.line(), t = nv.models.line(), n = nv.models.historicalBar(), r = nv.models.historicalBar(), i = nv.models.axis(), s = nv.models.axis(), o = nv.models.axis(), u = nv.models.axis(), a = nv.models.axis(), f = nv.models.axis(), l = nv.models.legend(), c = d3.svg.brush(), h = {
        top: 30,
        right: 30,
        bottom: 30,
        left: 60
    }, p = {
        top: 0,
        right: 30,
        bottom: 20,
        left: 60
    }, d = null, v = null, m = 100, g = function(e) {
        return e.x;
    }, y = function(e) {
        return e.y;
    }, b = nv.utils.defaultColor(), w = !0, E, S = null, x = !0, T = function(e, t, n, r, i) {
        return "<h3>" + e + "</h3>" + "<p>" + n + " at " + t + "</p>";
    }, N, C, k, L, A, O, M = "No Data Available.", _ = d3.dispatch("tooltipShow", "tooltipHide", "brush"), D = 0;
    e.clipEdge(!0);
    t.interactive(!1);
    i.orient("bottom").tickPadding(5);
    o.orient("left");
    u.orient("right");
    s.orient("bottom").tickPadding(5);
    a.orient("left");
    f.orient("right");
    var P = function(t, n) {
        E && (t.pointIndex += Math.ceil(E[0]));
        var r = t.pos[0] + (n.offsetLeft || 0), s = t.pos[1] + (n.offsetTop || 0), a = i.tickFormat()(e.x()(t.point, t.pointIndex)), f = (t.series.bar ? o : u).tickFormat()(e.y()(t.point, t.pointIndex)), l = T(t.series.key, a, f, t, H);
        nv.tooltip.show([ r, s ], l, t.value < 0 ? "n" : "s", null, n);
    };
    e.dispatch.on("elementMouseover.tooltip", function(e) {
        e.pos = [ e.pos[0] + h.left, e.pos[1] + h.top ];
        _.tooltipShow(e);
    });
    e.dispatch.on("elementMouseout.tooltip", function(e) {
        _.tooltipHide(e);
    });
    n.dispatch.on("elementMouseover.tooltip", function(e) {
        e.pos = [ e.pos[0] + h.left, e.pos[1] + h.top ];
        _.tooltipShow(e);
    });
    n.dispatch.on("elementMouseout.tooltip", function(e) {
        _.tooltipHide(e);
    });
    _.on("tooltipHide", function() {
        x && nv.tooltip.cleanup();
    });
    H.dispatch = _;
    H.legend = l;
    H.lines = e;
    H.lines2 = t;
    H.bars = n;
    H.bars2 = r;
    H.xAxis = i;
    H.x2Axis = s;
    H.y1Axis = o;
    H.y2Axis = u;
    H.y3Axis = a;
    H.y4Axis = f;
    d3.rebind(H, e, "defined", "size", "clipVoronoi", "interpolate");
    H.options = nv.utils.optionsFunc.bind(H);
    H.x = function(t) {
        if (!arguments.length) return g;
        g = t;
        e.x(t);
        n.x(t);
        return H;
    };
    H.y = function(t) {
        if (!arguments.length) return y;
        y = t;
        e.y(t);
        n.y(t);
        return H;
    };
    H.margin = function(e) {
        if (!arguments.length) return h;
        h.top = typeof e.top != "undefined" ? e.top : h.top;
        h.right = typeof e.right != "undefined" ? e.right : h.right;
        h.bottom = typeof e.bottom != "undefined" ? e.bottom : h.bottom;
        h.left = typeof e.left != "undefined" ? e.left : h.left;
        return H;
    };
    H.width = function(e) {
        if (!arguments.length) return d;
        d = e;
        return H;
    };
    H.height = function(e) {
        if (!arguments.length) return v;
        v = e;
        return H;
    };
    H.color = function(e) {
        if (!arguments.length) return b;
        b = nv.utils.getColor(e);
        l.color(b);
        return H;
    };
    H.showLegend = function(e) {
        if (!arguments.length) return w;
        w = e;
        return H;
    };
    H.tooltips = function(e) {
        if (!arguments.length) return x;
        x = e;
        return H;
    };
    H.tooltipContent = function(e) {
        if (!arguments.length) return T;
        T = e;
        return H;
    };
    H.noData = function(e) {
        if (!arguments.length) return M;
        M = e;
        return H;
    };
    H.brushExtent = function(e) {
        if (!arguments.length) return S;
        S = e;
        return H;
    };
    return H;
};
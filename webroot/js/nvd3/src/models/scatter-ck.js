nv.models.scatter = function() {
    "use strict";
    function F(I) {
        I.each(function(F) {
            function K() {
                if (!m) return !1;
                var r, u = d3.merge(F.map(function(e, t) {
                    return e.values.map(function(e, n) {
                        var r = a(e, n), i = f(e, n);
                        return [ s(r) + Math.random() * 1e-7, o(i) + Math.random() * 1e-7, t, n, e ];
                    }).filter(function(e, t) {
                        return y(e[4], t);
                    });
                }));
                if (_ === !0) {
                    if (S) {
                        var l = W.select("defs").selectAll(".nv-point-clips").data([ i ]).enter();
                        l.append("clipPath").attr("class", "nv-point-clips").attr("id", "nv-points-clip-" + i);
                        var c = W.select("#nv-points-clip-" + i).selectAll("circle").data(u);
                        c.enter().append("circle").attr("r", x);
                        c.exit().remove();
                        c.attr("cx", function(e) {
                            return e[0];
                        }).attr("cy", function(e) {
                            return e[1];
                        });
                        W.select(".nv-point-paths").attr("clip-path", "url(#nv-points-clip-" + i + ")");
                    }
                    if (u.length) {
                        u.push([ s.range()[0] - 20, o.range()[0] - 20, null, null ]);
                        u.push([ s.range()[1] + 20, o.range()[1] + 20, null, null ]);
                        u.push([ s.range()[0] - 20, o.range()[0] + 20, null, null ]);
                        u.push([ s.range()[1] + 20, o.range()[1] - 20, null, null ]);
                    }
                    var h = d3.geom.polygon([ [ -10, -10 ], [ -10, n + 10 ], [ t + 10, n + 10 ], [ t + 10, -10 ] ]), p = d3.geom.voronoi(u).map(function(e, t) {
                        return {
                            data: h.clip(e),
                            series: u[t][2],
                            point: u[t][3]
                        };
                    }), d = W.select(".nv-point-paths").selectAll("path").data(p);
                    d.enter().append("path").attr("class", function(e, t) {
                        return "nv-path-" + t;
                    });
                    d.exit().remove();
                    d.attr("d", function(e) {
                        return e.data.length === 0 ? "M 0 0" : "M" + e.data.join("L") + "Z";
                    });
                    var v = function(t, n) {
                        if (j) return 0;
                        var r = F[t.series];
                        if (typeof r == "undefined") return;
                        var i = r.values[t.point];
                        n({
                            point: i,
                            series: r,
                            pos: [ s(a(i, t.point)) + e.left, o(f(i, t.point)) + e.top ],
                            seriesIndex: t.series,
                            pointIndex: t.point
                        });
                    };
                    d.on("click", function(e) {
                        v(e, M.elementClick);
                    }).on("mouseover", function(e) {
                        v(e, M.elementMouseover);
                    }).on("mouseout", function(e, t) {
                        v(e, M.elementMouseout);
                    });
                } else W.select(".nv-groups").selectAll(".nv-group").selectAll(".nv-point").on("click", function(t, n) {
                    if (j || !F[t.series]) return 0;
                    var r = F[t.series], i = r.values[n];
                    M.elementClick({
                        point: i,
                        series: r,
                        pos: [ s(a(i, n)) + e.left, o(f(i, n)) + e.top ],
                        seriesIndex: t.series,
                        pointIndex: n
                    });
                }).on("mouseover", function(t, n) {
                    if (j || !F[t.series]) return 0;
                    var r = F[t.series], i = r.values[n];
                    M.elementMouseover({
                        point: i,
                        series: r,
                        pos: [ s(a(i, n)) + e.left, o(f(i, n)) + e.top ],
                        seriesIndex: t.series,
                        pointIndex: n
                    });
                }).on("mouseout", function(e, t) {
                    if (j || !F[e.series]) return 0;
                    var n = F[e.series], r = n.values[t];
                    M.elementMouseout({
                        point: r,
                        series: n,
                        seriesIndex: e.series,
                        pointIndex: t
                    });
                });
                j = !1;
            }
            var I = t - e.left - e.right, q = n - e.top - e.bottom, R = d3.select(this);
            F.forEach(function(e, t) {
                e.values.forEach(function(e) {
                    e.series = t;
                });
            });
            var U = T && N && L ? [] : d3.merge(F.map(function(e) {
                return e.values.map(function(e, t) {
                    return {
                        x: a(e, t),
                        y: f(e, t),
                        size: l(e, t)
                    };
                });
            }));
            s.domain(T || d3.extent(U.map(function(e) {
                return e.x;
            }).concat(p)));
            b && F[0] ? s.range(C || [ (I * w + I) / (2 * F[0].values.length), I - I * (1 + w) / (2 * F[0].values.length) ]) : s.range(C || [ 0, I ]);
            o.domain(N || d3.extent(U.map(function(e) {
                return e.y;
            }).concat(d))).range(k || [ q, 0 ]);
            u.domain(L || d3.extent(U.map(function(e) {
                return e.size;
            }).concat(v))).range(A || [ 16, 256 ]);
            if (s.domain()[0] === s.domain()[1] || o.domain()[0] === o.domain()[1]) O = !0;
            s.domain()[0] === s.domain()[1] && (s.domain()[0] ? s.domain([ s.domain()[0] - s.domain()[0] * .01, s.domain()[1] + s.domain()[1] * .01 ]) : s.domain([ -1, 1 ]));
            o.domain()[0] === o.domain()[1] && (o.domain()[0] ? o.domain([ o.domain()[0] - o.domain()[0] * .01, o.domain()[1] + o.domain()[1] * .01 ]) : o.domain([ -1, 1 ]));
            isNaN(s.domain()[0]) && s.domain([ -1, 1 ]);
            isNaN(o.domain()[0]) && o.domain([ -1, 1 ]);
            D = D || s;
            P = P || o;
            H = H || u;
            var W = R.selectAll("g.nv-wrap.nv-scatter").data([ F ]), X = W.enter().append("g").attr("class", "nvd3 nv-wrap nv-scatter nv-chart-" + i + (O ? " nv-single-point" : "")), V = X.append("defs"), $ = X.append("g"), J = W.select("g");
            $.append("g").attr("class", "nv-groups");
            $.append("g").attr("class", "nv-point-paths");
            W.attr("transform", "translate(" + e.left + "," + e.top + ")");
            V.append("clipPath").attr("id", "nv-edge-clip-" + i).append("rect");
            W.select("#nv-edge-clip-" + i + " rect").attr("width", I).attr("height", q);
            J.attr("clip-path", E ? "url(#nv-edge-clip-" + i + ")" : "");
            j = !0;
            var Q = W.select(".nv-groups").selectAll(".nv-group").data(function(e) {
                return e;
            }, function(e) {
                return e.key;
            });
            Q.enter().append("g").style("stroke-opacity", 1e-6).style("fill-opacity", 1e-6);
            Q.exit().remove();
            Q.attr("class", function(e, t) {
                return "nv-group nv-series-" + t;
            }).classed("hover", function(e) {
                return e.hover;
            });
            Q.transition().style("fill", function(e, t) {
                return r(e, t);
            }).style("stroke", function(e, t) {
                return r(e, t);
            }).style("stroke-opacity", 1).style("fill-opacity", .5);
            if (h) {
                var G = Q.selectAll("circle.nv-point").data(function(e) {
                    return e.values;
                }, g);
                G.enter().append("circle").style("fill", function(e, t) {
                    return e.color;
                }).style("stroke", function(e, t) {
                    return e.color;
                }).attr("cx", function(e, t) {
                    return nv.utils.NaNtoZero(D(a(e, t)));
                }).attr("cy", function(e, t) {
                    return nv.utils.NaNtoZero(P(f(e, t)));
                }).attr("r", function(e, t) {
                    return Math.sqrt(u(l(e, t)) / Math.PI);
                });
                G.exit().remove();
                Q.exit().selectAll("path.nv-point").transition().attr("cx", function(e, t) {
                    return nv.utils.NaNtoZero(s(a(e, t)));
                }).attr("cy", function(e, t) {
                    return nv.utils.NaNtoZero(o(f(e, t)));
                }).remove();
                G.each(function(e, t) {
                    d3.select(this).classed("nv-point", !0).classed("nv-point-" + t, !0).classed("hover", !1);
                });
                G.transition().attr("cx", function(e, t) {
                    return nv.utils.NaNtoZero(s(a(e, t)));
                }).attr("cy", function(e, t) {
                    return nv.utils.NaNtoZero(o(f(e, t)));
                }).attr("r", function(e, t) {
                    return Math.sqrt(u(l(e, t)) / Math.PI);
                });
            } else {
                var G = Q.selectAll("path.nv-point").data(function(e) {
                    return e.values;
                });
                G.enter().append("path").style("fill", function(e, t) {
                    return e.color;
                }).style("stroke", function(e, t) {
                    return e.color;
                }).attr("transform", function(e, t) {
                    return "translate(" + D(a(e, t)) + "," + P(f(e, t)) + ")";
                }).attr("d", d3.svg.symbol().type(c).size(function(e, t) {
                    return u(l(e, t));
                }));
                G.exit().remove();
                Q.exit().selectAll("path.nv-point").transition().attr("transform", function(e, t) {
                    return "translate(" + s(a(e, t)) + "," + o(f(e, t)) + ")";
                }).remove();
                G.each(function(e, t) {
                    d3.select(this).classed("nv-point", !0).classed("nv-point-" + t, !0).classed("hover", !1);
                });
                G.transition().attr("transform", function(e, t) {
                    return "translate(" + s(a(e, t)) + "," + o(f(e, t)) + ")";
                }).attr("d", d3.svg.symbol().type(c).size(function(e, t) {
                    return u(l(e, t));
                }));
            }
            clearTimeout(B);
            B = setTimeout(K, 300);
            D = s.copy();
            P = o.copy();
            H = u.copy();
        });
        return F;
    }
    var e = {
        top: 0,
        right: 0,
        bottom: 0,
        left: 0
    }, t = 960, n = 500, r = nv.utils.defaultColor(), i = Math.floor(Math.random() * 1e5), s = d3.scale.linear(), o = d3.scale.linear(), u = d3.scale.linear(), a = function(e) {
        return e.x;
    }, f = function(e) {
        return e.y;
    }, l = function(e) {
        return e.size || 1;
    }, c = function(e) {
        return e.shape || "circle";
    }, h = !0, p = [], d = [], v = [], m = !0, g = null, y = function(e) {
        return !e.notActive;
    }, b = !1, w = .1, E = !1, S = !0, x = function() {
        return 25;
    }, T = null, N = null, C = null, k = null, L = null, A = null, O = !1, M = d3.dispatch("elementClick", "elementMouseover", "elementMouseout"), _ = !0, D, P, H, B, j = !1;
    F.clearHighlights = function() {
        d3.selectAll(".nv-chart-" + i + " .nv-point.hover").classed("hover", !1);
    };
    F.highlightPoint = function(e, t, n) {
        d3.select(".nv-chart-" + i + " .nv-series-" + e + " .nv-point-" + t).classed("hover", n);
    };
    M.on("elementMouseover.point", function(e) {
        m && F.highlightPoint(e.seriesIndex, e.pointIndex, !0);
    });
    M.on("elementMouseout.point", function(e) {
        m && F.highlightPoint(e.seriesIndex, e.pointIndex, !1);
    });
    F.dispatch = M;
    F.options = nv.utils.optionsFunc.bind(F);
    F.x = function(e) {
        if (!arguments.length) return a;
        a = d3.functor(e);
        return F;
    };
    F.y = function(e) {
        if (!arguments.length) return f;
        f = d3.functor(e);
        return F;
    };
    F.size = function(e) {
        if (!arguments.length) return l;
        l = d3.functor(e);
        return F;
    };
    F.margin = function(t) {
        if (!arguments.length) return e;
        e.top = typeof t.top != "undefined" ? t.top : e.top;
        e.right = typeof t.right != "undefined" ? t.right : e.right;
        e.bottom = typeof t.bottom != "undefined" ? t.bottom : e.bottom;
        e.left = typeof t.left != "undefined" ? t.left : e.left;
        return F;
    };
    F.width = function(e) {
        if (!arguments.length) return t;
        t = e;
        return F;
    };
    F.height = function(e) {
        if (!arguments.length) return n;
        n = e;
        return F;
    };
    F.xScale = function(e) {
        if (!arguments.length) return s;
        s = e;
        return F;
    };
    F.yScale = function(e) {
        if (!arguments.length) return o;
        o = e;
        return F;
    };
    F.zScale = function(e) {
        if (!arguments.length) return u;
        u = e;
        return F;
    };
    F.xDomain = function(e) {
        if (!arguments.length) return T;
        T = e;
        return F;
    };
    F.yDomain = function(e) {
        if (!arguments.length) return N;
        N = e;
        return F;
    };
    F.sizeDomain = function(e) {
        if (!arguments.length) return L;
        L = e;
        return F;
    };
    F.xRange = function(e) {
        if (!arguments.length) return C;
        C = e;
        return F;
    };
    F.yRange = function(e) {
        if (!arguments.length) return k;
        k = e;
        return F;
    };
    F.sizeRange = function(e) {
        if (!arguments.length) return A;
        A = e;
        return F;
    };
    F.forceX = function(e) {
        if (!arguments.length) return p;
        p = e;
        return F;
    };
    F.forceY = function(e) {
        if (!arguments.length) return d;
        d = e;
        return F;
    };
    F.forceSize = function(e) {
        if (!arguments.length) return v;
        v = e;
        return F;
    };
    F.interactive = function(e) {
        if (!arguments.length) return m;
        m = e;
        return F;
    };
    F.pointKey = function(e) {
        if (!arguments.length) return g;
        g = e;
        return F;
    };
    F.pointActive = function(e) {
        if (!arguments.length) return y;
        y = e;
        return F;
    };
    F.padData = function(e) {
        if (!arguments.length) return b;
        b = e;
        return F;
    };
    F.padDataOuter = function(e) {
        if (!arguments.length) return w;
        w = e;
        return F;
    };
    F.clipEdge = function(e) {
        if (!arguments.length) return E;
        E = e;
        return F;
    };
    F.clipVoronoi = function(e) {
        if (!arguments.length) return S;
        S = e;
        return F;
    };
    F.useVoronoi = function(e) {
        if (!arguments.length) return _;
        _ = e;
        _ === !1 && (S = !1);
        return F;
    };
    F.clipRadius = function(e) {
        if (!arguments.length) return x;
        x = e;
        return F;
    };
    F.color = function(e) {
        if (!arguments.length) return r;
        r = nv.utils.getColor(e);
        return F;
    };
    F.shape = function(e) {
        if (!arguments.length) return c;
        c = e;
        return F;
    };
    F.onlyCircles = function(e) {
        if (!arguments.length) return h;
        h = e;
        return F;
    };
    F.id = function(e) {
        if (!arguments.length) return i;
        i = e;
        return F;
    };
    F.singlePoint = function(e) {
        if (!arguments.length) return O;
        O = e;
        return F;
    };
    return F;
};
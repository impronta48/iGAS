nv.models.scatterPlusLineChart = function() {
    "use strict";
    function H(x) {
        x.each(function(x) {
            function $() {
                if (E) {
                    z.select(".nv-point-paths").style("pointer-events", "all");
                    return !1;
                }
                z.select(".nv-point-paths").style("pointer-events", "none");
                var r = d3.mouse(this);
                c.distortion(w).focus(r[0]);
                h.distortion(w).focus(r[1]);
                z.select(".nv-scatterWrap").datum(x.filter(function(e) {
                    return !e.disabled;
                })).call(e);
                m && z.select(".nv-x.nv-axis").call(t);
                g && z.select(".nv-y.nv-axis").call(n);
                z.select(".nv-distributionX").datum(x.filter(function(e) {
                    return !e.disabled;
                })).call(s);
                z.select(".nv-distributionY").datum(x.filter(function(e) {
                    return !e.disabled;
                })).call(o);
            }
            var T = d3.select(this), N = this, B = (a || parseInt(T.style("width")) || 960) - u.left - u.right, j = (f || parseInt(T.style("height")) || 400) - u.top - u.bottom;
            H.update = function() {
                T.transition().duration(O).call(H);
            };
            H.container = this;
            C.disabled = x.map(function(e) {
                return !!e.disabled;
            });
            if (!k) {
                var F;
                k = {};
                for (F in C) C[F] instanceof Array ? k[F] = C[F].slice(0) : k[F] = C[F];
            }
            if (!x || !x.length || !x.filter(function(e) {
                return e.values.length;
            }).length) {
                var I = T.selectAll(".nv-noData").data([ A ]);
                I.enter().append("text").attr("class", "nvd3 nv-noData").attr("dy", "-.7em").style("text-anchor", "middle");
                I.attr("x", u.left + B / 2).attr("y", u.top + j / 2).text(function(e) {
                    return e;
                });
                return H;
            }
            T.selectAll(".nv-noData").remove();
            c = e.xScale();
            h = e.yScale();
            M = M || c;
            _ = _ || h;
            var q = T.selectAll("g.nv-wrap.nv-scatterChart").data([ x ]), R = q.enter().append("g").attr("class", "nvd3 nv-wrap nv-scatterChart nv-chart-" + e.id()), U = R.append("g"), z = q.select("g");
            U.append("rect").attr("class", "nvd3 nv-background").style("pointer-events", "none");
            U.append("g").attr("class", "nv-x nv-axis");
            U.append("g").attr("class", "nv-y nv-axis");
            U.append("g").attr("class", "nv-scatterWrap");
            U.append("g").attr("class", "nv-regressionLinesWrap");
            U.append("g").attr("class", "nv-distWrap");
            U.append("g").attr("class", "nv-legendWrap");
            U.append("g").attr("class", "nv-controlsWrap");
            q.attr("transform", "translate(" + u.left + "," + u.top + ")");
            y && z.select(".nv-y.nv-axis").attr("transform", "translate(" + B + ",0)");
            if (v) {
                r.width(B / 2);
                q.select(".nv-legendWrap").datum(x).call(r);
                if (u.top != r.height()) {
                    u.top = r.height();
                    j = (f || parseInt(T.style("height")) || 400) - u.top - u.bottom;
                }
                q.select(".nv-legendWrap").attr("transform", "translate(" + B / 2 + "," + -u.top + ")");
            }
            if (b) {
                i.width(180).color([ "#444" ]);
                z.select(".nv-controlsWrap").datum(P).attr("transform", "translate(0," + -u.top + ")").call(i);
            }
            e.width(B).height(j).color(x.map(function(e, t) {
                return e.color || l(e, t);
            }).filter(function(e, t) {
                return !x[t].disabled;
            }));
            q.select(".nv-scatterWrap").datum(x.filter(function(e) {
                return !e.disabled;
            })).call(e);
            q.select(".nv-regressionLinesWrap").attr("clip-path", "url(#nv-edge-clip-" + e.id() + ")");
            var W = q.select(".nv-regressionLinesWrap").selectAll(".nv-regLines").data(function(e) {
                return e;
            });
            W.enter().append("g").attr("class", "nv-regLines");
            var X = W.selectAll(".nv-regLine").data(function(e) {
                return [ e ];
            }), V = X.enter().append("line").attr("class", "nv-regLine").style("stroke-opacity", 0);
            X.transition().attr("x1", c.range()[0]).attr("x2", c.range()[1]).attr("y1", function(e, t) {
                return h(c.domain()[0] * e.slope + e.intercept);
            }).attr("y2", function(e, t) {
                return h(c.domain()[1] * e.slope + e.intercept);
            }).style("stroke", function(e, t, n) {
                return l(e, n);
            }).style("stroke-opacity", function(e, t) {
                return e.disabled || typeof e.slope == "undefined" || typeof e.intercept == "undefined" ? 0 : 1;
            });
            if (m) {
                t.scale(c).ticks(t.ticks() ? t.ticks() : B / 100).tickSize(-j, 0);
                z.select(".nv-x.nv-axis").attr("transform", "translate(0," + h.range()[0] + ")").call(t);
            }
            if (g) {
                n.scale(h).ticks(n.ticks() ? n.ticks() : j / 36).tickSize(-B, 0);
                z.select(".nv-y.nv-axis").call(n);
            }
            if (p) {
                s.getData(e.x()).scale(c).width(B).color(x.map(function(e, t) {
                    return e.color || l(e, t);
                }).filter(function(e, t) {
                    return !x[t].disabled;
                }));
                U.select(".nv-distWrap").append("g").attr("class", "nv-distributionX");
                z.select(".nv-distributionX").attr("transform", "translate(0," + h.range()[0] + ")").datum(x.filter(function(e) {
                    return !e.disabled;
                })).call(s);
            }
            if (d) {
                o.getData(e.y()).scale(h).width(j).color(x.map(function(e, t) {
                    return e.color || l(e, t);
                }).filter(function(e, t) {
                    return !x[t].disabled;
                }));
                U.select(".nv-distWrap").append("g").attr("class", "nv-distributionY");
                z.select(".nv-distributionY").attr("transform", "translate(" + (y ? B : -o.size()) + ",0)").datum(x.filter(function(e) {
                    return !e.disabled;
                })).call(o);
            }
            if (d3.fisheye) {
                z.select(".nv-background").attr("width", B).attr("height", j);
                z.select(".nv-background").on("mousemove", $);
                z.select(".nv-background").on("click", function() {
                    E = !E;
                });
                e.dispatch.on("elementClick.freezeFisheye", function() {
                    E = !E;
                });
            }
            i.dispatch.on("legendClick", function(r, i) {
                r.disabled = !r.disabled;
                w = r.disabled ? 0 : 2.5;
                z.select(".nv-background").style("pointer-events", r.disabled ? "none" : "all");
                z.select(".nv-point-paths").style("pointer-events", r.disabled ? "all" : "none");
                if (r.disabled) {
                    c.distortion(w).focus(0);
                    h.distortion(w).focus(0);
                    z.select(".nv-scatterWrap").call(e);
                    z.select(".nv-x.nv-axis").call(t);
                    z.select(".nv-y.nv-axis").call(n);
                } else E = !1;
                H.update();
            });
            r.dispatch.on("stateChange", function(e) {
                C = e;
                L.stateChange(C);
                H.update();
            });
            e.dispatch.on("elementMouseover.tooltip", function(t) {
                d3.select(".nv-chart-" + e.id() + " .nv-series-" + t.seriesIndex + " .nv-distx-" + t.pointIndex).attr("y1", t.pos[1] - j);
                d3.select(".nv-chart-" + e.id() + " .nv-series-" + t.seriesIndex + " .nv-disty-" + t.pointIndex).attr("x2", t.pos[0] + s.size());
                t.pos = [ t.pos[0] + u.left, t.pos[1] + u.top ];
                L.tooltipShow(t);
            });
            L.on("tooltipShow", function(e) {
                S && D(e, N.parentNode);
            });
            L.on("changeState", function(e) {
                if (typeof e.disabled != "undefined") {
                    x.forEach(function(t, n) {
                        t.disabled = e.disabled[n];
                    });
                    C.disabled = e.disabled;
                }
                H.update();
            });
            M = c.copy();
            _ = h.copy();
        });
        return H;
    }
    var e = nv.models.scatter(), t = nv.models.axis(), n = nv.models.axis(), r = nv.models.legend(), i = nv.models.legend(), s = nv.models.distribution(), o = nv.models.distribution(), u = {
        top: 30,
        right: 20,
        bottom: 50,
        left: 75
    }, a = null, f = null, l = nv.utils.defaultColor(), c = d3.fisheye ? d3.fisheye.scale(d3.scale.linear).distortion(0) : e.xScale(), h = d3.fisheye ? d3.fisheye.scale(d3.scale.linear).distortion(0) : e.yScale(), p = !1, d = !1, v = !0, m = !0, g = !0, y = !1, b = !!d3.fisheye, w = 0, E = !1, S = !0, x = function(e, t, n) {
        return "<strong>" + t + "</strong>";
    }, T = function(e, t, n) {
        return "<strong>" + n + "</strong>";
    }, N = function(e, t, n, r) {
        return "<h3>" + e + "</h3>" + "<p>" + r + "</p>";
    }, C = {}, k = null, L = d3.dispatch("tooltipShow", "tooltipHide", "stateChange", "changeState"), A = "No Data Available.", O = 250;
    e.xScale(c).yScale(h);
    t.orient("bottom").tickPadding(10);
    n.orient(y ? "right" : "left").tickPadding(10);
    s.axis("x");
    o.axis("y");
    i.updateState(!1);
    var M, _, D = function(r, i) {
        var s = r.pos[0] + (i.offsetLeft || 0), o = r.pos[1] + (i.offsetTop || 0), a = r.pos[0] + (i.offsetLeft || 0), f = h.range()[0] + u.top + (i.offsetTop || 0), l = c.range()[0] + u.left + (i.offsetLeft || 0), p = r.pos[1] + (i.offsetTop || 0), d = t.tickFormat()(e.x()(r.point, r.pointIndex)), v = n.tickFormat()(e.y()(r.point, r.pointIndex));
        x != null && nv.tooltip.show([ a, f ], x(r.series.key, d, v, r, H), "n", 1, i, "x-nvtooltip");
        T != null && nv.tooltip.show([ l, p ], T(r.series.key, d, v, r, H), "e", 1, i, "y-nvtooltip");
        N != null && nv.tooltip.show([ s, o ], N(r.series.key, d, v, r.point.tooltip, r, H), r.value < 0 ? "n" : "s", null, i);
    }, P = [ {
        key: "Magnify",
        disabled: !0
    } ];
    e.dispatch.on("elementMouseout.tooltip", function(t) {
        L.tooltipHide(t);
        d3.select(".nv-chart-" + e.id() + " .nv-series-" + t.seriesIndex + " .nv-distx-" + t.pointIndex).attr("y1", 0);
        d3.select(".nv-chart-" + e.id() + " .nv-series-" + t.seriesIndex + " .nv-disty-" + t.pointIndex).attr("x2", o.size());
    });
    L.on("tooltipHide", function() {
        S && nv.tooltip.cleanup();
    });
    H.dispatch = L;
    H.scatter = e;
    H.legend = r;
    H.controls = i;
    H.xAxis = t;
    H.yAxis = n;
    H.distX = s;
    H.distY = o;
    d3.rebind(H, e, "id", "interactive", "pointActive", "x", "y", "shape", "size", "xScale", "yScale", "zScale", "xDomain", "yDomain", "xRange", "yRange", "sizeDomain", "sizeRange", "forceX", "forceY", "forceSize", "clipVoronoi", "clipRadius", "useVoronoi");
    H.options = nv.utils.optionsFunc.bind(H);
    H.margin = function(e) {
        if (!arguments.length) return u;
        u.top = typeof e.top != "undefined" ? e.top : u.top;
        u.right = typeof e.right != "undefined" ? e.right : u.right;
        u.bottom = typeof e.bottom != "undefined" ? e.bottom : u.bottom;
        u.left = typeof e.left != "undefined" ? e.left : u.left;
        return H;
    };
    H.width = function(e) {
        if (!arguments.length) return a;
        a = e;
        return H;
    };
    H.height = function(e) {
        if (!arguments.length) return f;
        f = e;
        return H;
    };
    H.color = function(e) {
        if (!arguments.length) return l;
        l = nv.utils.getColor(e);
        r.color(l);
        s.color(l);
        o.color(l);
        return H;
    };
    H.showDistX = function(e) {
        if (!arguments.length) return p;
        p = e;
        return H;
    };
    H.showDistY = function(e) {
        if (!arguments.length) return d;
        d = e;
        return H;
    };
    H.showControls = function(e) {
        if (!arguments.length) return b;
        b = e;
        return H;
    };
    H.showLegend = function(e) {
        if (!arguments.length) return v;
        v = e;
        return H;
    };
    H.showXAxis = function(e) {
        if (!arguments.length) return m;
        m = e;
        return H;
    };
    H.showYAxis = function(e) {
        if (!arguments.length) return g;
        g = e;
        return H;
    };
    H.rightAlignYAxis = function(e) {
        if (!arguments.length) return y;
        y = e;
        n.orient(e ? "right" : "left");
        return H;
    };
    H.fisheye = function(e) {
        if (!arguments.length) return w;
        w = e;
        return H;
    };
    H.tooltips = function(e) {
        if (!arguments.length) return S;
        S = e;
        return H;
    };
    H.tooltipContent = function(e) {
        if (!arguments.length) return N;
        N = e;
        return H;
    };
    H.tooltipXContent = function(e) {
        if (!arguments.length) return x;
        x = e;
        return H;
    };
    H.tooltipYContent = function(e) {
        if (!arguments.length) return T;
        T = e;
        return H;
    };
    H.state = function(e) {
        if (!arguments.length) return C;
        C = e;
        return H;
    };
    H.defaultState = function(e) {
        if (!arguments.length) return k;
        k = e;
        return H;
    };
    H.noData = function(e) {
        if (!arguments.length) return A;
        A = e;
        return H;
    };
    H.transitionDuration = function(e) {
        if (!arguments.length) return O;
        O = e;
        return H;
    };
    return H;
};
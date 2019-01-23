nv.models.scatterChart = function() {
    "use strict";
    function j(N) {
        N.each(function(N) {
            function K() {
                if (x) {
                    X.select(".nv-point-paths").style("pointer-events", "all");
                    return !1;
                }
                X.select(".nv-point-paths").style("pointer-events", "none");
                var r = d3.mouse(this);
                c.distortion(S).focus(r[0]);
                h.distortion(S).focus(r[1]);
                X.select(".nv-scatterWrap").call(e);
                y && X.select(".nv-x.nv-axis").call(t);
                b && X.select(".nv-y.nv-axis").call(n);
                X.select(".nv-distributionX").datum(N.filter(function(e) {
                    return !e.disabled;
                })).call(s);
                X.select(".nv-distributionY").datum(N.filter(function(e) {
                    return !e.disabled;
                })).call(o);
            }
            var C = d3.select(this), k = this, F = (a || parseInt(C.style("width")) || 960) - u.left - u.right, I = (f || parseInt(C.style("height")) || 400) - u.top - u.bottom;
            j.update = function() {
                C.transition().duration(_).call(j);
            };
            j.container = this;
            L.disabled = N.map(function(e) {
                return !!e.disabled;
            });
            if (!A) {
                var q;
                A = {};
                for (q in L) L[q] instanceof Array ? A[q] = L[q].slice(0) : A[q] = L[q];
            }
            if (!N || !N.length || !N.filter(function(e) {
                return e.values.length;
            }).length) {
                var R = C.selectAll(".nv-noData").data([ M ]);
                R.enter().append("text").attr("class", "nvd3 nv-noData").attr("dy", "-.7em").style("text-anchor", "middle");
                R.attr("x", u.left + F / 2).attr("y", u.top + I / 2).text(function(e) {
                    return e;
                });
                return j;
            }
            C.selectAll(".nv-noData").remove();
            D = D || c;
            P = P || h;
            var U = C.selectAll("g.nv-wrap.nv-scatterChart").data([ N ]), z = U.enter().append("g").attr("class", "nvd3 nv-wrap nv-scatterChart nv-chart-" + e.id()), W = z.append("g"), X = U.select("g");
            W.append("rect").attr("class", "nvd3 nv-background");
            W.append("g").attr("class", "nv-x nv-axis");
            W.append("g").attr("class", "nv-y nv-axis");
            W.append("g").attr("class", "nv-scatterWrap");
            W.append("g").attr("class", "nv-distWrap");
            W.append("g").attr("class", "nv-legendWrap");
            W.append("g").attr("class", "nv-controlsWrap");
            if (g) {
                var V = E ? F / 2 : F;
                r.width(V);
                U.select(".nv-legendWrap").datum(N).call(r);
                if (u.top != r.height()) {
                    u.top = r.height();
                    I = (f || parseInt(C.style("height")) || 400) - u.top - u.bottom;
                }
                U.select(".nv-legendWrap").attr("transform", "translate(" + (F - V) + "," + -u.top + ")");
            }
            if (E) {
                i.width(180).color([ "#444" ]);
                X.select(".nv-controlsWrap").datum(B).attr("transform", "translate(0," + -u.top + ")").call(i);
            }
            U.attr("transform", "translate(" + u.left + "," + u.top + ")");
            w && X.select(".nv-y.nv-axis").attr("transform", "translate(" + F + ",0)");
            e.width(F).height(I).color(N.map(function(e, t) {
                return e.color || l(e, t);
            }).filter(function(e, t) {
                return !N[t].disabled;
            }));
            p !== 0 && e.xDomain(null);
            d !== 0 && e.yDomain(null);
            U.select(".nv-scatterWrap").datum(N.filter(function(e) {
                return !e.disabled;
            })).call(e);
            if (p !== 0) {
                var $ = c.domain()[1] - c.domain()[0];
                e.xDomain([ c.domain()[0] - p * $, c.domain()[1] + p * $ ]);
            }
            if (d !== 0) {
                var J = h.domain()[1] - h.domain()[0];
                e.yDomain([ h.domain()[0] - d * J, h.domain()[1] + d * J ]);
            }
            (d !== 0 || p !== 0) && U.select(".nv-scatterWrap").datum(N.filter(function(e) {
                return !e.disabled;
            })).call(e);
            if (y) {
                t.scale(c).ticks(t.ticks() && t.ticks().length ? t.ticks() : F / 100).tickSize(-I, 0);
                X.select(".nv-x.nv-axis").attr("transform", "translate(0," + h.range()[0] + ")").call(t);
            }
            if (b) {
                n.scale(h).ticks(n.ticks() && n.ticks().length ? n.ticks() : I / 36).tickSize(-F, 0);
                X.select(".nv-y.nv-axis").call(n);
            }
            if (v) {
                s.getData(e.x()).scale(c).width(F).color(N.map(function(e, t) {
                    return e.color || l(e, t);
                }).filter(function(e, t) {
                    return !N[t].disabled;
                }));
                W.select(".nv-distWrap").append("g").attr("class", "nv-distributionX");
                X.select(".nv-distributionX").attr("transform", "translate(0," + h.range()[0] + ")").datum(N.filter(function(e) {
                    return !e.disabled;
                })).call(s);
            }
            if (m) {
                o.getData(e.y()).scale(h).width(I).color(N.map(function(e, t) {
                    return e.color || l(e, t);
                }).filter(function(e, t) {
                    return !N[t].disabled;
                }));
                W.select(".nv-distWrap").append("g").attr("class", "nv-distributionY");
                X.select(".nv-distributionY").attr("transform", "translate(" + (w ? F : -o.size()) + ",0)").datum(N.filter(function(e) {
                    return !e.disabled;
                })).call(o);
            }
            if (d3.fisheye) {
                X.select(".nv-background").attr("width", F).attr("height", I);
                X.select(".nv-background").on("mousemove", K);
                X.select(".nv-background").on("click", function() {
                    x = !x;
                });
                e.dispatch.on("elementClick.freezeFisheye", function() {
                    x = !x;
                });
            }
            i.dispatch.on("legendClick", function(r, i) {
                r.disabled = !r.disabled;
                S = r.disabled ? 0 : 2.5;
                X.select(".nv-background").style("pointer-events", r.disabled ? "none" : "all");
                X.select(".nv-point-paths").style("pointer-events", r.disabled ? "all" : "none");
                if (r.disabled) {
                    c.distortion(S).focus(0);
                    h.distortion(S).focus(0);
                    X.select(".nv-scatterWrap").call(e);
                    X.select(".nv-x.nv-axis").call(t);
                    X.select(".nv-y.nv-axis").call(n);
                } else x = !1;
                j.update();
            });
            r.dispatch.on("stateChange", function(e) {
                L.disabled = e.disabled;
                O.stateChange(L);
                j.update();
            });
            e.dispatch.on("elementMouseover.tooltip", function(t) {
                d3.select(".nv-chart-" + e.id() + " .nv-series-" + t.seriesIndex + " .nv-distx-" + t.pointIndex).attr("y1", function(e, n) {
                    return t.pos[1] - I;
                });
                d3.select(".nv-chart-" + e.id() + " .nv-series-" + t.seriesIndex + " .nv-disty-" + t.pointIndex).attr("x2", t.pos[0] + s.size());
                t.pos = [ t.pos[0] + u.left, t.pos[1] + u.top ];
                O.tooltipShow(t);
            });
            O.on("tooltipShow", function(e) {
                T && H(e, k.parentNode);
            });
            O.on("changeState", function(e) {
                if (typeof e.disabled != "undefined") {
                    N.forEach(function(t, n) {
                        t.disabled = e.disabled[n];
                    });
                    L.disabled = e.disabled;
                }
                j.update();
            });
            D = c.copy();
            P = h.copy();
        });
        return j;
    }
    var e = nv.models.scatter(), t = nv.models.axis(), n = nv.models.axis(), r = nv.models.legend(), i = nv.models.legend(), s = nv.models.distribution(), o = nv.models.distribution(), u = {
        top: 30,
        right: 20,
        bottom: 50,
        left: 75
    }, a = null, f = null, l = nv.utils.defaultColor(), c = d3.fisheye ? d3.fisheye.scale(d3.scale.linear).distortion(0) : e.xScale(), h = d3.fisheye ? d3.fisheye.scale(d3.scale.linear).distortion(0) : e.yScale(), p = 0, d = 0, v = !1, m = !1, g = !0, y = !0, b = !0, w = !1, E = !!d3.fisheye, S = 0, x = !1, T = !0, N = function(e, t, n) {
        return "<strong>" + t + "</strong>";
    }, C = function(e, t, n) {
        return "<strong>" + n + "</strong>";
    }, k = null, L = {}, A = null, O = d3.dispatch("tooltipShow", "tooltipHide", "stateChange", "changeState"), M = "No Data Available.", _ = 250;
    e.xScale(c).yScale(h);
    t.orient("bottom").tickPadding(10);
    n.orient(w ? "right" : "left").tickPadding(10);
    s.axis("x");
    o.axis("y");
    i.updateState(!1);
    var D, P, H = function(r, i) {
        var s = r.pos[0] + (i.offsetLeft || 0), o = r.pos[1] + (i.offsetTop || 0), a = r.pos[0] + (i.offsetLeft || 0), f = h.range()[0] + u.top + (i.offsetTop || 0), l = c.range()[0] + u.left + (i.offsetLeft || 0), p = r.pos[1] + (i.offsetTop || 0), d = t.tickFormat()(e.x()(r.point, r.pointIndex)), v = n.tickFormat()(e.y()(r.point, r.pointIndex));
        N != null && nv.tooltip.show([ a, f ], N(r.series.key, d, v, r, j), "n", 1, i, "x-nvtooltip");
        C != null && nv.tooltip.show([ l, p ], C(r.series.key, d, v, r, j), "e", 1, i, "y-nvtooltip");
        k != null && nv.tooltip.show([ s, o ], k(r.series.key, d, v, r, j), r.value < 0 ? "n" : "s", null, i);
    }, B = [ {
        key: "Magnify",
        disabled: !0
    } ];
    e.dispatch.on("elementMouseout.tooltip", function(t) {
        O.tooltipHide(t);
        d3.select(".nv-chart-" + e.id() + " .nv-series-" + t.seriesIndex + " .nv-distx-" + t.pointIndex).attr("y1", 0);
        d3.select(".nv-chart-" + e.id() + " .nv-series-" + t.seriesIndex + " .nv-disty-" + t.pointIndex).attr("x2", o.size());
    });
    O.on("tooltipHide", function() {
        T && nv.tooltip.cleanup();
    });
    j.dispatch = O;
    j.scatter = e;
    j.legend = r;
    j.controls = i;
    j.xAxis = t;
    j.yAxis = n;
    j.distX = s;
    j.distY = o;
    d3.rebind(j, e, "id", "interactive", "pointActive", "x", "y", "shape", "size", "xScale", "yScale", "zScale", "xDomain", "yDomain", "xRange", "yRange", "sizeDomain", "sizeRange", "forceX", "forceY", "forceSize", "clipVoronoi", "clipRadius", "useVoronoi");
    j.options = nv.utils.optionsFunc.bind(j);
    j.margin = function(e) {
        if (!arguments.length) return u;
        u.top = typeof e.top != "undefined" ? e.top : u.top;
        u.right = typeof e.right != "undefined" ? e.right : u.right;
        u.bottom = typeof e.bottom != "undefined" ? e.bottom : u.bottom;
        u.left = typeof e.left != "undefined" ? e.left : u.left;
        return j;
    };
    j.width = function(e) {
        if (!arguments.length) return a;
        a = e;
        return j;
    };
    j.height = function(e) {
        if (!arguments.length) return f;
        f = e;
        return j;
    };
    j.color = function(e) {
        if (!arguments.length) return l;
        l = nv.utils.getColor(e);
        r.color(l);
        s.color(l);
        o.color(l);
        return j;
    };
    j.showDistX = function(e) {
        if (!arguments.length) return v;
        v = e;
        return j;
    };
    j.showDistY = function(e) {
        if (!arguments.length) return m;
        m = e;
        return j;
    };
    j.showControls = function(e) {
        if (!arguments.length) return E;
        E = e;
        return j;
    };
    j.showLegend = function(e) {
        if (!arguments.length) return g;
        g = e;
        return j;
    };
    j.showXAxis = function(e) {
        if (!arguments.length) return y;
        y = e;
        return j;
    };
    j.showYAxis = function(e) {
        if (!arguments.length) return b;
        b = e;
        return j;
    };
    j.rightAlignYAxis = function(e) {
        if (!arguments.length) return w;
        w = e;
        n.orient(e ? "right" : "left");
        return j;
    };
    j.fisheye = function(e) {
        if (!arguments.length) return S;
        S = e;
        return j;
    };
    j.xPadding = function(e) {
        if (!arguments.length) return p;
        p = e;
        return j;
    };
    j.yPadding = function(e) {
        if (!arguments.length) return d;
        d = e;
        return j;
    };
    j.tooltips = function(e) {
        if (!arguments.length) return T;
        T = e;
        return j;
    };
    j.tooltipContent = function(e) {
        if (!arguments.length) return k;
        k = e;
        return j;
    };
    j.tooltipXContent = function(e) {
        if (!arguments.length) return N;
        N = e;
        return j;
    };
    j.tooltipYContent = function(e) {
        if (!arguments.length) return C;
        C = e;
        return j;
    };
    j.state = function(e) {
        if (!arguments.length) return L;
        L = e;
        return j;
    };
    j.defaultState = function(e) {
        if (!arguments.length) return A;
        A = e;
        return j;
    };
    j.noData = function(e) {
        if (!arguments.length) return M;
        M = e;
        return j;
    };
    j.transitionDuration = function(e) {
        if (!arguments.length) return _;
        _ = e;
        return j;
    };
    return j;
};
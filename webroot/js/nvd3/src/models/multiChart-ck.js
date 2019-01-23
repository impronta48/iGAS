nv.models.multiChart = function() {
    "use strict";
    function N(o) {
        o.each(function(o) {
            var a = d3.select(this), C = this;
            N.update = function() {
                a.transition().call(N);
            };
            N.container = this;
            var k = (n || parseInt(a.style("width")) || 960) - e.left - e.right, L = (r || parseInt(a.style("height")) || 400) - e.top - e.bottom, A = o.filter(function(e) {
                return !e.disabled && e.type == "line" && e.yAxis == 1;
            }), O = o.filter(function(e) {
                return !e.disabled && e.type == "line" && e.yAxis == 2;
            }), M = o.filter(function(e) {
                return !e.disabled && e.type == "bar" && e.yAxis == 1;
            }), _ = o.filter(function(e) {
                return !e.disabled && e.type == "bar" && e.yAxis == 2;
            }), D = o.filter(function(e) {
                return !e.disabled && e.type == "area" && e.yAxis == 1;
            }), P = o.filter(function(e) {
                return !e.disabled && e.type == "area" && e.yAxis == 2;
            }), H = o.filter(function(e) {
                return !e.disabled && e.yAxis == 1;
            }).map(function(e) {
                return e.values.map(function(e, t) {
                    return {
                        x: e.x,
                        y: e.y
                    };
                });
            }), B = o.filter(function(e) {
                return !e.disabled && e.yAxis == 2;
            }).map(function(e) {
                return e.values.map(function(e, t) {
                    return {
                        x: e.x,
                        y: e.y
                    };
                });
            });
            u.domain(d3.extent(d3.merge(H.concat(B)), function(e) {
                return e.x;
            })).range([ 0, k ]);
            var j = a.selectAll("g.wrap.multiChart").data([ o ]), F = j.enter().append("g").attr("class", "wrap nvd3 multiChart").append("g");
            F.append("g").attr("class", "x axis");
            F.append("g").attr("class", "y1 axis");
            F.append("g").attr("class", "y2 axis");
            F.append("g").attr("class", "lines1Wrap");
            F.append("g").attr("class", "lines2Wrap");
            F.append("g").attr("class", "bars1Wrap");
            F.append("g").attr("class", "bars2Wrap");
            F.append("g").attr("class", "stack1Wrap");
            F.append("g").attr("class", "stack2Wrap");
            F.append("g").attr("class", "legendWrap");
            var I = j.select("g");
            if (i) {
                S.width(k / 2);
                I.select(".legendWrap").datum(o.map(function(e) {
                    e.originalKey = e.originalKey === undefined ? e.key : e.originalKey;
                    e.key = e.originalKey + (e.yAxis == 1 ? "" : " (right axis)");
                    return e;
                })).call(S);
                if (e.top != S.height()) {
                    e.top = S.height();
                    L = (r || parseInt(a.style("height")) || 400) - e.top - e.bottom;
                }
                I.select(".legendWrap").attr("transform", "translate(" + k / 2 + "," + -e.top + ")");
            }
            p.width(k).height(L).interpolate("monotone").color(o.map(function(e, n) {
                return e.color || t[n % t.length];
            }).filter(function(e, t) {
                return !o[t].disabled && o[t].yAxis == 1 && o[t].type == "line";
            }));
            d.width(k).height(L).interpolate("monotone").color(o.map(function(e, n) {
                return e.color || t[n % t.length];
            }).filter(function(e, t) {
                return !o[t].disabled && o[t].yAxis == 2 && o[t].type == "line";
            }));
            v.width(k).height(L).color(o.map(function(e, n) {
                return e.color || t[n % t.length];
            }).filter(function(e, t) {
                return !o[t].disabled && o[t].yAxis == 1 && o[t].type == "bar";
            }));
            m.width(k).height(L).color(o.map(function(e, n) {
                return e.color || t[n % t.length];
            }).filter(function(e, t) {
                return !o[t].disabled && o[t].yAxis == 2 && o[t].type == "bar";
            }));
            g.width(k).height(L).color(o.map(function(e, n) {
                return e.color || t[n % t.length];
            }).filter(function(e, t) {
                return !o[t].disabled && o[t].yAxis == 1 && o[t].type == "area";
            }));
            y.width(k).height(L).color(o.map(function(e, n) {
                return e.color || t[n % t.length];
            }).filter(function(e, t) {
                return !o[t].disabled && o[t].yAxis == 2 && o[t].type == "area";
            }));
            I.attr("transform", "translate(" + e.left + "," + e.top + ")");
            var q = I.select(".lines1Wrap").datum(A), R = I.select(".bars1Wrap").datum(M), U = I.select(".stack1Wrap").datum(D), z = I.select(".lines2Wrap").datum(O), W = I.select(".bars2Wrap").datum(_), X = I.select(".stack2Wrap").datum(P), V = D.length ? D.map(function(e) {
                return e.values;
            }).reduce(function(e, t) {
                return e.map(function(e, n) {
                    return {
                        x: e.x,
                        y: e.y + t[n].y
                    };
                });
            }).concat([ {
                x: 0,
                y: 0
            } ]) : [], $ = P.length ? P.map(function(e) {
                return e.values;
            }).reduce(function(e, t) {
                return e.map(function(e, n) {
                    return {
                        x: e.x,
                        y: e.y + t[n].y
                    };
                });
            }).concat([ {
                x: 0,
                y: 0
            } ]) : [];
            c.domain(f || d3.extent(d3.merge(H).concat(V), function(e) {
                return e.y;
            })).range([ 0, L ]);
            h.domain(l || d3.extent(d3.merge(B).concat($), function(e) {
                return e.y;
            })).range([ 0, L ]);
            p.yDomain(c.domain());
            v.yDomain(c.domain());
            g.yDomain(c.domain());
            d.yDomain(h.domain());
            m.yDomain(h.domain());
            y.yDomain(h.domain());
            D.length && d3.transition(U).call(g);
            P.length && d3.transition(X).call(y);
            M.length && d3.transition(R).call(v);
            _.length && d3.transition(W).call(m);
            A.length && d3.transition(q).call(p);
            O.length && d3.transition(z).call(d);
            b.ticks(k / 100).tickSize(-L, 0);
            I.select(".x.axis").attr("transform", "translate(0," + L + ")");
            d3.transition(I.select(".x.axis")).call(b);
            w.ticks(L / 36).tickSize(-k, 0);
            d3.transition(I.select(".y1.axis")).call(w);
            E.ticks(L / 36).tickSize(-k, 0);
            d3.transition(I.select(".y2.axis")).call(E);
            I.select(".y2.axis").style("opacity", B.length ? 1 : 0).attr("transform", "translate(" + u.range()[1] + ",0)");
            S.dispatch.on("stateChange", function(e) {
                N.update();
            });
            x.on("tooltipShow", function(e) {
                s && T(e, C.parentNode);
            });
        });
        return N;
    }
    var e = {
        top: 30,
        right: 20,
        bottom: 50,
        left: 60
    }, t = d3.scale.category20().range(), n = null, r = null, i = !0, s = !0, o = function(e, t, n, r, i) {
        return "<h3>" + e + "</h3>" + "<p>" + n + " at " + t + "</p>";
    }, u, a, f, l, u = d3.scale.linear(), c = d3.scale.linear(), h = d3.scale.linear(), p = nv.models.line().yScale(c), d = nv.models.line().yScale(h), v = nv.models.multiBar().stacked(!1).yScale(c), m = nv.models.multiBar().stacked(!1).yScale(h), g = nv.models.stackedArea().yScale(c), y = nv.models.stackedArea().yScale(h), b = nv.models.axis().scale(u).orient("bottom").tickPadding(5), w = nv.models.axis().scale(c).orient("left"), E = nv.models.axis().scale(h).orient("right"), S = nv.models.legend().height(30), x = d3.dispatch("tooltipShow", "tooltipHide"), T = function(e, t) {
        var n = e.pos[0] + (t.offsetLeft || 0), r = e.pos[1] + (t.offsetTop || 0), i = b.tickFormat()(p.x()(e.point, e.pointIndex)), s = (e.series.yAxis == 2 ? E : w).tickFormat()(p.y()(e.point, e.pointIndex)), u = o(e.series.key, i, s, e, N);
        nv.tooltip.show([ n, r ], u, undefined, undefined, t.offsetParent);
    };
    p.dispatch.on("elementMouseover.tooltip", function(t) {
        t.pos = [ t.pos[0] + e.left, t.pos[1] + e.top ];
        x.tooltipShow(t);
    });
    p.dispatch.on("elementMouseout.tooltip", function(e) {
        x.tooltipHide(e);
    });
    d.dispatch.on("elementMouseover.tooltip", function(t) {
        t.pos = [ t.pos[0] + e.left, t.pos[1] + e.top ];
        x.tooltipShow(t);
    });
    d.dispatch.on("elementMouseout.tooltip", function(e) {
        x.tooltipHide(e);
    });
    v.dispatch.on("elementMouseover.tooltip", function(t) {
        t.pos = [ t.pos[0] + e.left, t.pos[1] + e.top ];
        x.tooltipShow(t);
    });
    v.dispatch.on("elementMouseout.tooltip", function(e) {
        x.tooltipHide(e);
    });
    m.dispatch.on("elementMouseover.tooltip", function(t) {
        t.pos = [ t.pos[0] + e.left, t.pos[1] + e.top ];
        x.tooltipShow(t);
    });
    m.dispatch.on("elementMouseout.tooltip", function(e) {
        x.tooltipHide(e);
    });
    g.dispatch.on("tooltipShow", function(t) {
        if (!Math.round(g.y()(t.point) * 100)) {
            setTimeout(function() {
                d3.selectAll(".point.hover").classed("hover", !1);
            }, 0);
            return !1;
        }
        t.pos = [ t.pos[0] + e.left, t.pos[1] + e.top ], x.tooltipShow(t);
    });
    g.dispatch.on("tooltipHide", function(e) {
        x.tooltipHide(e);
    });
    y.dispatch.on("tooltipShow", function(t) {
        if (!Math.round(y.y()(t.point) * 100)) {
            setTimeout(function() {
                d3.selectAll(".point.hover").classed("hover", !1);
            }, 0);
            return !1;
        }
        t.pos = [ t.pos[0] + e.left, t.pos[1] + e.top ], x.tooltipShow(t);
    });
    y.dispatch.on("tooltipHide", function(e) {
        x.tooltipHide(e);
    });
    p.dispatch.on("elementMouseover.tooltip", function(t) {
        t.pos = [ t.pos[0] + e.left, t.pos[1] + e.top ];
        x.tooltipShow(t);
    });
    p.dispatch.on("elementMouseout.tooltip", function(e) {
        x.tooltipHide(e);
    });
    d.dispatch.on("elementMouseover.tooltip", function(t) {
        t.pos = [ t.pos[0] + e.left, t.pos[1] + e.top ];
        x.tooltipShow(t);
    });
    d.dispatch.on("elementMouseout.tooltip", function(e) {
        x.tooltipHide(e);
    });
    x.on("tooltipHide", function() {
        s && nv.tooltip.cleanup();
    });
    N.dispatch = x;
    N.lines1 = p;
    N.lines2 = d;
    N.bars1 = v;
    N.bars2 = m;
    N.stack1 = g;
    N.stack2 = y;
    N.xAxis = b;
    N.yAxis1 = w;
    N.yAxis2 = E;
    N.options = nv.utils.optionsFunc.bind(N);
    N.x = function(e) {
        if (!arguments.length) return getX;
        getX = e;
        p.x(e);
        v.x(e);
        return N;
    };
    N.y = function(e) {
        if (!arguments.length) return getY;
        getY = e;
        p.y(e);
        v.y(e);
        return N;
    };
    N.yDomain1 = function(e) {
        if (!arguments.length) return f;
        f = e;
        return N;
    };
    N.yDomain2 = function(e) {
        if (!arguments.length) return l;
        l = e;
        return N;
    };
    N.margin = function(t) {
        if (!arguments.length) return e;
        e = t;
        return N;
    };
    N.width = function(e) {
        if (!arguments.length) return n;
        n = e;
        return N;
    };
    N.height = function(e) {
        if (!arguments.length) return r;
        r = e;
        return N;
    };
    N.color = function(e) {
        if (!arguments.length) return t;
        t = e;
        S.color(e);
        return N;
    };
    N.showLegend = function(e) {
        if (!arguments.length) return i;
        i = e;
        return N;
    };
    N.tooltips = function(e) {
        if (!arguments.length) return s;
        s = e;
        return N;
    };
    N.tooltipContent = function(e) {
        if (!arguments.length) return o;
        o = e;
        return N;
    };
    return N;
};
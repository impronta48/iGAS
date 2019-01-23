nv.models.legend = function() {
    "use strict";
    function l(c) {
        c.each(function(l) {
            var c = t - e.left - e.right, h = d3.select(this), p = h.selectAll("g.nv-legend").data([ l ]), d = p.enter().append("g").attr("class", "nvd3 nv-legend").append("g"), v = p.select("g");
            p.attr("transform", "translate(" + e.left + "," + e.top + ")");
            var m = v.selectAll(".nv-series").data(function(e) {
                return e;
            }), g = m.enter().append("g").attr("class", "nv-series").on("mouseover", function(e, t) {
                f.legendMouseover(e, t);
            }).on("mouseout", function(e, t) {
                f.legendMouseout(e, t);
            }).on("click", function(e, t) {
                f.legendClick(e, t);
                if (u) {
                    if (a) {
                        l.forEach(function(e) {
                            e.disabled = !0;
                        });
                        e.disabled = !1;
                    } else {
                        e.disabled = !e.disabled;
                        l.every(function(e) {
                            return e.disabled;
                        }) && l.forEach(function(e) {
                            e.disabled = !1;
                        });
                    }
                    f.stateChange({
                        disabled: l.map(function(e) {
                            return !!e.disabled;
                        })
                    });
                }
            }).on("dblclick", function(e, t) {
                f.legendDblclick(e, t);
                if (u) {
                    l.forEach(function(e) {
                        e.disabled = !0;
                    });
                    e.disabled = !1;
                    f.stateChange({
                        disabled: l.map(function(e) {
                            return !!e.disabled;
                        })
                    });
                }
            });
            g.append("circle").style("stroke-width", 2).attr("class", "nv-legend-symbol").attr("r", 5);
            g.append("text").attr("text-anchor", "start").attr("class", "nv-legend-text").attr("dy", ".32em").attr("dx", "8");
            m.classed("disabled", function(e) {
                return e.disabled;
            });
            m.exit().remove();
            m.select("circle").style("fill", function(e, t) {
                return e.color || i(e, t);
            }).style("stroke", function(e, t) {
                return e.color || i(e, t);
            });
            m.select("text").text(r);
            if (s) {
                var y = [];
                m.each(function(e, t) {
                    var n = d3.select(this).select("text"), r;
                    try {
                        r = n.node().getComputedTextLength();
                    } catch (i) {
                        r = nv.utils.calcApproxTextWidth(n);
                    }
                    y.push(r + 28);
                });
                var b = 0, w = 0, E = [];
                while (w < c && b < y.length) {
                    E[b] = y[b];
                    w += y[b++];
                }
                b === 0 && (b = 1);
                while (w > c && b > 1) {
                    E = [];
                    b--;
                    for (var S = 0; S < y.length; S++) y[S] > (E[S % b] || 0) && (E[S % b] = y[S]);
                    w = E.reduce(function(e, t, n, r) {
                        return e + t;
                    });
                }
                var x = [];
                for (var T = 0, N = 0; T < b; T++) {
                    x[T] = N;
                    N += E[T];
                }
                m.attr("transform", function(e, t) {
                    return "translate(" + x[t % b] + "," + (5 + Math.floor(t / b) * 20) + ")";
                });
                o ? v.attr("transform", "translate(" + (t - e.right - w) + "," + e.top + ")") : v.attr("transform", "translate(0," + e.top + ")");
                n = e.top + e.bottom + Math.ceil(y.length / b) * 20;
            } else {
                var C = 5, k = 5, L = 0, A;
                m.attr("transform", function(n, r) {
                    var i = d3.select(this).select("text").node().getComputedTextLength() + 28;
                    A = k;
                    if (t < e.left + e.right + A + i) {
                        k = A = 5;
                        C += 20;
                    }
                    k += i;
                    k > L && (L = k);
                    return "translate(" + A + "," + C + ")";
                });
                v.attr("transform", "translate(" + (t - e.right - L) + "," + e.top + ")");
                n = e.top + e.bottom + C + 15;
            }
        });
        return l;
    }
    var e = {
        top: 5,
        right: 0,
        bottom: 5,
        left: 0
    }, t = 400, n = 20, r = function(e) {
        return e.key;
    }, i = nv.utils.defaultColor(), s = !0, o = !0, u = !0, a = !1, f = d3.dispatch("legendClick", "legendDblclick", "legendMouseover", "legendMouseout", "stateChange");
    l.dispatch = f;
    l.options = nv.utils.optionsFunc.bind(l);
    l.margin = function(t) {
        if (!arguments.length) return e;
        e.top = typeof t.top != "undefined" ? t.top : e.top;
        e.right = typeof t.right != "undefined" ? t.right : e.right;
        e.bottom = typeof t.bottom != "undefined" ? t.bottom : e.bottom;
        e.left = typeof t.left != "undefined" ? t.left : e.left;
        return l;
    };
    l.width = function(e) {
        if (!arguments.length) return t;
        t = e;
        return l;
    };
    l.height = function(e) {
        if (!arguments.length) return n;
        n = e;
        return l;
    };
    l.key = function(e) {
        if (!arguments.length) return r;
        r = e;
        return l;
    };
    l.color = function(e) {
        if (!arguments.length) return i;
        i = nv.utils.getColor(e);
        return l;
    };
    l.align = function(e) {
        if (!arguments.length) return s;
        s = e;
        return l;
    };
    l.rightAlign = function(e) {
        if (!arguments.length) return o;
        o = e;
        return l;
    };
    l.updateState = function(e) {
        if (!arguments.length) return u;
        u = e;
        return l;
    };
    l.radioButtonMode = function(e) {
        if (!arguments.length) return a;
        a = e;
        return l;
    };
    return l;
};
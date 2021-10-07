nv.models.axis = function() {
    "use strict";
    function d(r) {
        r.each(function(r) {
            var d = d3.select(this), v = d.selectAll("g.nv-wrap.nv-axis").data([ r ]), m = v.enter().append("g").attr("class", "nvd3 nv-wrap nv-axis"), g = m.append("g"), y = v.select("g");
            h !== null ? e.ticks(h) : (e.orient() == "top" || e.orient() == "bottom") && e.ticks(Math.abs(i.range()[1] - i.range()[0]) / 100);
            y.transition().call(e);
            p = p || e.scale();
            var b = e.tickFormat();
            b == null && (b = p.tickFormat());
            var w = y.selectAll("text.nv-axislabel").data([ s || null ]);
            w.exit().remove();
            switch (e.orient()) {
              case "top":
                w.enter().append("text").attr("class", "nv-axislabel");
                var E = i.range().length == 2 ? i.range()[1] : i.range()[i.range().length - 1] + (i.range()[1] - i.range()[0]);
                w.attr("text-anchor", "middle").attr("y", 0).attr("x", E / 2);
                if (o) {
                    var S = v.selectAll("g.nv-axisMaxMin").data(i.domain());
                    S.enter().append("g").attr("class", "nv-axisMaxMin").append("text");
                    S.exit().remove();
                    S.attr("transform", function(e, t) {
                        return "translate(" + i(e) + ",0)";
                    }).select("text").attr("dy", "0em").attr("y", -e.tickPadding()).attr("text-anchor", "middle").text(function(e, t) {
                        var n = b(e);
                        return ("" + n).match("NaN") ? "" : n;
                    });
                    S.transition().attr("transform", function(e, t) {
                        return "translate(" + i.range()[t] + ",0)";
                    });
                }
                break;
              case "bottom":
                var x = 36, T = 30, N = y.selectAll("g").select("text");
                if (a % 360) {
                    N.each(function(e, t) {
                        var n = this.getBBox().width;
                        n > T && (T = n);
                    });
                    var C = Math.abs(Math.sin(a * Math.PI / 180)), x = (C ? C * T : T) + 30;
                    N.attr("transform", function(e, t, n) {
                        return "rotate(" + a + " 0,0)";
                    }).style("text-anchor", a % 360 > 0 ? "start" : "end");
                }
                w.enter().append("text").attr("class", "nv-axislabel");
                var E = i.range().length == 2 ? i.range()[1] : i.range()[i.range().length - 1] + (i.range()[1] - i.range()[0]);
                w.attr("text-anchor", "middle").attr("y", x).attr("x", E / 2);
                if (o) {
                    var S = v.selectAll("g.nv-axisMaxMin").data([ i.domain()[0], i.domain()[i.domain().length - 1] ]);
                    S.enter().append("g").attr("class", "nv-axisMaxMin").append("text");
                    S.exit().remove();
                    S.attr("transform", function(e, t) {
                        return "translate(" + (i(e) + (c ? i.rangeBand() / 2 : 0)) + ",0)";
                    }).select("text").attr("dy", ".71em").attr("y", e.tickPadding()).attr("transform", function(e, t, n) {
                        return "rotate(" + a + " 0,0)";
                    }).style("text-anchor", a ? a % 360 > 0 ? "start" : "end" : "middle").text(function(e, t) {
                        var n = b(e);
                        return ("" + n).match("NaN") ? "" : n;
                    });
                    S.transition().attr("transform", function(e, t) {
                        return "translate(" + (i(e) + (c ? i.rangeBand() / 2 : 0)) + ",0)";
                    });
                }
                l && N.attr("transform", function(e, t) {
                    return "translate(0," + (t % 2 == 0 ? "0" : "12") + ")";
                });
                break;
              case "right":
                w.enter().append("text").attr("class", "nv-axislabel");
                w.style("text-anchor", f ? "middle" : "begin").attr("transform", f ? "rotate(90)" : "").attr("y", f ? -Math.max(t.right, n) + 12 : -10).attr("x", f ? i.range()[0] / 2 : e.tickPadding());
                if (o) {
                    var S = v.selectAll("g.nv-axisMaxMin").data(i.domain());
                    S.enter().append("g").attr("class", "nv-axisMaxMin").append("text").style("opacity", 0);
                    S.exit().remove();
                    S.attr("transform", function(e, t) {
                        return "translate(0," + i(e) + ")";
                    }).select("text").attr("dy", ".32em").attr("y", 0).attr("x", e.tickPadding()).style("text-anchor", "start").text(function(e, t) {
                        var n = b(e);
                        return ("" + n).match("NaN") ? "" : n;
                    });
                    S.transition().attr("transform", function(e, t) {
                        return "translate(0," + i.range()[t] + ")";
                    }).select("text").style("opacity", 1);
                }
                break;
              case "left":
                w.enter().append("text").attr("class", "nv-axislabel");
                w.style("text-anchor", f ? "middle" : "end").attr("transform", f ? "rotate(-90)" : "").attr("y", f ? -Math.max(t.left, n) + 12 : -10).attr("x", f ? -i.range()[0] / 2 : -e.tickPadding());
                if (o) {
                    var S = v.selectAll("g.nv-axisMaxMin").data(i.domain());
                    S.enter().append("g").attr("class", "nv-axisMaxMin").append("text").style("opacity", 0);
                    S.exit().remove();
                    S.attr("transform", function(e, t) {
                        return "translate(0," + p(e) + ")";
                    }).select("text").attr("dy", ".32em").attr("y", 0).attr("x", -e.tickPadding()).attr("text-anchor", "end").text(function(e, t) {
                        var n = b(e);
                        return ("" + n).match("NaN") ? "" : n;
                    });
                    S.transition().attr("transform", function(e, t) {
                        return "translate(0," + i.range()[t] + ")";
                    }).select("text").style("opacity", 1);
                }
            }
            w.text(function(e) {
                return e;
            });
            if (o && (e.orient() === "left" || e.orient() === "right")) {
                y.selectAll("g").each(function(e, t) {
                    d3.select(this).select("text").attr("opacity", 1);
                    if (i(e) < i.range()[1] + 10 || i(e) > i.range()[0] - 10) {
                        (e > 1e-10 || e < -1e-10) && d3.select(this).attr("opacity", 0);
                        d3.select(this).select("text").attr("opacity", 0);
                    }
                });
                i.domain()[0] == i.domain()[1] && i.domain()[0] == 0 && v.selectAll("g.nv-axisMaxMin").style("opacity", function(e, t) {
                    return t ? 0 : 1;
                });
            }
            if (o && (e.orient() === "top" || e.orient() === "bottom")) {
                var k = [];
                v.selectAll("g.nv-axisMaxMin").each(function(e, t) {
                    try {
                        t ? k.push(i(e) - this.getBBox().width - 4) : k.push(i(e) + this.getBBox().width + 4);
                    } catch (n) {
                        t ? k.push(i(e) - 4) : k.push(i(e) + 4);
                    }
                });
                y.selectAll("g").each(function(e, t) {
                    if (i(e) < k[0] || i(e) > k[1]) e > 1e-10 || e < -1e-10 ? d3.select(this).remove() : d3.select(this).select("text").remove();
                });
            }
            u && y.selectAll(".tick").filter(function(e) {
                return !parseFloat(Math.round(e.__data__ * 1e5) / 1e6) && e.__data__ !== undefined;
            }).classed("zero", !0);
            p = i.copy();
        });
        return d;
    }
    var e = d3.svg.axis(), t = {
        top: 0,
        right: 0,
        bottom: 0,
        left: 0
    }, n = 75, r = 60, i = d3.scale.linear(), s = null, o = !0, u = !0, a = 0, f = !0, l = !1, c = !1, h = null;
    e.scale(i).orient("bottom").tickFormat(function(e) {
        return e;
    });
    var p;
    d.axis = e;
    d3.rebind(d, e, "orient", "tickValues", "tickSubdivide", "tickSize", "tickPadding", "tickFormat");
    d3.rebind(d, i, "domain", "range", "rangeBand", "rangeBands");
    d.options = nv.utils.optionsFunc.bind(d);
    d.margin = function(e) {
        if (!arguments.length) return t;
        t.top = typeof e.top != "undefined" ? e.top : t.top;
        t.right = typeof e.right != "undefined" ? e.right : t.right;
        t.bottom = typeof e.bottom != "undefined" ? e.bottom : t.bottom;
        t.left = typeof e.left != "undefined" ? e.left : t.left;
        return d;
    };
    d.width = function(e) {
        if (!arguments.length) return n;
        n = e;
        return d;
    };
    d.ticks = function(e) {
        if (!arguments.length) return h;
        h = e;
        return d;
    };
    d.height = function(e) {
        if (!arguments.length) return r;
        r = e;
        return d;
    };
    d.axisLabel = function(e) {
        if (!arguments.length) return s;
        s = e;
        return d;
    };
    d.showMaxMin = function(e) {
        if (!arguments.length) return o;
        o = e;
        return d;
    };
    d.highlightZero = function(e) {
        if (!arguments.length) return u;
        u = e;
        return d;
    };
    d.scale = function(t) {
        if (!arguments.length) return i;
        i = t;
        e.scale(i);
        c = typeof i.rangeBands == "function";
        d3.rebind(d, i, "domain", "range", "rangeBand", "rangeBands");
        return d;
    };
    d.rotateYLabel = function(e) {
        if (!arguments.length) return f;
        f = e;
        return d;
    };
    d.rotateLabels = function(e) {
        if (!arguments.length) return a;
        a = e;
        return d;
    };
    d.staggerLabels = function(e) {
        if (!arguments.length) return l;
        l = e;
        return d;
    };
    return d;
};
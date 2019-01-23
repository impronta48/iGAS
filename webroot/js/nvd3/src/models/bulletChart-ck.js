// Chart design based on the recommendations of Stephen Few. Implementation
// based on the work of Clint Ivy, Jamie Love, and Jason Davies.
// http://projects.instantcognition.com/protovis/bulletchart/
nv.models.bulletChart = function() {
    "use strict";
    function v(t) {
        t.each(function(c, m) {
            var g = d3.select(this), y = (u || parseInt(g.style("width")) || 960) - r.left - r.right, b = a - r.top - r.bottom, w = this;
            v.update = function() {
                v(t);
            };
            v.container = this;
            if (!c || !i.call(this, c, m)) {
                var E = g.selectAll(".nv-noData").data([ h ]);
                E.enter().append("text").attr("class", "nvd3 nv-noData").attr("dy", "-.7em").style("text-anchor", "middle");
                E.attr("x", r.left + y / 2).attr("y", 18 + r.top + b / 2).text(function(e) {
                    return e;
                });
                return v;
            }
            g.selectAll(".nv-noData").remove();
            var S = i.call(this, c, m).slice().sort(d3.descending), x = s.call(this, c, m).slice().sort(d3.descending), T = o.call(this, c, m).slice().sort(d3.descending), N = g.selectAll("g.nv-wrap.nv-bulletChart").data([ c ]), C = N.enter().append("g").attr("class", "nvd3 nv-wrap nv-bulletChart"), k = C.append("g"), L = N.select("g");
            k.append("g").attr("class", "nv-bulletWrap");
            k.append("g").attr("class", "nv-titles");
            N.attr("transform", "translate(" + r.left + "," + r.top + ")");
            var A = d3.scale.linear().domain([ 0, Math.max(S[0], x[0], T[0]) ]).range(n ? [ y, 0 ] : [ 0, y ]), O = this.__chart__ || d3.scale.linear().domain([ 0, Infinity ]).range(A.range());
            this.__chart__ = A;
            var M = function(e) {
                return Math.abs(O(e) - O(0));
            }, _ = function(e) {
                return Math.abs(A(e) - A(0));
            }, D = k.select(".nv-titles").append("g").attr("text-anchor", "end").attr("transform", "translate(-6," + (a - r.top - r.bottom) / 2 + ")");
            D.append("text").attr("class", "nv-title").text(function(e) {
                return e.title;
            });
            D.append("text").attr("class", "nv-subtitle").attr("dy", "1em").text(function(e) {
                return e.subtitle;
            });
            e.width(y).height(b);
            var P = L.select(".nv-bulletWrap");
            d3.transition(P).call(e);
            var H = f || A.tickFormat(y / 100), B = L.selectAll("g.nv-tick").data(A.ticks(y / 50), function(e) {
                return this.textContent || H(e);
            }), j = B.enter().append("g").attr("class", "nv-tick").attr("transform", function(e) {
                return "translate(" + O(e) + ",0)";
            }).style("opacity", 1e-6);
            j.append("line").attr("y1", b).attr("y2", b * 7 / 6);
            j.append("text").attr("text-anchor", "middle").attr("dy", "1em").attr("y", b * 7 / 6).text(H);
            var F = d3.transition(B).attr("transform", function(e) {
                return "translate(" + A(e) + ",0)";
            }).style("opacity", 1);
            F.select("line").attr("y1", b).attr("y2", b * 7 / 6);
            F.select("text").attr("y", b * 7 / 6);
            d3.transition(B.exit()).attr("transform", function(e) {
                return "translate(" + A(e) + ",0)";
            }).style("opacity", 1e-6).remove();
            p.on("tooltipShow", function(e) {
                e.key = c.title;
                l && d(e, w.parentNode);
            });
        });
        d3.timer.flush();
        return v;
    }
    var e = nv.models.bullet(), t = "left", n = !1, r = {
        top: 5,
        right: 40,
        bottom: 20,
        left: 120
    }, i = function(e) {
        return e.ranges;
    }, s = function(e) {
        return e.markers;
    }, o = function(e) {
        return e.measures;
    }, u = null, a = 55, f = null, l = !0, c = function(e, t, n, r, i) {
        return "<h3>" + t + "</h3>" + "<p>" + n + "</p>";
    }, h = "No Data Available.", p = d3.dispatch("tooltipShow", "tooltipHide"), d = function(e, t) {
        var n = e.pos[0] + (t.offsetLeft || 0) + r.left, i = e.pos[1] + (t.offsetTop || 0) + r.top, s = c(e.key, e.label, e.value, e, v);
        nv.tooltip.show([ n, i ], s, e.value < 0 ? "e" : "w", null, t);
    };
    e.dispatch.on("elementMouseover.tooltip", function(e) {
        p.tooltipShow(e);
    });
    e.dispatch.on("elementMouseout.tooltip", function(e) {
        p.tooltipHide(e);
    });
    p.on("tooltipHide", function() {
        l && nv.tooltip.cleanup();
    });
    v.dispatch = p;
    v.bullet = e;
    d3.rebind(v, e, "color");
    v.options = nv.utils.optionsFunc.bind(v);
    v.orient = function(e) {
        if (!arguments.length) return t;
        t = e;
        n = t == "right" || t == "bottom";
        return v;
    };
    v.ranges = function(e) {
        if (!arguments.length) return i;
        i = e;
        return v;
    };
    v.markers = function(e) {
        if (!arguments.length) return s;
        s = e;
        return v;
    };
    v.measures = function(e) {
        if (!arguments.length) return o;
        o = e;
        return v;
    };
    v.width = function(e) {
        if (!arguments.length) return u;
        u = e;
        return v;
    };
    v.height = function(e) {
        if (!arguments.length) return a;
        a = e;
        return v;
    };
    v.margin = function(e) {
        if (!arguments.length) return r;
        r.top = typeof e.top != "undefined" ? e.top : r.top;
        r.right = typeof e.right != "undefined" ? e.right : r.right;
        r.bottom = typeof e.bottom != "undefined" ? e.bottom : r.bottom;
        r.left = typeof e.left != "undefined" ? e.left : r.left;
        return v;
    };
    v.tickFormat = function(e) {
        if (!arguments.length) return f;
        f = e;
        return v;
    };
    v.tooltips = function(e) {
        if (!arguments.length) return l;
        l = e;
        return v;
    };
    v.tooltipContent = function(e) {
        if (!arguments.length) return c;
        c = e;
        return v;
    };
    v.noData = function(e) {
        if (!arguments.length) return h;
        h = e;
        return v;
    };
    return v;
};
// Chart design based on the recommendations of Stephen Few. Implementation
// based on the work of Clint Ivy, Jamie Love, and Jason Davies.
// http://projects.instantcognition.com/protovis/bulletchart/
nv.models.bulletChart = function() {
    function v(t) {
        t.each(function(c, h) {
            var m = d3.select(this), g = (u || parseInt(m.style("width")) || 960) - r.left - r.right, y = a - r.top - r.bottom, b = this;
            v.update = function() {
                v(t);
            };
            v.container = this;
            var w = i.call(this, c, h).slice().sort(d3.descending), E = s.call(this, c, h).slice().sort(d3.descending), S = o.call(this, c, h).slice().sort(d3.descending), x = m.selectAll("g.nv-wrap.nv-bulletChart").data([ c ]), T = x.enter().append("g").attr("class", "nvd3 nv-wrap nv-bulletChart"), N = T.append("g"), C = x.select("g");
            N.append("g").attr("class", "nv-bulletWrap");
            N.append("g").attr("class", "nv-titles");
            x.attr("transform", "translate(" + r.left + "," + (r.top + h * a) + ")");
            var k = Math.max(w[0] ? w[0] : 0, E[0] ? E[0] : 0, S[0] ? S[0] : 0), L = d3.scale.linear().domain([ 0, k ]).nice().range(n ? [ g, 0 ] : [ 0, g ]), A = this.__chart__ || d3.scale.linear().domain([ 0, Infinity ]).range(L.range());
            this.__chart__ = L;
            var O = function(e) {
                return Math.abs(A(e) - A(0));
            }, M = function(e) {
                return Math.abs(L(e) - L(0));
            }, _ = N.select(".nv-titles").append("g").attr("text-anchor", "end").attr("transform", "translate(-6," + (a - r.top - r.bottom) / 2 + ")");
            _.append("text").attr("class", "nv-title").text(function(e) {
                return e.title;
            });
            _.append("text").attr("class", "nv-subtitle").attr("dy", "1em").text(function(e) {
                return e.subtitle;
            });
            e.width(g).height(y);
            var D = C.select(".nv-bulletWrap");
            d3.transition(D).call(e);
            var P = f || L.tickFormat(8), H = C.selectAll("g.nv-tick").data(L.ticks(8), function(e) {
                return this.textContent || P(e);
            }), B = H.enter().append("g").attr("class", "nv-tick").attr("transform", function(e) {
                return "translate(" + A(e) + ",0)";
            }).style("opacity", 1e-6);
            B.append("line").attr("y1", y).attr("y2", y * 7 / 6);
            B.append("text").attr("text-anchor", "middle").attr("dy", "1em").attr("y", y * 7 / 6).text(P);
            d3.transition(B).attr("transform", function(e) {
                return "translate(" + L(e) + ",0)";
            }).style("opacity", 1);
            var j = d3.transition(H).attr("transform", function(e) {
                return "translate(" + L(e) + ",0)";
            }).style("opacity", 1);
            j.select("line").attr("y1", y).attr("y2", y * 7 / 6);
            j.select("text").attr("y", y * 7 / 6);
            d3.transition(H.exit()).attr("transform", function(e) {
                return "translate(" + L(e) + ",0)";
            }).style("opacity", 1e-6).remove();
            p.on("tooltipShow", function(e) {
                l && d(e, b.parentNode);
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
        return "<h3>" + r.label + "</h3>" + "<p>" + r.value + "</p>";
    }, h = "No Data Available.", p = d3.dispatch("tooltipShow", "tooltipHide"), d = function(e, t) {
        var n = t.parentNode.parentNode, i = e.pos[0] + n.offsetLeft + r.left, s = e.pos[1] + n.offsetTop + r.top, o = "<h3>" + e.label + "</h3>" + "<p>" + e.value + "</p>";
        nv.tooltip.show([ i, s ], o, e.value < 0 ? "e" : "w", null, n.parentNode);
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
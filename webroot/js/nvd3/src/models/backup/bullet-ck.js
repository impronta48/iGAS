// Chart design based on the recommendations of Stephen Few. Implementation
// based on the work of Clint Ivy, Jamie Love, and Jason Davies.
// http://projects.instantcognition.com/protovis/bulletchart/
nv.models.bullet = function() {
    function c(t) {
        t.each(function(t, o) {
            var f = u - e.left - e.right, c = a - e.top - e.bottom, h = d3.select(this), p = nv.log(this.parentNode.parentNode).getAttribute("transform"), d = nv.log(parseInt(p.replace(/.*,(\d+)\)/, "$1"))), v = r.call(this, t, o).slice().sort(d3.descending), m = i.call(this, t, o).slice().sort(d3.descending), g = s.call(this, t, o).slice().sort(d3.descending), y = Math.max(v[0] ? v[0] : 0, m[0] ? m[0] : 0, g[0] ? g[0] : 0), b = d3.scale.linear().domain([ 0, y ]).nice().range(n ? [ f, 0 ] : [ 0, f ]), w = this.__chart__ || d3.scale.linear().domain([ 0, Infinity ]).range(b.range());
            this.__chart__ = b;
            var E = h.selectAll("g.nv-wrap.nv-bullet").data([ t ]), S = E.enter().append("g").attr("class", "nvd3 nv-wrap nv-bullet"), x = S.append("g"), T = E.select("g");
            E.attr("transform", "translate(" + e.left + "," + e.top + ")");
            var N = function(e) {
                return Math.abs(w(e) - w(0));
            }, C = function(e) {
                return Math.abs(b(e) - b(0));
            }, k = T.selectAll("rect.nv-range").data(v);
            k.enter().append("rect").attr("class", function(e, t) {
                return "nv-range nv-s" + t;
            }).attr("width", N).attr("height", c).attr("x", n ? w : 0).on("mouseover", function(e, t) {
                l.elementMouseover({
                    value: e,
                    label: t <= 0 ? "Maximum" : t > 1 ? "Minimum" : "Mean",
                    pos: [ b(e), d ]
                });
            }).on("mouseout", function(e, t) {
                l.elementMouseout({
                    value: e,
                    label: t <= 0 ? "Minimum" : t >= 1 ? "Maximum" : "Mean"
                });
            });
            d3.transition(k).attr("x", n ? b : 0).attr("width", C).attr("height", c);
            var L = T.selectAll("rect.nv-measure").data(g);
            L.enter().append("rect").attr("class", function(e, t) {
                return "nv-measure nv-s" + t;
            }).attr("width", N).attr("height", c / 3).attr("x", n ? w : 0).attr("y", c / 3).on("mouseover", function(e) {
                l.elementMouseover({
                    value: e,
                    label: "Current",
                    pos: [ b(e), d ]
                });
            }).on("mouseout", function(e) {
                l.elementMouseout({
                    value: e,
                    label: "Current"
                });
            });
            d3.transition(L).attr("width", C).attr("height", c / 3).attr("x", n ? b : 0).attr("y", c / 3);
            var A = T.selectAll("path.nv-markerTriangle").data(m), O = c / 6;
            A.enter().append("path").attr("class", "nv-markerTriangle").attr("transform", function(e) {
                return "translate(" + w(e) + "," + c / 2 + ")";
            }).attr("d", "M0," + O + "L" + O + "," + -O + " " + -O + "," + -O + "Z").on("mouseover", function(e, t) {
                l.elementMouseover({
                    value: e,
                    label: "Previous",
                    pos: [ b(e), d ]
                });
            }).on("mouseout", function(e, t) {
                l.elementMouseout({
                    value: e,
                    label: "Previous"
                });
            });
            d3.transition(A).attr("transform", function(e) {
                return "translate(" + b(e) + "," + c / 2 + ")";
            });
            A.exit().remove();
        });
        d3.timer.flush();
        return c;
    }
    var e = {
        top: 0,
        right: 0,
        bottom: 0,
        left: 0
    }, t = "left", n = !1, r = function(e) {
        return e.ranges;
    }, i = function(e) {
        return e.markers;
    }, s = function(e) {
        return e.measures;
    }, o = [ 0 ], u = 380, a = 30, f = null, l = d3.dispatch("elementMouseover", "elementMouseout");
    c.dispatch = l;
    c.orient = function(e) {
        if (!arguments.length) return t;
        t = e;
        n = t == "right" || t == "bottom";
        return c;
    };
    c.ranges = function(e) {
        if (!arguments.length) return r;
        r = e;
        return c;
    };
    c.markers = function(e) {
        if (!arguments.length) return i;
        i = e;
        return c;
    };
    c.measures = function(e) {
        if (!arguments.length) return s;
        s = e;
        return c;
    };
    c.forceX = function(e) {
        if (!arguments.length) return o;
        o = e;
        return c;
    };
    c.width = function(e) {
        if (!arguments.length) return u;
        u = e;
        return c;
    };
    c.height = function(e) {
        if (!arguments.length) return a;
        a = e;
        return c;
    };
    c.margin = function(t) {
        if (!arguments.length) return e;
        e.top = typeof t.top != "undefined" ? t.top : e.top;
        e.right = typeof t.right != "undefined" ? t.right : e.right;
        e.bottom = typeof t.bottom != "undefined" ? t.bottom : e.bottom;
        e.left = typeof t.left != "undefined" ? t.left : e.left;
        return c;
    };
    c.tickFormat = function(e) {
        if (!arguments.length) return f;
        f = e;
        return c;
    };
    return c;
};
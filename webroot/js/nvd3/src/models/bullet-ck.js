// Chart design based on the recommendations of Stephen Few. Implementation
// based on the work of Clint Ivy, Jamie Love, and Jason Davies.
// http://projects.instantcognition.com/protovis/bulletchart/
nv.models.bullet = function() {
    "use strict";
    function v(t) {
        t.each(function(t, h) {
            var v = l - e.left - e.right, m = c - e.top - e.bottom, g = d3.select(this), y = r.call(this, t, h).slice().sort(d3.descending), b = i.call(this, t, h).slice().sort(d3.descending), w = s.call(this, t, h).slice().sort(d3.descending), E = o.call(this, t, h).slice(), S = u.call(this, t, h).slice(), x = a.call(this, t, h).slice(), T = d3.scale.linear().domain(d3.extent(d3.merge([ f, y ]))).range(n ? [ v, 0 ] : [ 0, v ]), N = this.__chart__ || d3.scale.linear().domain([ 0, Infinity ]).range(T.range());
            this.__chart__ = T;
            var C = d3.min(y), k = d3.max(y), L = y[1], A = g.selectAll("g.nv-wrap.nv-bullet").data([ t ]), O = A.enter().append("g").attr("class", "nvd3 nv-wrap nv-bullet"), M = O.append("g"), _ = A.select("g");
            M.append("rect").attr("class", "nv-range nv-rangeMax");
            M.append("rect").attr("class", "nv-range nv-rangeAvg");
            M.append("rect").attr("class", "nv-range nv-rangeMin");
            M.append("rect").attr("class", "nv-measure");
            M.append("path").attr("class", "nv-markerTriangle");
            A.attr("transform", "translate(" + e.left + "," + e.top + ")");
            var D = function(e) {
                return Math.abs(N(e) - N(0));
            }, P = function(e) {
                return Math.abs(T(e) - T(0));
            }, H = function(e) {
                return e < 0 ? N(e) : N(0);
            }, B = function(e) {
                return e < 0 ? T(e) : T(0);
            };
            _.select("rect.nv-rangeMax").attr("height", m).attr("width", P(k > 0 ? k : C)).attr("x", B(k > 0 ? k : C)).datum(k > 0 ? k : C);
            _.select("rect.nv-rangeAvg").attr("height", m).attr("width", P(L)).attr("x", B(L)).datum(L);
            _.select("rect.nv-rangeMin").attr("height", m).attr("width", P(k)).attr("x", B(k)).attr("width", P(k > 0 ? C : k)).attr("x", B(k > 0 ? C : k)).datum(k > 0 ? C : k);
            _.select("rect.nv-measure").style("fill", p).attr("height", m / 3).attr("y", m / 3).attr("width", w < 0 ? T(0) - T(w[0]) : T(w[0]) - T(0)).attr("x", B(w)).on("mouseover", function() {
                d.elementMouseover({
                    value: w[0],
                    label: x[0] || "Current",
                    pos: [ T(w[0]), m / 2 ]
                });
            }).on("mouseout", function() {
                d.elementMouseout({
                    value: w[0],
                    label: x[0] || "Current"
                });
            });
            var j = m / 6;
            b[0] ? _.selectAll("path.nv-markerTriangle").attr("transform", function(e) {
                return "translate(" + T(b[0]) + "," + m / 2 + ")";
            }).attr("d", "M0," + j + "L" + j + "," + -j + " " + -j + "," + -j + "Z").on("mouseover", function() {
                d.elementMouseover({
                    value: b[0],
                    label: S[0] || "Previous",
                    pos: [ T(b[0]), m / 2 ]
                });
            }).on("mouseout", function() {
                d.elementMouseout({
                    value: b[0],
                    label: S[0] || "Previous"
                });
            }) : _.selectAll("path.nv-markerTriangle").remove();
            A.selectAll(".nv-range").on("mouseover", function(e, t) {
                var n = E[t] || (t ? t == 1 ? "Mean" : "Minimum" : "Maximum");
                d.elementMouseover({
                    value: e,
                    label: n,
                    pos: [ T(e), m / 2 ]
                });
            }).on("mouseout", function(e, t) {
                var n = E[t] || (t ? t == 1 ? "Mean" : "Minimum" : "Maximum");
                d.elementMouseout({
                    value: e,
                    label: n
                });
            });
        });
        return v;
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
    }, o = function(e) {
        return e.rangeLabels ? e.rangeLabels : [];
    }, u = function(e) {
        return e.markerLabels ? e.markerLabels : [];
    }, a = function(e) {
        return e.measureLabels ? e.measureLabels : [];
    }, f = [ 0 ], l = 380, c = 30, h = null, p = nv.utils.getColor([ "#1f77b4" ]), d = d3.dispatch("elementMouseover", "elementMouseout");
    v.dispatch = d;
    v.options = nv.utils.optionsFunc.bind(v);
    v.orient = function(e) {
        if (!arguments.length) return t;
        t = e;
        n = t == "right" || t == "bottom";
        return v;
    };
    v.ranges = function(e) {
        if (!arguments.length) return r;
        r = e;
        return v;
    };
    v.markers = function(e) {
        if (!arguments.length) return i;
        i = e;
        return v;
    };
    v.measures = function(e) {
        if (!arguments.length) return s;
        s = e;
        return v;
    };
    v.forceX = function(e) {
        if (!arguments.length) return f;
        f = e;
        return v;
    };
    v.width = function(e) {
        if (!arguments.length) return l;
        l = e;
        return v;
    };
    v.height = function(e) {
        if (!arguments.length) return c;
        c = e;
        return v;
    };
    v.margin = function(t) {
        if (!arguments.length) return e;
        e.top = typeof t.top != "undefined" ? t.top : e.top;
        e.right = typeof t.right != "undefined" ? t.right : e.right;
        e.bottom = typeof t.bottom != "undefined" ? t.bottom : e.bottom;
        e.left = typeof t.left != "undefined" ? t.left : e.left;
        return v;
    };
    v.tickFormat = function(e) {
        if (!arguments.length) return h;
        h = e;
        return v;
    };
    v.color = function(e) {
        if (!arguments.length) return p;
        p = nv.utils.getColor(e);
        return v;
    };
    return v;
};
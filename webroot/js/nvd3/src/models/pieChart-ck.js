nv.models.pieChart = function() {
    "use strict";
    function d(o) {
        o.each(function(o) {
            var u = d3.select(this), a = this, p = (r || parseInt(u.style("width")) || 960) - n.left - n.right, v = (i || parseInt(u.style("height")) || 400) - n.top - n.bottom;
            d.update = function() {
                u.transition().call(d);
            };
            d.container = this;
            f.disabled = o.map(function(e) {
                return !!e.disabled;
            });
            if (!l) {
                var m;
                l = {};
                for (m in f) f[m] instanceof Array ? l[m] = f[m].slice(0) : l[m] = f[m];
            }
            if (!o || !o.length) {
                var g = u.selectAll(".nv-noData").data([ c ]);
                g.enter().append("text").attr("class", "nvd3 nv-noData").attr("dy", "-.7em").style("text-anchor", "middle");
                g.attr("x", n.left + p / 2).attr("y", n.top + v / 2).text(function(e) {
                    return e;
                });
                return d;
            }
            u.selectAll(".nv-noData").remove();
            var y = u.selectAll("g.nv-wrap.nv-pieChart").data([ o ]), b = y.enter().append("g").attr("class", "nvd3 nv-wrap nv-pieChart").append("g"), w = y.select("g");
            b.append("g").attr("class", "nv-pieWrap");
            b.append("g").attr("class", "nv-legendWrap");
            if (s) {
                t.width(p).key(e.x());
                y.select(".nv-legendWrap").datum(o).call(t);
                if (n.top != t.height()) {
                    n.top = t.height();
                    v = (i || parseInt(u.style("height")) || 400) - n.top - n.bottom;
                }
                y.select(".nv-legendWrap").attr("transform", "translate(0," + -n.top + ")");
            }
            y.attr("transform", "translate(" + n.left + "," + n.top + ")");
            e.width(p).height(v);
            var E = w.select(".nv-pieWrap").datum([ o ]);
            d3.transition(E).call(e);
            t.dispatch.on("stateChange", function(e) {
                f = e;
                h.stateChange(f);
                d.update();
            });
            e.dispatch.on("elementMouseout.tooltip", function(e) {
                h.tooltipHide(e);
            });
            h.on("changeState", function(e) {
                if (typeof e.disabled != "undefined") {
                    o.forEach(function(t, n) {
                        t.disabled = e.disabled[n];
                    });
                    f.disabled = e.disabled;
                }
                d.update();
            });
        });
        return d;
    }
    var e = nv.models.pie(), t = nv.models.legend(), n = {
        top: 30,
        right: 20,
        bottom: 20,
        left: 20
    }, r = null, i = null, s = !0, o = nv.utils.defaultColor(), u = !0, a = function(e, t, n, r) {
        return "<h3>" + e + "</h3>" + "<p>" + t + "</p>";
    }, f = {}, l = null, c = "No Data Available.", h = d3.dispatch("tooltipShow", "tooltipHide", "stateChange", "changeState"), p = function(t, n) {
        var r = e.description()(t.point) || e.x()(t.point), i = t.pos[0] + (n && n.offsetLeft || 0), s = t.pos[1] + (n && n.offsetTop || 0), o = e.valueFormat()(e.y()(t.point)), u = a(r, o, t, d);
        nv.tooltip.show([ i, s ], u, t.value < 0 ? "n" : "s", null, n);
    };
    e.dispatch.on("elementMouseover.tooltip", function(e) {
        e.pos = [ e.pos[0] + n.left, e.pos[1] + n.top ];
        h.tooltipShow(e);
    });
    h.on("tooltipShow", function(e) {
        u && p(e);
    });
    h.on("tooltipHide", function() {
        u && nv.tooltip.cleanup();
    });
    d.legend = t;
    d.dispatch = h;
    d.pie = e;
    d3.rebind(d, e, "valueFormat", "values", "x", "y", "description", "id", "showLabels", "donutLabelsOutside", "pieLabelsOutside", "labelType", "donut", "donutRatio", "labelThreshold");
    d.options = nv.utils.optionsFunc.bind(d);
    d.margin = function(e) {
        if (!arguments.length) return n;
        n.top = typeof e.top != "undefined" ? e.top : n.top;
        n.right = typeof e.right != "undefined" ? e.right : n.right;
        n.bottom = typeof e.bottom != "undefined" ? e.bottom : n.bottom;
        n.left = typeof e.left != "undefined" ? e.left : n.left;
        return d;
    };
    d.width = function(e) {
        if (!arguments.length) return r;
        r = e;
        return d;
    };
    d.height = function(e) {
        if (!arguments.length) return i;
        i = e;
        return d;
    };
    d.color = function(n) {
        if (!arguments.length) return o;
        o = nv.utils.getColor(n);
        t.color(o);
        e.color(o);
        return d;
    };
    d.showLegend = function(e) {
        if (!arguments.length) return s;
        s = e;
        return d;
    };
    d.tooltips = function(e) {
        if (!arguments.length) return u;
        u = e;
        return d;
    };
    d.tooltipContent = function(e) {
        if (!arguments.length) return a;
        a = e;
        return d;
    };
    d.state = function(e) {
        if (!arguments.length) return f;
        f = e;
        return d;
    };
    d.defaultState = function(e) {
        if (!arguments.length) return l;
        l = e;
        return d;
    };
    d.noData = function(e) {
        if (!arguments.length) return c;
        c = e;
        return d;
    };
    return d;
};
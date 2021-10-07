nv.models.chartName = function() {
    "use strict";
    function s(r) {
        r.each(function(r) {
            var i = t - e.left - e.right, s = n - e.top - e.bottom, o = d3.select(this), u = o.selectAll("g.nv-wrap.nv-chartName").data([ r ]), a = u.enter().append("g").attr("class", "nvd3 nv-wrap nv-chartName"), f = a.append("g"), l = u.select("g");
            f.append("g").attr("class", "nv-mainWrap");
            u.attr("transform", "translate(" + e.left + "," + e.top + ")");
        });
        return s;
    }
    var e = {
        top: 30,
        right: 10,
        bottom: 10,
        left: 10
    }, t = 960, n = 500, r = nv.utils.getColor(d3.scale.category20c().range()), i = d3.dispatch("stateChange", "changeState");
    s.dispatch = i;
    s.options = nv.utils.optionsFunc.bind(s);
    s.margin = function(t) {
        if (!arguments.length) return e;
        e.top = typeof t.top != "undefined" ? t.top : e.top;
        e.right = typeof t.right != "undefined" ? t.right : e.right;
        e.bottom = typeof t.bottom != "undefined" ? t.bottom : e.bottom;
        e.left = typeof t.left != "undefined" ? t.left : e.left;
        return s;
    };
    s.width = function(e) {
        if (!arguments.length) return t;
        t = e;
        return s;
    };
    s.height = function(e) {
        if (!arguments.length) return n;
        n = e;
        return s;
    };
    s.color = function(e) {
        if (!arguments.length) return r;
        r = nv.utils.getColor(e);
        return s;
    };
    return s;
};
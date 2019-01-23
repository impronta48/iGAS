/* Utility class to handle creation of an interactive layer.
This places a rectangle on top of the chart. When you mouse move over it, it sends a dispatch
containing the X-coordinate. It can also render a vertical line where the mouse is located.

dispatch.elementMousemove is the important event to latch onto.  It is fired whenever the mouse moves over
the rectangle. The dispatch is given one object which contains the mouseX/Y location.
It also has 'pointXValue', which is the conversion of mouseX to the x-axis scale.
*/nv.interactiveGuideline = function() {
    "use strict";
    function l(s) {
        s.each(function(s) {
            function m() {
                var t = d3.mouse(this), n = t[0], s = t[1], u = !0, a = !1;
                if (f) {
                    n = d3.event.offsetX;
                    s = d3.event.offsetY;
                    d3.event.target.tagName !== "svg" && (u = !1);
                    d3.event.target.className.baseVal.match("nv-legend") && (a = !0);
                }
                if (u) {
                    n -= r.left;
                    s -= r.top;
                }
                if (n < 0 || s < 0 || n > h || s > p || d3.event.relatedTarget && d3.event.relatedTarget.ownerSVGElement === undefined || a) {
                    if (f && d3.event.relatedTarget && d3.event.relatedTarget.ownerSVGElement === undefined && d3.event.relatedTarget.className.match(e.nvPointerEventsClass)) return;
                    o.elementMouseout({
                        mouseX: n,
                        mouseY: s
                    });
                    l.renderGuideLine(null);
                    return;
                }
                var c = i.invert(n);
                o.elementMousemove({
                    mouseX: n,
                    mouseY: s,
                    pointXValue: c
                });
            }
            var c = d3.select(this), h = t || 960, p = n || 400, d = c.selectAll("g.nv-wrap.nv-interactiveLineLayer").data([ s ]), v = d.enter().append("g").attr("class", " nv-wrap nv-interactiveLineLayer");
            v.append("g").attr("class", "nv-interactiveGuideLine");
            if (!a) return;
            a.on("mousemove", m, !0).on("mouseout", m, !0);
            l.renderGuideLine = function(e) {
                if (!u) return;
                var t = d.select(".nv-interactiveGuideLine").selectAll("line").data(e != null ? [ nv.utils.NaNtoZero(e) ] : [], String);
                t.enter().append("line").attr("class", "nv-guideline").attr("x1", function(e) {
                    return e;
                }).attr("x2", function(e) {
                    return e;
                }).attr("y1", p).attr("y2", 0);
                t.exit().remove();
            };
        });
    }
    var e = nv.models.tooltip(), t = null, n = null, r = {
        left: 0,
        top: 0
    }, i = d3.scale.linear(), s = d3.scale.linear(), o = d3.dispatch("elementMousemove", "elementMouseout"), u = !0, a = null, f = navigator.userAgent.indexOf("MSIE") !== -1;
    l.dispatch = o;
    l.tooltip = e;
    l.margin = function(e) {
        if (!arguments.length) return r;
        r.top = typeof e.top != "undefined" ? e.top : r.top;
        r.left = typeof e.left != "undefined" ? e.left : r.left;
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
    l.xScale = function(e) {
        if (!arguments.length) return i;
        i = e;
        return l;
    };
    l.showGuideLine = function(e) {
        if (!arguments.length) return u;
        u = e;
        return l;
    };
    l.svgContainer = function(e) {
        if (!arguments.length) return a;
        a = e;
        return l;
    };
    return l;
};

nv.interactiveBisect = function(e, t, n) {
    "use strict";
    if (!e instanceof Array) return null;
    typeof n != "function" && (n = function(e, t) {
        return e.x;
    });
    var r = d3.bisector(n).left, i = d3.max([ 0, r(e, t) - 1 ]), s = n(e[i], i);
    typeof s == "undefined" && (s = i);
    if (s === t) return i;
    var o = d3.min([ i + 1, e.length - 1 ]), u = n(e[o], o);
    typeof u == "undefined" && (u = o);
    return Math.abs(u - t) >= Math.abs(s - t) ? i : o;
};
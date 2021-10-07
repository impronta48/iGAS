/* Tooltip rendering model for nvd3 charts.
window.nv.models.tooltip is the updated,new way to render tooltips.

window.nv.tooltip.show is the old tooltip code.
window.nv.tooltip.* also has various helper methods.
*/(function() {
    "use strict";
    window.nv.tooltip = {};
    window.nv.models.tooltip = function() {
        function m() {
            if (u) {
                var e = d3.select(u);
                e.node().tagName !== "svg" && (e = e.select("svg"));
                var t = e.node() ? e.attr("viewBox") : null;
                if (t) {
                    t = t.split(" ");
                    var n = parseInt(e.style("width")) / t[2];
                    a.left = a.left * n;
                    a.top = a.top * n;
                }
            }
        }
        function g(e) {
            var t;
            u ? t = d3.select(u) : t = d3.select("body");
            var n = t.select(".nvtooltip");
            n.node() === null && (n = t.append("div").attr("class", "nvtooltip " + (o ? o : "xy-tooltip")).attr("id", l));
            n.node().innerHTML = e;
            n.style("top", 0).style("left", 0).style("opacity", 0);
            n.selectAll("div, table, td, tr").classed(c, !0);
            n.classed(c, !0);
            return n.node();
        }
        function y() {
            if (!f) return;
            if (!v(t)) return;
            m();
            var e = a.left, o = s != null ? s : a.top, l = g(d(t));
            if (u) {
                var c = u.getElementsByTagName("svg")[0], h = c ? c.getBoundingClientRect() : u.getBoundingClientRect(), p = {
                    left: 0,
                    top: 0
                };
                if (c) {
                    var b = c.getBoundingClientRect(), w = u.getBoundingClientRect();
                    p.top = Math.abs(b.top - w.top);
                    p.left = Math.abs(b.left - w.left);
                }
                e += u.offsetLeft + p.left - 2 * u.scrollLeft;
                o += u.offsetTop + p.top - 2 * u.scrollTop;
            }
            i && i > 0 && (o = Math.floor(o / i) * i);
            nv.tooltip.calcTooltipPosition([ e, o ], n, r, l);
            return y;
        }
        var e = null, t = null, n = "w", r = 50, i = 25, s = null, o = null, u = null, a = {
            left: null,
            top: null
        }, f = !0, l = "nvtooltip-" + Math.floor(Math.random() * 1e5), c = "nv-pointer-events-none", h = function(e, t) {
            return e;
        }, p = function(e) {
            return e;
        }, d = function(t) {
            if (e != null) return e;
            if (t == null) return "";
            var n = "<table><thead><tr><td colspan='3'><strong class='x-value'>" + p(t.value) + "</strong></td></tr></thead><tbody>";
            t.series instanceof Array && t.series.forEach(function(e, t) {
                n += "<tr>";
                n += "<td class='legend-color-guide'><div style='background-color: " + e.color + ";'></div></td>";
                n += "<td class='key'>" + e.key + ":</td>";
                n += "<td class='value'>" + h(e.value, t) + "</td></tr>";
            });
            n += "</tbody></table>";
            return n;
        }, v = function(e) {
            return e && e.series && e.series.length > 0 ? !0 : !1;
        };
        y.nvPointerEventsClass = c;
        y.content = function(t) {
            if (!arguments.length) return e;
            e = t;
            return y;
        };
        y.contentGenerator = function(e) {
            if (!arguments.length) return d;
            typeof e == "function" && (d = e);
            return y;
        };
        y.data = function(e) {
            if (!arguments.length) return t;
            t = e;
            return y;
        };
        y.gravity = function(e) {
            if (!arguments.length) return n;
            n = e;
            return y;
        };
        y.distance = function(e) {
            if (!arguments.length) return r;
            r = e;
            return y;
        };
        y.snapDistance = function(e) {
            if (!arguments.length) return i;
            i = e;
            return y;
        };
        y.classes = function(e) {
            if (!arguments.length) return o;
            o = e;
            return y;
        };
        y.chartContainer = function(e) {
            if (!arguments.length) return u;
            u = e;
            return y;
        };
        y.position = function(e) {
            if (!arguments.length) return a;
            a.left = typeof e.left != "undefined" ? e.left : a.left;
            a.top = typeof e.top != "undefined" ? e.top : a.top;
            return y;
        };
        y.fixedTop = function(e) {
            if (!arguments.length) return s;
            s = e;
            return y;
        };
        y.enabled = function(e) {
            if (!arguments.length) return f;
            f = e;
            return y;
        };
        y.valueFormatter = function(e) {
            if (!arguments.length) return h;
            typeof e == "function" && (h = e);
            return y;
        };
        y.headerFormatter = function(e) {
            if (!arguments.length) return p;
            typeof e == "function" && (p = e);
            return y;
        };
        y.id = function() {
            return l;
        };
        return y;
    };
    nv.tooltip.show = function(e, t, n, r, i, s) {
        var o = document.createElement("div");
        o.className = "nvtooltip " + (s ? s : "xy-tooltip");
        var u = i;
        if (!i || i.tagName.match(/g|svg/i)) u = document.getElementsByTagName("body")[0];
        o.style.left = 0;
        o.style.top = 0;
        o.style.opacity = 0;
        o.innerHTML = t;
        u.appendChild(o);
        if (i) {
            e[0] = e[0] - i.scrollLeft;
            e[1] = e[1] - i.scrollTop;
        }
        nv.tooltip.calcTooltipPosition(e, n, r, o);
    };
    nv.tooltip.findFirstNonSVGParent = function(e) {
        while (e.tagName.match(/^g|svg$/i) !== null) e = e.parentNode;
        return e;
    };
    nv.tooltip.findTotalOffsetTop = function(e, t) {
        var n = t;
        do isNaN(e.offsetTop) || (n += e.offsetTop); while (e = e.offsetParent);
        return n;
    };
    nv.tooltip.findTotalOffsetLeft = function(e, t) {
        var n = t;
        do isNaN(e.offsetLeft) || (n += e.offsetLeft); while (e = e.offsetParent);
        return n;
    };
    nv.tooltip.calcTooltipPosition = function(e, t, n, r) {
        var i = parseInt(r.offsetHeight), s = parseInt(r.offsetWidth), o = nv.utils.windowSize().width, u = nv.utils.windowSize().height, a = window.pageYOffset, f = window.pageXOffset, l, c;
        u = window.innerWidth >= document.body.scrollWidth ? u : u - 16;
        o = window.innerHeight >= document.body.scrollHeight ? o : o - 16;
        t = t || "s";
        n = n || 20;
        var h = function(e) {
            return nv.tooltip.findTotalOffsetTop(e, c);
        }, p = function(e) {
            return nv.tooltip.findTotalOffsetLeft(e, l);
        };
        switch (t) {
          case "e":
            l = e[0] - s - n;
            c = e[1] - i / 2;
            var d = p(r), v = h(r);
            d < f && (l = e[0] + n > f ? e[0] + n : f - d + l);
            v < a && (c = a - v + c);
            v + i > a + u && (c = a + u - v + c - i);
            break;
          case "w":
            l = e[0] + n;
            c = e[1] - i / 2;
            var d = p(r), v = h(r);
            d + s > o && (l = e[0] - s - n);
            v < a && (c = a + 5);
            v + i > a + u && (c = a + u - v + c - i);
            break;
          case "n":
            l = e[0] - s / 2 - 5;
            c = e[1] + n;
            var d = p(r), v = h(r);
            d < f && (l = f + 5);
            d + s > o && (l = l - s / 2 + 5);
            v + i > a + u && (c = a + u - v + c - i);
            break;
          case "s":
            l = e[0] - s / 2;
            c = e[1] - i - n;
            var d = p(r), v = h(r);
            d < f && (l = f + 5);
            d + s > o && (l = l - s / 2 + 5);
            a > v && (c = a);
            break;
          case "none":
            l = e[0];
            c = e[1] - n;
            var d = p(r), v = h(r);
        }
        r.style.left = l + "px";
        r.style.top = c + "px";
        r.style.opacity = 1;
        r.style.position = "absolute";
        return r;
    };
    nv.tooltip.cleanup = function() {
        var e = document.getElementsByClassName("nvtooltip"), t = [];
        while (e.length) {
            t.push(e[0]);
            e[0].style.transitionDelay = "0 !important";
            e[0].style.opacity = 0;
            e[0].className = "nvtooltip-pending-removal";
        }
        setTimeout(function() {
            while (t.length) {
                var e = t.pop();
                e.parentNode.removeChild(e);
            }
        }, 500);
    };
})();
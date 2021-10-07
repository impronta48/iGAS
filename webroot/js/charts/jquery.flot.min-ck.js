/* Javascript plotting library for jQuery, version 0.8.1.

Copyright (c) 2007-2013 IOLA and Ole Laursen.
Licensed under the MIT license.

*/// first an inline dependency, jquery.colorhelpers.js, we inline it here
// for convenience
/* Plugin for jQuery for working with colors.
 *
 * Version 1.1.
 *
 * Inspiration from jQuery color animation plugin by John Resig.
 *
 * Released under the MIT license by Ole Laursen, October 2009.
 *
 * Examples:
 *
 *   $.color.parse("#fff").scale('rgb', 0.25).add('a', -0.5).toString()
 *   var c = $.color.extract($("#mydiv"), 'background-color');
 *   console.log(c.r, c.g, c.b, c.a);
 *   $.color.make(100, 50, 25, 0.4).toString() // returns "rgba(100,50,25,0.4)"
 *
 * Note that .scale() and .add() return the same modified object
 * instead of making a new one.
 *
 * V. 1.1: Fix error handling so e.g. parsing an empty string does
 * produce a color rather than just crashing.
 */(function(e) {
    e.color = {}, e.color.make = function(t, n, r, i) {
        var s = {};
        return s.r = t || 0, s.g = n || 0, s.b = r || 0, s.a = i != null ? i : 1, s.add = function(e, t) {
            for (var n = 0; n < e.length; ++n) s[e.charAt(n)] += t;
            return s.normalize();
        }, s.scale = function(e, t) {
            for (var n = 0; n < e.length; ++n) s[e.charAt(n)] *= t;
            return s.normalize();
        }, s.toString = function() {
            return s.a >= 1 ? "rgb(" + [ s.r, s.g, s.b ].join(",") + ")" : "rgba(" + [ s.r, s.g, s.b, s.a ].join(",") + ")";
        }, s.normalize = function() {
            function e(e, t, n) {
                return t < e ? e : t > n ? n : t;
            }
            return s.r = e(0, parseInt(s.r), 255), s.g = e(0, parseInt(s.g), 255), s.b = e(0, parseInt(s.b), 255), s.a = e(0, s.a, 1), s;
        }, s.clone = function() {
            return e.color.make(s.r, s.b, s.g, s.a);
        }, s.normalize();
    }, e.color.extract = function(t, n) {
        var r;
        do {
            r = t.css(n).toLowerCase();
            if (r != "" && r != "transparent") break;
            t = t.parent();
        } while (!e.nodeName(t.get(0), "body"));
        return r == "rgba(0, 0, 0, 0)" && (r = "transparent"), e.color.parse(r);
    }, e.color.parse = function(n) {
        var r, i = e.color.make;
        if (r = /rgb\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*\)/.exec(n)) return i(parseInt(r[1], 10), parseInt(r[2], 10), parseInt(r[3], 10));
        if (r = /rgba\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]+(?:\.[0-9]+)?)\s*\)/.exec(n)) return i(parseInt(r[1], 10), parseInt(r[2], 10), parseInt(r[3], 10), parseFloat(r[4]));
        if (r = /rgb\(\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*\)/.exec(n)) return i(parseFloat(r[1]) * 2.55, parseFloat(r[2]) * 2.55, parseFloat(r[3]) * 2.55);
        if (r = /rgba\(\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\s*\)/.exec(n)) return i(parseFloat(r[1]) * 2.55, parseFloat(r[2]) * 2.55, parseFloat(r[3]) * 2.55, parseFloat(r[4]));
        if (r = /#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/.exec(n)) return i(parseInt(r[1], 16), parseInt(r[2], 16), parseInt(r[3], 16));
        if (r = /#([a-fA-F0-9])([a-fA-F0-9])([a-fA-F0-9])/.exec(n)) return i(parseInt(r[1] + r[1], 16), parseInt(r[2] + r[2], 16), parseInt(r[3] + r[3], 16));
        var s = e.trim(n).toLowerCase();
        return s == "transparent" ? i(255, 255, 255, 0) : (r = t[s] || [ 0, 0, 0 ], i(r[0], r[1], r[2]));
    };
    var t = {
        aqua: [ 0, 255, 255 ],
        azure: [ 240, 255, 255 ],
        beige: [ 245, 245, 220 ],
        black: [ 0, 0, 0 ],
        blue: [ 0, 0, 255 ],
        brown: [ 165, 42, 42 ],
        cyan: [ 0, 255, 255 ],
        darkblue: [ 0, 0, 139 ],
        darkcyan: [ 0, 139, 139 ],
        darkgrey: [ 169, 169, 169 ],
        darkgreen: [ 0, 100, 0 ],
        darkkhaki: [ 189, 183, 107 ],
        darkmagenta: [ 139, 0, 139 ],
        darkolivegreen: [ 85, 107, 47 ],
        darkorange: [ 255, 140, 0 ],
        darkorchid: [ 153, 50, 204 ],
        darkred: [ 139, 0, 0 ],
        darksalmon: [ 233, 150, 122 ],
        darkviolet: [ 148, 0, 211 ],
        fuchsia: [ 255, 0, 255 ],
        gold: [ 255, 215, 0 ],
        green: [ 0, 128, 0 ],
        indigo: [ 75, 0, 130 ],
        khaki: [ 240, 230, 140 ],
        lightblue: [ 173, 216, 230 ],
        lightcyan: [ 224, 255, 255 ],
        lightgreen: [ 144, 238, 144 ],
        lightgrey: [ 211, 211, 211 ],
        lightpink: [ 255, 182, 193 ],
        lightyellow: [ 255, 255, 224 ],
        lime: [ 0, 255, 0 ],
        magenta: [ 255, 0, 255 ],
        maroon: [ 128, 0, 0 ],
        navy: [ 0, 0, 128 ],
        olive: [ 128, 128, 0 ],
        orange: [ 255, 165, 0 ],
        pink: [ 255, 192, 203 ],
        purple: [ 128, 0, 128 ],
        violet: [ 128, 0, 128 ],
        red: [ 255, 0, 0 ],
        silver: [ 192, 192, 192 ],
        white: [ 255, 255, 255 ],
        yellow: [ 255, 255, 0 ]
    };
})(jQuery), function(e) {
    function t(t, n) {
        var r = n.children("." + t)[0];
        if (r == null) {
            r = document.createElement("canvas"), r.className = t, e(r).css({
                direction: "ltr",
                position: "absolute",
                left: 0,
                top: 0
            }).appendTo(n);
            if (!r.getContext) {
                if (!window.G_vmlCanvasManager) throw new Error("Canvas is not available. If you're using IE with a fall-back such as Excanvas, then there's either a mistake in your conditional include, or the page has no DOCTYPE and is rendering in Quirks Mode.");
                r = window.G_vmlCanvasManager.initElement(r);
            }
        }
        this.element = r;
        var i = this.context = r.getContext("2d"), s = window.devicePixelRatio || 1, o = i.webkitBackingStorePixelRatio || i.mozBackingStorePixelRatio || i.msBackingStorePixelRatio || i.oBackingStorePixelRatio || i.backingStorePixelRatio || 1;
        this.pixelRatio = s / o, this.resize(n.width(), n.height()), this.textContainer = null, this.text = {}, this._textCache = {};
    }
    function n(n, i, s, o) {
        function u(e, t) {
            t = [ mt ].concat(t);
            for (var n = 0; n < e.length; ++n) e[n].apply(this, t);
        }
        function a() {
            var n = {
                Canvas: t
            };
            for (var r = 0; r < o.length; ++r) {
                var i = o[r];
                i.init(mt, n), i.options && e.extend(!0, it, i.options);
            }
        }
        function f(t) {
            e.extend(!0, it, t), t && t.colors && (it.colors = t.colors), it.xaxis.color == null && (it.xaxis.color = e.color.parse(it.grid.color).scale("a", .22).toString()), it.yaxis.color == null && (it.yaxis.color = e.color.parse(it.grid.color).scale("a", .22).toString()), it.xaxis.tickColor == null && (it.xaxis.tickColor = it.grid.tickColor || it.xaxis.color), it.yaxis.tickColor == null && (it.yaxis.tickColor = it.grid.tickColor || it.yaxis.color), it.grid.borderColor == null && (it.grid.borderColor = it.grid.color), it.grid.tickColor == null && (it.grid.tickColor = e.color.parse(it.grid.color).scale("a", .22).toString());
            var r, i, s, o = {
                style: n.css("font-style"),
                size: Math.round(.8 * (+n.css("font-size").replace("px", "") || 13)),
                variant: n.css("font-variant"),
                weight: n.css("font-weight"),
                family: n.css("font-family")
            };
            o.lineHeight = o.size * 1.15, s = it.xaxes.length || 1;
            for (r = 0; r < s; ++r) i = it.xaxes[r], i && !i.tickColor && (i.tickColor = i.color), i = e.extend(!0, {}, it.xaxis, i), it.xaxes[r] = i, i.font && (i.font = e.extend({}, o, i.font), i.font.color || (i.font.color = i.color));
            s = it.yaxes.length || 1;
            for (r = 0; r < s; ++r) i = it.yaxes[r], i && !i.tickColor && (i.tickColor = i.color), i = e.extend(!0, {}, it.yaxis, i), it.yaxes[r] = i, i.font && (i.font = e.extend({}, o, i.font), i.font.color || (i.font.color = i.color));
            it.xaxis.noTicks && it.xaxis.ticks == null && (it.xaxis.ticks = it.xaxis.noTicks), it.yaxis.noTicks && it.yaxis.ticks == null && (it.yaxis.ticks = it.yaxis.noTicks), it.x2axis && (it.xaxes[1] = e.extend(!0, {}, it.xaxis, it.x2axis), it.xaxes[1].position = "top"), it.y2axis && (it.yaxes[1] = e.extend(!0, {}, it.yaxis, it.y2axis), it.yaxes[1].position = "right"), it.grid.coloredAreas && (it.grid.markings = it.grid.coloredAreas), it.grid.coloredAreasColor && (it.grid.markingsColor = it.grid.coloredAreasColor), it.lines && e.extend(!0, it.series.lines, it.lines), it.points && e.extend(!0, it.series.points, it.points), it.bars && e.extend(!0, it.series.bars, it.bars), it.shadowSize != null && (it.series.shadowSize = it.shadowSize), it.highlightColor != null && (it.series.highlightColor = it.highlightColor);
            for (r = 0; r < it.xaxes.length; ++r) m(lt, r + 1).options = it.xaxes[r];
            for (r = 0; r < it.yaxes.length; ++r) m(ct, r + 1).options = it.yaxes[r];
            for (var a in vt) it.hooks[a] && it.hooks[a].length && (vt[a] = vt[a].concat(it.hooks[a]));
            u(vt.processOptions, [ it ]);
        }
        function l(e) {
            rt = c(e), g(), y();
        }
        function c(t) {
            var n = [];
            for (var r = 0; r < t.length; ++r) {
                var i = e.extend(!0, {}, it.series);
                t[r].data != null ? (i.data = t[r].data, delete t[r].data, e.extend(!0, i, t[r]), t[r].data = i.data) : i.data = t[r], n.push(i);
            }
            return n;
        }
        function h(e, t) {
            var n = e[t + "axis"];
            return typeof n == "object" && (n = n.n), typeof n != "number" && (n = 1), n;
        }
        function p() {
            return e.grep(lt.concat(ct), function(e) {
                return e;
            });
        }
        function d(e) {
            var t = {}, n, r;
            for (n = 0; n < lt.length; ++n) r = lt[n], r && r.used && (t["x" + r.n] = r.c2p(e.left));
            for (n = 0; n < ct.length; ++n) r = ct[n], r && r.used && (t["y" + r.n] = r.c2p(e.top));
            return t.x1 !== undefined && (t.x = t.x1), t.y1 !== undefined && (t.y = t.y1), t;
        }
        function v(e) {
            var t = {}, n, r, i;
            for (n = 0; n < lt.length; ++n) {
                r = lt[n];
                if (r && r.used) {
                    i = "x" + r.n, e[i] == null && r.n == 1 && (i = "x");
                    if (e[i] != null) {
                        t.left = r.p2c(e[i]);
                        break;
                    }
                }
            }
            for (n = 0; n < ct.length; ++n) {
                r = ct[n];
                if (r && r.used) {
                    i = "y" + r.n, e[i] == null && r.n == 1 && (i = "y");
                    if (e[i] != null) {
                        t.top = r.p2c(e[i]);
                        break;
                    }
                }
            }
            return t;
        }
        function m(t, n) {
            return t[n - 1] || (t[n - 1] = {
                n: n,
                direction: t == lt ? "x" : "y",
                options: e.extend(!0, {}, t == lt ? it.xaxis : it.yaxis)
            }), t[n - 1];
        }
        function g() {
            var t = rt.length, n = -1, r;
            for (r = 0; r < rt.length; ++r) {
                var i = rt[r].color;
                i != null && (t--, typeof i == "number" && i > n && (n = i));
            }
            t <= n && (t = n + 1);
            var s, o = [], u = it.colors, a = u.length, f = 0;
            for (r = 0; r < t; r++) s = e.color.parse(u[r % a] || "#666"), r % a == 0 && r && (f >= 0 ? f < .5 ? f = -f - .2 : f = 0 : f = -f), o[r] = s.scale("rgb", 1 + f);
            var l = 0, c;
            for (r = 0; r < rt.length; ++r) {
                c = rt[r], c.color == null ? (c.color = o[l].toString(), ++l) : typeof c.color == "number" && (c.color = o[c.color].toString());
                if (c.lines.show == null) {
                    var p, d = !0;
                    for (p in c) if (c[p] && c[p].show) {
                        d = !1;
                        break;
                    }
                    d && (c.lines.show = !0);
                }
                c.lines.zero == null && (c.lines.zero = !!c.lines.fill), c.xaxis = m(lt, h(c, "x")), c.yaxis = m(ct, h(c, "y"));
            }
        }
        function y() {
            function t(e, t, n) {
                t < e.datamin && t != -i && (e.datamin = t), n > e.datamax && n != i && (e.datamax = n);
            }
            var n = Number.POSITIVE_INFINITY, r = Number.NEGATIVE_INFINITY, i = Number.MAX_VALUE, s, o, a, f, l, c, h, d, v, m, g, y, b, w, E, S;
            e.each(p(), function(e, t) {
                t.datamin = n, t.datamax = r, t.used = !1;
            });
            for (s = 0; s < rt.length; ++s) c = rt[s], c.datapoints = {
                points: []
            }, u(vt.processRawData, [ c, c.data, c.datapoints ]);
            for (s = 0; s < rt.length; ++s) {
                c = rt[s], E = c.data, S = c.datapoints.format;
                if (!S) {
                    S = [], S.push({
                        x: !0,
                        number: !0,
                        required: !0
                    }), S.push({
                        y: !0,
                        number: !0,
                        required: !0
                    });
                    if (c.bars.show || c.lines.show && c.lines.fill) {
                        var x = !!(c.bars.show && c.bars.zero || c.lines.show && c.lines.zero);
                        S.push({
                            y: !0,
                            number: !0,
                            required: !1,
                            defaultValue: 0,
                            autoscale: x
                        }), c.bars.horizontal && (delete S[S.length - 1].y, S[S.length - 1].x = !0);
                    }
                    c.datapoints.format = S;
                }
                if (c.datapoints.pointsize != null) continue;
                c.datapoints.pointsize = S.length, d = c.datapoints.pointsize, h = c.datapoints.points;
                var T = c.lines.show && c.lines.steps;
                c.xaxis.used = c.yaxis.used = !0;
                for (o = a = 0; o < E.length; ++o, a += d) {
                    w = E[o];
                    var N = w == null;
                    if (!N) for (f = 0; f < d; ++f) y = w[f], b = S[f], b && (b.number && y != null && (y = +y, isNaN(y) ? y = null : y == Infinity ? y = i : y == -Infinity && (y = -i)), y == null && (b.required && (N = !0), b.defaultValue != null && (y = b.defaultValue))), h[a + f] = y;
                    if (N) for (f = 0; f < d; ++f) y = h[a + f], y != null && (b = S[f], b.autoscale && (b.x && t(c.xaxis, y, y), b.y && t(c.yaxis, y, y))), h[a + f] = null; else if (T && a > 0 && h[a - d] != null && h[a - d] != h[a] && h[a - d + 1] != h[a + 1]) {
                        for (f = 0; f < d; ++f) h[a + d + f] = h[a + f];
                        h[a + 1] = h[a - d + 1], a += d;
                    }
                }
            }
            for (s = 0; s < rt.length; ++s) c = rt[s], u(vt.processDatapoints, [ c, c.datapoints ]);
            for (s = 0; s < rt.length; ++s) {
                c = rt[s], h = c.datapoints.points, d = c.datapoints.pointsize, S = c.datapoints.format;
                var C = n, k = n, L = r, A = r;
                for (o = 0; o < h.length; o += d) {
                    if (h[o] == null) continue;
                    for (f = 0; f < d; ++f) {
                        y = h[o + f], b = S[f];
                        if (!b || b.autoscale === !1 || y == i || y == -i) continue;
                        b.x && (y < C && (C = y), y > L && (L = y)), b.y && (y < k && (k = y), y > A && (A = y));
                    }
                }
                if (c.bars.show) {
                    var O;
                    switch (c.bars.align) {
                      case "left":
                        O = 0;
                        break;
                      case "right":
                        O = -c.bars.barWidth;
                        break;
                      case "center":
                        O = -c.bars.barWidth / 2;
                        break;
                      default:
                        throw new Error("Invalid bar alignment: " + c.bars.align);
                    }
                    c.bars.horizontal ? (k += O, A += O + c.bars.barWidth) : (C += O, L += O + c.bars.barWidth);
                }
                t(c.xaxis, C, L), t(c.yaxis, k, A);
            }
            e.each(p(), function(e, t) {
                t.datamin == n && (t.datamin = null), t.datamax == r && (t.datamax = null);
            });
        }
        function b() {
            n.css("padding", 0).children(":not(.flot-base,.flot-overlay)").remove(), n.css("position") == "static" && n.css("position", "relative"), st = new t("flot-base", n), ot = new t("flot-overlay", n), at = st.context, ft = ot.context, ut = e(ot.element).unbind();
            var r = n.data("plot");
            r && (r.shutdown(), ot.clear()), n.data("plot", mt);
        }
        function w() {
            it.grid.hoverable && (ut.mousemove(X), ut.bind("mouseleave", V)), it.grid.clickable && ut.click($), u(vt.bindEvents, [ ut ]);
        }
        function E() {
            yt && clearTimeout(yt), ut.unbind("mousemove", X), ut.unbind("mouseleave", V), ut.unbind("click", $), u(vt.shutdown, [ ut ]);
        }
        function S(e) {
            function t(e) {
                return e;
            }
            var n, r, i = e.options.transform || t, s = e.options.inverseTransform;
            e.direction == "x" ? (n = e.scale = pt / Math.abs(i(e.max) - i(e.min)), r = Math.min(i(e.max), i(e.min))) : (n = e.scale = dt / Math.abs(i(e.max) - i(e.min)), n = -n, r = Math.max(i(e.max), i(e.min))), i == t ? e.p2c = function(e) {
                return (e - r) * n;
            } : e.p2c = function(e) {
                return (i(e) - r) * n;
            }, s ? e.c2p = function(e) {
                return s(r + e / n);
            } : e.c2p = function(e) {
                return r + e / n;
            };
        }
        function x(e) {
            var t = e.options, n = e.ticks || [], r = t.labelWidth || 0, i = t.labelHeight || 0, s = r || e.direction == "x" ? Math.floor(st.width / (n.length || 1)) : null;
            legacyStyles = e.direction + "Axis " + e.direction + e.n + "Axis", layer = "flot-" + e.direction + "-axis flot-" + e.direction + e.n + "-axis " + legacyStyles, font = t.font || "flot-tick-label tickLabel";
            for (var o = 0; o < n.length; ++o) {
                var u = n[o];
                if (!u.label) continue;
                var a = st.getTextInfo(layer, u.label, font, null, s);
                r = Math.max(r, a.width), i = Math.max(i, a.height);
            }
            e.labelWidth = t.labelWidth || r, e.labelHeight = t.labelHeight || i;
        }
        function T(t) {
            var n = t.labelWidth, r = t.labelHeight, i = t.options.position, s = t.options.tickLength, o = it.grid.axisMargin, u = it.grid.labelMargin, a = t.direction == "x" ? lt : ct, f, l, c = e.grep(a, function(e) {
                return e && e.options.position == i && e.reserveSpace;
            });
            e.inArray(t, c) == c.length - 1 && (o = 0);
            if (s == null) {
                var h = e.grep(a, function(e) {
                    return e && e.reserveSpace;
                });
                l = e.inArray(t, h) == 0, l ? s = "full" : s = 5;
            }
            isNaN(+s) || (u += +s), t.direction == "x" ? (r += u, i == "bottom" ? (ht.bottom += r + o, t.box = {
                top: st.height - ht.bottom,
                height: r
            }) : (t.box = {
                top: ht.top + o,
                height: r
            }, ht.top += r + o)) : (n += u, i == "left" ? (t.box = {
                left: ht.left + o,
                width: n
            }, ht.left += n + o) : (ht.right += n + o, t.box = {
                left: st.width - ht.right,
                width: n
            })), t.position = i, t.tickLength = s, t.box.padding = u, t.innermost = l;
        }
        function N(e) {
            e.direction == "x" ? (e.box.left = ht.left - e.labelWidth / 2, e.box.width = st.width - ht.left - ht.right + e.labelWidth) : (e.box.top = ht.top - e.labelHeight / 2, e.box.height = st.height - ht.bottom - ht.top + e.labelHeight);
        }
        function C() {
            var t = it.grid.minBorderMargin, n = {
                x: 0,
                y: 0
            }, r, i;
            if (t == null) {
                t = 0;
                for (r = 0; r < rt.length; ++r) t = Math.max(t, 2 * (rt[r].points.radius + rt[r].points.lineWidth / 2));
            }
            n.x = n.y = Math.ceil(t), e.each(p(), function(e, t) {
                var r = t.direction;
                t.reserveSpace && (n[r] = Math.ceil(Math.max(n[r], (r == "x" ? t.labelWidth : t.labelHeight) / 2)));
            }), ht.left = Math.max(n.x, ht.left), ht.right = Math.max(n.x, ht.right), ht.top = Math.max(n.y, ht.top), ht.bottom = Math.max(n.y, ht.bottom);
        }
        function k() {
            var t, n = p(), r = it.grid.show;
            for (var i in ht) {
                var s = it.grid.margin || 0;
                ht[i] = typeof s == "number" ? s : s[i] || 0;
            }
            u(vt.processOffset, [ ht ]);
            for (var i in ht) typeof it.grid.borderWidth == "object" ? ht[i] += r ? it.grid.borderWidth[i] : 0 : ht[i] += r ? it.grid.borderWidth : 0;
            e.each(n, function(e, t) {
                t.show = t.options.show, t.show == null && (t.show = t.used), t.reserveSpace = t.show || t.options.reserveSpace, L(t);
            });
            if (r) {
                var o = e.grep(n, function(e) {
                    return e.reserveSpace;
                });
                e.each(o, function(e, t) {
                    A(t), O(t), M(t, t.ticks), x(t);
                });
                for (t = o.length - 1; t >= 0; --t) T(o[t]);
                C(), e.each(o, function(e, t) {
                    N(t);
                });
            }
            pt = st.width - ht.left - ht.right, dt = st.height - ht.bottom - ht.top, e.each(n, function(e, t) {
                S(t);
            }), r && B(), z();
        }
        function L(e) {
            var t = e.options, n = +(t.min != null ? t.min : e.datamin), r = +(t.max != null ? t.max : e.datamax), i = r - n;
            if (i == 0) {
                var s = r == 0 ? 1 : .01;
                t.min == null && (n -= s);
                if (t.max == null || t.min != null) r += s;
            } else {
                var o = t.autoscaleMargin;
                o != null && (t.min == null && (n -= i * o, n < 0 && e.datamin != null && e.datamin >= 0 && (n = 0)), t.max == null && (r += i * o, r > 0 && e.datamax != null && e.datamax <= 0 && (r = 0)));
            }
            e.min = n, e.max = r;
        }
        function A(t) {
            var n = t.options, i;
            typeof n.ticks == "number" && n.ticks > 0 ? i = n.ticks : i = .3 * Math.sqrt(t.direction == "x" ? st.width : st.height);
            var s = (t.max - t.min) / i, o = -Math.floor(Math.log(s) / Math.LN10), u = n.tickDecimals;
            u != null && o > u && (o = u);
            var a = Math.pow(10, -o), f = s / a, l;
            f < 1.5 ? l = 1 : f < 3 ? (l = 2, f > 2.25 && (u == null || o + 1 <= u) && (l = 2.5, ++o)) : f < 7.5 ? l = 5 : l = 10, l *= a, n.minTickSize != null && l < n.minTickSize && (l = n.minTickSize), t.delta = s, t.tickDecimals = Math.max(0, u != null ? u : o), t.tickSize = n.tickSize || l;
            if (n.mode == "time" && !t.tickGenerator) throw new Error("Time mode requires the flot.time plugin.");
            t.tickGenerator || (t.tickGenerator = function(e) {
                var t = [], n = r(e.min, e.tickSize), i = 0, s = Number.NaN, o;
                do o = s, s = n + i * e.tickSize, t.push(s), ++i; while (s < e.max && s != o);
                return t;
            }, t.tickFormatter = function(e, t) {
                var n = t.tickDecimals ? Math.pow(10, t.tickDecimals) : 1, r = "" + Math.round(e * n) / n;
                if (t.tickDecimals != null) {
                    var i = r.indexOf("."), s = i == -1 ? 0 : r.length - i - 1;
                    if (s < t.tickDecimals) return (s ? r : r + ".") + ("" + n).substr(1, t.tickDecimals - s);
                }
                return r;
            }), e.isFunction(n.tickFormatter) && (t.tickFormatter = function(e, t) {
                return "" + n.tickFormatter(e, t);
            });
            if (n.alignTicksWithAxis != null) {
                var c = (t.direction == "x" ? lt : ct)[n.alignTicksWithAxis - 1];
                if (c && c.used && c != t) {
                    var h = t.tickGenerator(t);
                    h.length > 0 && (n.min == null && (t.min = Math.min(t.min, h[0])), n.max == null && h.length > 1 && (t.max = Math.max(t.max, h[h.length - 1]))), t.tickGenerator = function(e) {
                        var t = [], n, r;
                        for (r = 0; r < c.ticks.length; ++r) n = (c.ticks[r].v - c.min) / (c.max - c.min), n = e.min + n * (e.max - e.min), t.push(n);
                        return t;
                    };
                    if (!t.mode && n.tickDecimals == null) {
                        var p = Math.max(0, -Math.floor(Math.log(t.delta) / Math.LN10) + 1), d = t.tickGenerator(t);
                        d.length > 1 && /\..*0$/.test((d[1] - d[0]).toFixed(p)) || (t.tickDecimals = p);
                    }
                }
            }
        }
        function O(t) {
            var n = t.options.ticks, r = [];
            n == null || typeof n == "number" && n > 0 ? r = t.tickGenerator(t) : n && (e.isFunction(n) ? r = n(t) : r = n);
            var i, s;
            t.ticks = [];
            for (i = 0; i < r.length; ++i) {
                var o = null, u = r[i];
                typeof u == "object" ? (s = +u[0], u.length > 1 && (o = u[1])) : s = +u, o == null && (o = t.tickFormatter(s, t)), isNaN(s) || t.ticks.push({
                    v: s,
                    label: o
                });
            }
        }
        function M(e, t) {
            e.options.autoscaleMargin && t.length > 0 && (e.options.min == null && (e.min = Math.min(e.min, t[0].v)), e.options.max == null && t.length > 1 && (e.max = Math.max(e.max, t[t.length - 1].v)));
        }
        function _() {
            st.clear(), u(vt.drawBackground, [ at ]);
            var e = it.grid;
            e.show && e.backgroundColor && P(), e.show && !e.aboveData && H();
            for (var t = 0; t < rt.length; ++t) u(vt.drawSeries, [ at, rt[t] ]), j(rt[t]);
            u(vt.draw, [ at ]), e.show && e.aboveData && H(), st.render(), K();
        }
        function D(e, t) {
            var n, r, i, s, o = p();
            for (var u = 0; u < o.length; ++u) {
                n = o[u];
                if (n.direction == t) {
                    s = t + n.n + "axis", !e[s] && n.n == 1 && (s = t + "axis");
                    if (e[s]) {
                        r = e[s].from, i = e[s].to;
                        break;
                    }
                }
            }
            e[s] || (n = t == "x" ? lt[0] : ct[0], r = e[t + "1"], i = e[t + "2"]);
            if (r != null && i != null && r > i) {
                var a = r;
                r = i, i = a;
            }
            return {
                from: r,
                to: i,
                axis: n
            };
        }
        function P() {
            at.save(), at.translate(ht.left, ht.top), at.fillStyle = nt(it.grid.backgroundColor, dt, 0, "rgba(255, 255, 255, 0)"), at.fillRect(0, 0, pt, dt), at.restore();
        }
        function H() {
            var t, n, r, i;
            at.save(), at.translate(ht.left, ht.top);
            var s = it.grid.markings;
            if (s) {
                e.isFunction(s) && (n = mt.getAxes(), n.xmin = n.xaxis.min, n.xmax = n.xaxis.max, n.ymin = n.yaxis.min, n.ymax = n.yaxis.max, s = s(n));
                for (t = 0; t < s.length; ++t) {
                    var o = s[t], u = D(o, "x"), a = D(o, "y");
                    u.from == null && (u.from = u.axis.min), u.to == null && (u.to = u.axis.max), a.from == null && (a.from = a.axis.min), a.to == null && (a.to = a.axis.max);
                    if (u.to < u.axis.min || u.from > u.axis.max || a.to < a.axis.min || a.from > a.axis.max) continue;
                    u.from = Math.max(u.from, u.axis.min), u.to = Math.min(u.to, u.axis.max), a.from = Math.max(a.from, a.axis.min), a.to = Math.min(a.to, a.axis.max);
                    if (u.from == u.to && a.from == a.to) continue;
                    u.from = u.axis.p2c(u.from), u.to = u.axis.p2c(u.to), a.from = a.axis.p2c(a.from), a.to = a.axis.p2c(a.to), u.from == u.to || a.from == a.to ? (at.beginPath(), at.strokeStyle = o.color || it.grid.markingsColor, at.lineWidth = o.lineWidth || it.grid.markingsLineWidth, at.moveTo(u.from, a.from), at.lineTo(u.to, a.to), at.stroke()) : (at.fillStyle = o.color || it.grid.markingsColor, at.fillRect(u.from, a.to, u.to - u.from, a.from - a.to));
                }
            }
            n = p(), r = it.grid.borderWidth;
            for (var f = 0; f < n.length; ++f) {
                var l = n[f], c = l.box, h = l.tickLength, d, v, m, g;
                if (!l.show || l.ticks.length == 0) continue;
                at.lineWidth = 1, l.direction == "x" ? (d = 0, h == "full" ? v = l.position == "top" ? 0 : dt : v = c.top - ht.top + (l.position == "top" ? c.height : 0)) : (v = 0, h == "full" ? d = l.position == "left" ? 0 : pt : d = c.left - ht.left + (l.position == "left" ? c.width : 0)), l.innermost || (at.strokeStyle = l.options.color, at.beginPath(), m = g = 0, l.direction == "x" ? m = pt + 1 : g = dt + 1, at.lineWidth == 1 && (l.direction == "x" ? v = Math.floor(v) + .5 : d = Math.floor(d) + .5), at.moveTo(d, v), at.lineTo(d + m, v + g), at.stroke()), at.strokeStyle = l.options.tickColor, at.beginPath();
                for (t = 0; t < l.ticks.length; ++t) {
                    var y = l.ticks[t].v;
                    m = g = 0;
                    if (isNaN(y) || y < l.min || y > l.max || h == "full" && (typeof r == "object" && r[l.position] > 0 || r > 0) && (y == l.min || y == l.max)) continue;
                    l.direction == "x" ? (d = l.p2c(y), g = h == "full" ? -dt : h, l.position == "top" && (g = -g)) : (v = l.p2c(y), m = h == "full" ? -pt : h, l.position == "left" && (m = -m)), at.lineWidth == 1 && (l.direction == "x" ? d = Math.floor(d) + .5 : v = Math.floor(v) + .5), at.moveTo(d, v), at.lineTo(d + m, v + g);
                }
                at.stroke();
            }
            r && (i = it.grid.borderColor, typeof r == "object" || typeof i == "object" ? (typeof r != "object" && (r = {
                top: r,
                right: r,
                bottom: r,
                left: r
            }), typeof i != "object" && (i = {
                top: i,
                right: i,
                bottom: i,
                left: i
            }), r.top > 0 && (at.strokeStyle = i.top, at.lineWidth = r.top, at.beginPath(), at.moveTo(0 - r.left, 0 - r.top / 2), at.lineTo(pt, 0 - r.top / 2), at.stroke()), r.right > 0 && (at.strokeStyle = i.right, at.lineWidth = r.right, at.beginPath(), at.moveTo(pt + r.right / 2, 0 - r.top), at.lineTo(pt + r.right / 2, dt), at.stroke()), r.bottom > 0 && (at.strokeStyle = i.bottom, at.lineWidth = r.bottom, at.beginPath(), at.moveTo(pt + r.right, dt + r.bottom / 2), at.lineTo(0, dt + r.bottom / 2), at.stroke()), r.left > 0 && (at.strokeStyle = i.left, at.lineWidth = r.left, at.beginPath(), at.moveTo(0 - r.left / 2, dt + r.bottom), at.lineTo(0 - r.left / 2, 0), at.stroke())) : (at.lineWidth = r, at.strokeStyle = it.grid.borderColor, at.strokeRect(-r / 2, -r / 2, pt + r, dt + r))), at.restore();
        }
        function B() {
            e.each(p(), function(e, t) {
                if (!t.show || t.ticks.length == 0) return;
                var n = t.box, r = t.direction + "Axis " + t.direction + t.n + "Axis", i = "flot-" + t.direction + "-axis flot-" + t.direction + t.n + "-axis " + r, s = t.options.font || "flot-tick-label tickLabel", o, u, a, f, l;
                st.removeText(i);
                for (var c = 0; c < t.ticks.length; ++c) {
                    o = t.ticks[c];
                    if (!o.label || o.v < t.min || o.v > t.max) continue;
                    t.direction == "x" ? (f = "center", u = ht.left + t.p2c(o.v), t.position == "bottom" ? a = n.top + n.padding : (a = n.top + n.height - n.padding, l = "bottom")) : (l = "middle", a = ht.top + t.p2c(o.v), t.position == "left" ? (u = n.left + n.width - n.padding, f = "right") : u = n.left + n.padding), st.addText(i, u, a, o.label, s, null, null, f, l);
                }
            });
        }
        function j(e) {
            e.lines.show && F(e), e.bars.show && R(e), e.points.show && I(e);
        }
        function F(e) {
            function t(e, t, n, r, i) {
                var s = e.points, o = e.pointsize, u = null, a = null;
                at.beginPath();
                for (var f = o; f < s.length; f += o) {
                    var l = s[f - o], c = s[f - o + 1], h = s[f], p = s[f + 1];
                    if (l == null || h == null) continue;
                    if (c <= p && c < i.min) {
                        if (p < i.min) continue;
                        l = (i.min - c) / (p - c) * (h - l) + l, c = i.min;
                    } else if (p <= c && p < i.min) {
                        if (c < i.min) continue;
                        h = (i.min - c) / (p - c) * (h - l) + l, p = i.min;
                    }
                    if (c >= p && c > i.max) {
                        if (p > i.max) continue;
                        l = (i.max - c) / (p - c) * (h - l) + l, c = i.max;
                    } else if (p >= c && p > i.max) {
                        if (c > i.max) continue;
                        h = (i.max - c) / (p - c) * (h - l) + l, p = i.max;
                    }
                    if (l <= h && l < r.min) {
                        if (h < r.min) continue;
                        c = (r.min - l) / (h - l) * (p - c) + c, l = r.min;
                    } else if (h <= l && h < r.min) {
                        if (l < r.min) continue;
                        p = (r.min - l) / (h - l) * (p - c) + c, h = r.min;
                    }
                    if (l >= h && l > r.max) {
                        if (h > r.max) continue;
                        c = (r.max - l) / (h - l) * (p - c) + c, l = r.max;
                    } else if (h >= l && h > r.max) {
                        if (l > r.max) continue;
                        p = (r.max - l) / (h - l) * (p - c) + c, h = r.max;
                    }
                    (l != u || c != a) && at.moveTo(r.p2c(l) + t, i.p2c(c) + n), u = h, a = p, at.lineTo(r.p2c(h) + t, i.p2c(p) + n);
                }
                at.stroke();
            }
            function n(e, t, n) {
                var r = e.points, i = e.pointsize, s = Math.min(Math.max(0, n.min), n.max), o = 0, u, a = !1, f = 1, l = 0, c = 0;
                for (;;) {
                    if (i > 0 && o > r.length + i) break;
                    o += i;
                    var h = r[o - i], p = r[o - i + f], d = r[o], v = r[o + f];
                    if (a) {
                        if (i > 0 && h != null && d == null) {
                            c = o, i = -i, f = 2;
                            continue;
                        }
                        if (i < 0 && o == l + i) {
                            at.fill(), a = !1, i = -i, f = 1, o = l = c + i;
                            continue;
                        }
                    }
                    if (h == null || d == null) continue;
                    if (h <= d && h < t.min) {
                        if (d < t.min) continue;
                        p = (t.min - h) / (d - h) * (v - p) + p, h = t.min;
                    } else if (d <= h && d < t.min) {
                        if (h < t.min) continue;
                        v = (t.min - h) / (d - h) * (v - p) + p, d = t.min;
                    }
                    if (h >= d && h > t.max) {
                        if (d > t.max) continue;
                        p = (t.max - h) / (d - h) * (v - p) + p, h = t.max;
                    } else if (d >= h && d > t.max) {
                        if (h > t.max) continue;
                        v = (t.max - h) / (d - h) * (v - p) + p, d = t.max;
                    }
                    a || (at.beginPath(), at.moveTo(t.p2c(h), n.p2c(s)), a = !0);
                    if (p >= n.max && v >= n.max) {
                        at.lineTo(t.p2c(h), n.p2c(n.max)), at.lineTo(t.p2c(d), n.p2c(n.max));
                        continue;
                    }
                    if (p <= n.min && v <= n.min) {
                        at.lineTo(t.p2c(h), n.p2c(n.min)), at.lineTo(t.p2c(d), n.p2c(n.min));
                        continue;
                    }
                    var m = h, g = d;
                    p <= v && p < n.min && v >= n.min ? (h = (n.min - p) / (v - p) * (d - h) + h, p = n.min) : v <= p && v < n.min && p >= n.min && (d = (n.min - p) / (v - p) * (d - h) + h, v = n.min), p >= v && p > n.max && v <= n.max ? (h = (n.max - p) / (v - p) * (d - h) + h, p = n.max) : v >= p && v > n.max && p <= n.max && (d = (n.max - p) / (v - p) * (d - h) + h, v = n.max), h != m && at.lineTo(t.p2c(m), n.p2c(p)), at.lineTo(t.p2c(h), n.p2c(p)), at.lineTo(t.p2c(d), n.p2c(v)), d != g && (at.lineTo(t.p2c(d), n.p2c(v)), at.lineTo(t.p2c(g), n.p2c(v)));
                }
            }
            at.save(), at.translate(ht.left, ht.top), at.lineJoin = "round";
            var r = e.lines.lineWidth, i = e.shadowSize;
            if (r > 0 && i > 0) {
                at.lineWidth = i, at.strokeStyle = "rgba(0,0,0,0.1)";
                var s = Math.PI / 18;
                t(e.datapoints, Math.sin(s) * (r / 2 + i / 2), Math.cos(s) * (r / 2 + i / 2), e.xaxis, e.yaxis), at.lineWidth = i / 2, t(e.datapoints, Math.sin(s) * (r / 2 + i / 4), Math.cos(s) * (r / 2 + i / 4), e.xaxis, e.yaxis);
            }
            at.lineWidth = r, at.strokeStyle = e.color;
            var o = U(e.lines, e.color, 0, dt);
            o && (at.fillStyle = o, n(e.datapoints, e.xaxis, e.yaxis)), r > 0 && t(e.datapoints, 0, 0, e.xaxis, e.yaxis), at.restore();
        }
        function I(e) {
            function t(e, t, n, r, i, s, o, u) {
                var a = e.points, f = e.pointsize;
                for (var l = 0; l < a.length; l += f) {
                    var c = a[l], h = a[l + 1];
                    if (c == null || c < s.min || c > s.max || h < o.min || h > o.max) continue;
                    at.beginPath(), c = s.p2c(c), h = o.p2c(h) + r, u == "circle" ? at.arc(c, h, t, 0, i ? Math.PI : Math.PI * 2, !1) : u(at, c, h, t, i), at.closePath(), n && (at.fillStyle = n, at.fill()), at.stroke();
                }
            }
            at.save(), at.translate(ht.left, ht.top);
            var n = e.points.lineWidth, r = e.shadowSize, i = e.points.radius, s = e.points.symbol;
            n == 0 && (n = 1e-4);
            if (n > 0 && r > 0) {
                var o = r / 2;
                at.lineWidth = o, at.strokeStyle = "rgba(0,0,0,0.1)", t(e.datapoints, i, null, o + o / 2, !0, e.xaxis, e.yaxis, s), at.strokeStyle = "rgba(0,0,0,0.2)", t(e.datapoints, i, null, o / 2, !0, e.xaxis, e.yaxis, s);
            }
            at.lineWidth = n, at.strokeStyle = e.color, t(e.datapoints, i, U(e.points, e.color), 0, !1, e.xaxis, e.yaxis, s), at.restore();
        }
        function q(e, t, n, r, i, s, o, u, a, f, l, c) {
            var h, p, d, v, m, g, y, b, w;
            l ? (b = g = y = !0, m = !1, h = n, p = e, v = t + r, d = t + i, p < h && (w = p, p = h, h = w, m = !0, g = !1)) : (m = g = y = !0, b = !1, h = e + r, p = e + i, d = n, v = t, v < d && (w = v, v = d, d = w, b = !0, y = !1));
            if (p < u.min || h > u.max || v < a.min || d > a.max) return;
            h < u.min && (h = u.min, m = !1), p > u.max && (p = u.max, g = !1), d < a.min && (d = a.min, b = !1), v > a.max && (v = a.max, y = !1), h = u.p2c(h), d = a.p2c(d), p = u.p2c(p), v = a.p2c(v), o && (f.beginPath(), f.moveTo(h, d), f.lineTo(h, v), f.lineTo(p, v), f.lineTo(p, d), f.fillStyle = o(d, v), f.fill()), c > 0 && (m || g || y || b) && (f.beginPath(), f.moveTo(h, d + s), m ? f.lineTo(h, v + s) : f.moveTo(h, v + s), y ? f.lineTo(p, v + s) : f.moveTo(p, v + s), g ? f.lineTo(p, d + s) : f.moveTo(p, d + s), b ? f.lineTo(h, d + s) : f.moveTo(h, d + s), f.stroke());
        }
        function R(e) {
            function t(t, n, r, i, s, o, u) {
                var a = t.points, f = t.pointsize;
                for (var l = 0; l < a.length; l += f) {
                    if (a[l] == null) continue;
                    q(a[l], a[l + 1], a[l + 2], n, r, i, s, o, u, at, e.bars.horizontal, e.bars.lineWidth);
                }
            }
            at.save(), at.translate(ht.left, ht.top), at.lineWidth = e.bars.lineWidth, at.strokeStyle = e.color;
            var n;
            switch (e.bars.align) {
              case "left":
                n = 0;
                break;
              case "right":
                n = -e.bars.barWidth;
                break;
              case "center":
                n = -e.bars.barWidth / 2;
                break;
              default:
                throw new Error("Invalid bar alignment: " + e.bars.align);
            }
            var r = e.bars.fill ? function(t, n) {
                return U(e.bars, e.color, t, n);
            } : null;
            t(e.datapoints, n, n + e.bars.barWidth, 0, r, e.xaxis, e.yaxis), at.restore();
        }
        function U(t, n, r, i) {
            var s = t.fill;
            if (!s) return null;
            if (t.fillColor) return nt(t.fillColor, r, i, n);
            var o = e.color.parse(n);
            return o.a = typeof s == "number" ? s : .4, o.normalize(), o.toString();
        }
        function z() {
            n.find(".legend").remove();
            if (!it.legend.show) return;
            var t = [], r = [], i = !1, s = it.legend.labelFormatter, o, u;
            for (var a = 0; a < rt.length; ++a) o = rt[a], o.label && (u = s ? s(o.label, o) : o.label, u && r.push({
                label: u,
                color: o.color
            }));
            if (it.legend.sorted) if (e.isFunction(it.legend.sorted)) r.sort(it.legend.sorted); else if (it.legend.sorted == "reverse") r.reverse(); else {
                var f = it.legend.sorted != "descending";
                r.sort(function(e, t) {
                    return e.label == t.label ? 0 : e.label < t.label != f ? 1 : -1;
                });
            }
            for (var a = 0; a < r.length; ++a) {
                var l = r[a];
                a % it.legend.noColumns == 0 && (i && t.push("</tr>"), t.push("<tr>"), i = !0), t.push('<td class="legendColorBox"><div style="border:1px solid ' + it.legend.labelBoxBorderColor + ';padding:1px"><div style="width:4px;height:0;border:5px solid ' + l.color + ';overflow:hidden"></div></div></td>' + '<td class="legendLabel">' + l.label + "</td>");
            }
            i && t.push("</tr>");
            if (t.length == 0) return;
            var c = '<table style="font-size:smaller;color:' + it.grid.color + '">' + t.join("") + "</table>";
            if (it.legend.container != null) e(it.legend.container).html(c); else {
                var h = "", p = it.legend.position, d = it.legend.margin;
                d[0] == null && (d = [ d, d ]), p.charAt(0) == "n" ? h += "top:" + (d[1] + ht.top) + "px;" : p.charAt(0) == "s" && (h += "bottom:" + (d[1] + ht.bottom) + "px;"), p.charAt(1) == "e" ? h += "right:" + (d[0] + ht.right) + "px;" : p.charAt(1) == "w" && (h += "left:" + (d[0] + ht.left) + "px;");
                var v = e('<div class="legend">' + c.replace('style="', 'style="position:absolute;' + h + ";") + "</div>").appendTo(n);
                if (it.legend.backgroundOpacity != 0) {
                    var m = it.legend.backgroundColor;
                    m == null && (m = it.grid.backgroundColor, m && typeof m == "string" ? m = e.color.parse(m) : m = e.color.extract(v, "background-color"), m.a = 1, m = m.toString());
                    var g = v.children();
                    e('<div style="position:absolute;width:' + g.width() + "px;height:" + g.height() + "px;" + h + "background-color:" + m + ';"> </div>').prependTo(v).css("opacity", it.legend.backgroundOpacity);
                }
            }
        }
        function W(e, t, n) {
            var r = it.grid.mouseActiveRadius, i = r * r + 1, s = null, o = !1, u, a, f;
            for (u = rt.length - 1; u >= 0; --u) {
                if (!n(rt[u])) continue;
                var l = rt[u], c = l.xaxis, h = l.yaxis, p = l.datapoints.points, d = c.c2p(e), v = h.c2p(t), m = r / c.scale, g = r / h.scale;
                f = l.datapoints.pointsize, c.options.inverseTransform && (m = Number.MAX_VALUE), h.options.inverseTransform && (g = Number.MAX_VALUE);
                if (l.lines.show || l.points.show) for (a = 0; a < p.length; a += f) {
                    var y = p[a], b = p[a + 1];
                    if (y == null) continue;
                    if (y - d > m || y - d < -m || b - v > g || b - v < -g) continue;
                    var w = Math.abs(c.p2c(y) - e), E = Math.abs(h.p2c(b) - t), S = w * w + E * E;
                    S < i && (i = S, s = [ u, a / f ]);
                }
                if (l.bars.show && !s) {
                    var x = l.bars.align == "left" ? 0 : -l.bars.barWidth / 2, T = x + l.bars.barWidth;
                    for (a = 0; a < p.length; a += f) {
                        var y = p[a], b = p[a + 1], N = p[a + 2];
                        if (y == null) continue;
                        if (rt[u].bars.horizontal ? d <= Math.max(N, y) && d >= Math.min(N, y) && v >= b + x && v <= b + T : d >= y + x && d <= y + T && v >= Math.min(N, b) && v <= Math.max(N, b)) s = [ u, a / f ];
                    }
                }
            }
            return s ? (u = s[0], a = s[1], f = rt[u].datapoints.pointsize, {
                datapoint: rt[u].datapoints.points.slice(a * f, (a + 1) * f),
                dataIndex: a,
                series: rt[u],
                seriesIndex: u
            }) : null;
        }
        function X(e) {
            it.grid.hoverable && J("plothover", e, function(e) {
                return e["hoverable"] != 0;
            });
        }
        function V(e) {
            it.grid.hoverable && J("plothover", e, function(e) {
                return !1;
            });
        }
        function $(e) {
            J("plotclick", e, function(e) {
                return e["clickable"] != 0;
            });
        }
        function J(e, t, r) {
            var i = ut.offset(), s = t.pageX - i.left - ht.left, o = t.pageY - i.top - ht.top, u = d({
                left: s,
                top: o
            });
            u.pageX = t.pageX, u.pageY = t.pageY;
            var a = W(s, o, r);
            a && (a.pageX = parseInt(a.series.xaxis.p2c(a.datapoint[0]) + i.left + ht.left, 10), a.pageY = parseInt(a.series.yaxis.p2c(a.datapoint[1]) + i.top + ht.top, 10));
            if (it.grid.autoHighlight) {
                for (var f = 0; f < gt.length; ++f) {
                    var l = gt[f];
                    l.auto == e && (!a || l.series != a.series || l.point[0] != a.datapoint[0] || l.point[1] != a.datapoint[1]) && Y(l.series, l.point);
                }
                a && G(a.series, a.datapoint, e);
            }
            n.trigger(e, [ u, a ]);
        }
        function K() {
            var e = it.interaction.redrawOverlayInterval;
            if (e == -1) {
                Q();
                return;
            }
            yt || (yt = setTimeout(Q, e));
        }
        function Q() {
            yt = null, ft.save(), ot.clear(), ft.translate(ht.left, ht.top);
            var e, t;
            for (e = 0; e < gt.length; ++e) t = gt[e], t.series.bars.show ? tt(t.series, t.point) : et(t.series, t.point);
            ft.restore(), u(vt.drawOverlay, [ ft ]);
        }
        function G(e, t, n) {
            typeof e == "number" && (e = rt[e]);
            if (typeof t == "number") {
                var r = e.datapoints.pointsize;
                t = e.datapoints.points.slice(r * t, r * (t + 1));
            }
            var i = Z(e, t);
            i == -1 ? (gt.push({
                series: e,
                point: t,
                auto: n
            }), K()) : n || (gt[i].auto = !1);
        }
        function Y(e, t) {
            if (e == null && t == null) {
                gt = [], K();
                return;
            }
            typeof e == "number" && (e = rt[e]);
            if (typeof t == "number") {
                var n = e.datapoints.pointsize;
                t = e.datapoints.points.slice(n * t, n * (t + 1));
            }
            var r = Z(e, t);
            r != -1 && (gt.splice(r, 1), K());
        }
        function Z(e, t) {
            for (var n = 0; n < gt.length; ++n) {
                var r = gt[n];
                if (r.series == e && r.point[0] == t[0] && r.point[1] == t[1]) return n;
            }
            return -1;
        }
        function et(t, n) {
            var r = n[0], i = n[1], s = t.xaxis, o = t.yaxis, u = typeof t.highlightColor == "string" ? t.highlightColor : e.color.parse(t.color).scale("a", .5).toString();
            if (r < s.min || r > s.max || i < o.min || i > o.max) return;
            var a = t.points.radius + t.points.lineWidth / 2;
            ft.lineWidth = a, ft.strokeStyle = u;
            var f = 1.5 * a;
            r = s.p2c(r), i = o.p2c(i), ft.beginPath(), t.points.symbol == "circle" ? ft.arc(r, i, f, 0, 2 * Math.PI, !1) : t.points.symbol(ft, r, i, f, !1), ft.closePath(), ft.stroke();
        }
        function tt(t, n) {
            var r = typeof t.highlightColor == "string" ? t.highlightColor : e.color.parse(t.color).scale("a", .5).toString(), i = r, s = t.bars.align == "left" ? 0 : -t.bars.barWidth / 2;
            ft.lineWidth = t.bars.lineWidth, ft.strokeStyle = r, q(n[0], n[1], n[2] || 0, s, s + t.bars.barWidth, 0, function() {
                return i;
            }, t.xaxis, t.yaxis, ft, t.bars.horizontal, t.bars.lineWidth);
        }
        function nt(t, n, r, i) {
            if (typeof t == "string") return t;
            var s = at.createLinearGradient(0, r, 0, n);
            for (var o = 0, u = t.colors.length; o < u; ++o) {
                var a = t.colors[o];
                if (typeof a != "string") {
                    var f = e.color.parse(i);
                    a.brightness != null && (f = f.scale("rgb", a.brightness)), a.opacity != null && (f.a *= a.opacity), a = f.toString();
                }
                s.addColorStop(o / (u - 1), a);
            }
            return s;
        }
        var rt = [], it = {
            colors: [ "#edc240", "#afd8f8", "#cb4b4b", "#4da74d", "#9440ed" ],
            legend: {
                show: !0,
                noColumns: 1,
                labelFormatter: null,
                labelBoxBorderColor: "#ccc",
                container: null,
                position: "ne",
                margin: 5,
                backgroundColor: null,
                backgroundOpacity: .85,
                sorted: null
            },
            xaxis: {
                show: null,
                position: "bottom",
                mode: null,
                font: null,
                color: null,
                tickColor: null,
                transform: null,
                inverseTransform: null,
                min: null,
                max: null,
                autoscaleMargin: null,
                ticks: null,
                tickFormatter: null,
                labelWidth: null,
                labelHeight: null,
                reserveSpace: null,
                tickLength: null,
                alignTicksWithAxis: null,
                tickDecimals: null,
                tickSize: null,
                minTickSize: null
            },
            yaxis: {
                autoscaleMargin: .02,
                position: "left"
            },
            xaxes: [],
            yaxes: [],
            series: {
                points: {
                    show: !1,
                    radius: 3,
                    lineWidth: 2,
                    fill: !0,
                    fillColor: "#ffffff",
                    symbol: "circle"
                },
                lines: {
                    lineWidth: 2,
                    fill: !1,
                    fillColor: null,
                    steps: !1
                },
                bars: {
                    show: !1,
                    lineWidth: 2,
                    barWidth: 1,
                    fill: !0,
                    fillColor: null,
                    align: "left",
                    horizontal: !1,
                    zero: !0
                },
                shadowSize: 3,
                highlightColor: null
            },
            grid: {
                show: !0,
                aboveData: !1,
                color: "#545454",
                backgroundColor: null,
                borderColor: null,
                tickColor: null,
                margin: 0,
                labelMargin: 5,
                axisMargin: 8,
                borderWidth: 2,
                minBorderMargin: null,
                markings: null,
                markingsColor: "#f4f4f4",
                markingsLineWidth: 2,
                clickable: !1,
                hoverable: !1,
                autoHighlight: !0,
                mouseActiveRadius: 10
            },
            interaction: {
                redrawOverlayInterval: 1e3 / 60
            },
            hooks: {}
        }, st = null, ot = null, ut = null, at = null, ft = null, lt = [], ct = [], ht = {
            left: 0,
            right: 0,
            top: 0,
            bottom: 0
        }, pt = 0, dt = 0, vt = {
            processOptions: [],
            processRawData: [],
            processDatapoints: [],
            processOffset: [],
            drawBackground: [],
            drawSeries: [],
            draw: [],
            bindEvents: [],
            drawOverlay: [],
            shutdown: []
        }, mt = this;
        mt.setData = l, mt.setupGrid = k, mt.draw = _, mt.getPlaceholder = function() {
            return n;
        }, mt.getCanvas = function() {
            return st.element;
        }, mt.getPlotOffset = function() {
            return ht;
        }, mt.width = function() {
            return pt;
        }, mt.height = function() {
            return dt;
        }, mt.offset = function() {
            var e = ut.offset();
            return e.left += ht.left, e.top += ht.top, e;
        }, mt.getData = function() {
            return rt;
        }, mt.getAxes = function() {
            var t = {}, n;
            return e.each(lt.concat(ct), function(e, n) {
                n && (t[n.direction + (n.n != 1 ? n.n : "") + "axis"] = n);
            }), t;
        }, mt.getXAxes = function() {
            return lt;
        }, mt.getYAxes = function() {
            return ct;
        }, mt.c2p = d, mt.p2c = v, mt.getOptions = function() {
            return it;
        }, mt.highlight = G, mt.unhighlight = Y, mt.triggerRedrawOverlay = K, mt.pointOffset = function(e) {
            return {
                left: parseInt(lt[h(e, "x") - 1].p2c(+e.x) + ht.left, 10),
                top: parseInt(ct[h(e, "y") - 1].p2c(+e.y) + ht.top, 10)
            };
        }, mt.shutdown = E, mt.resize = function() {
            var e = n.width(), t = n.height();
            st.resize(e, t), ot.resize(e, t);
        }, mt.hooks = vt, a(mt), f(s), b(), l(i), k(), _(), w();
        var gt = [], yt = null;
    }
    function r(e, t) {
        return t * Math.floor(e / t);
    }
    var i = Object.prototype.hasOwnProperty;
    t.prototype.resize = function(e, t) {
        if (e <= 0 || t <= 0) throw new Error("Invalid dimensions for plot, width = " + e + ", height = " + t);
        var n = this.element, r = this.context, i = this.pixelRatio;
        this.width != e && (n.width = e * i, n.style.width = e + "px", this.width = e), this.height != t && (n.height = t * i, n.style.height = t + "px", this.height = t), r.restore(), r.save(), r.scale(i, i);
    }, t.prototype.clear = function() {
        this.context.clearRect(0, 0, this.width, this.height);
    }, t.prototype.render = function() {
        var e = this._textCache;
        for (var t in e) if (i.call(e, t)) {
            var n = this.getTextLayer(t), r = e[t];
            n.hide();
            for (var s in r) if (i.call(r, s)) {
                var o = r[s];
                for (var u in o) if (i.call(o, u)) {
                    var a = o[u].positions;
                    for (var f = 0, l; l = a[f]; f++) l.active ? l.rendered || (n.append(l.element), l.rendered = !0) : (a.splice(f--, 1), l.rendered && l.element.detach());
                    a.length == 0 && delete o[u];
                }
            }
            n.show();
        }
    }, t.prototype.getTextLayer = function(t) {
        var n = this.text[t];
        return n == null && (this.textContainer == null && (this.textContainer = e("<div class='flot-text'></div>").css({
            position: "absolute",
            top: 0,
            left: 0,
            bottom: 0,
            right: 0,
            "font-size": "smaller",
            color: "#545454"
        }).insertAfter(this.element)), n = this.text[t] = e("<div></div>").addClass(t).css({
            position: "absolute",
            top: 0,
            left: 0,
            bottom: 0,
            right: 0
        }).appendTo(this.textContainer)), n;
    }, t.prototype.getTextInfo = function(t, n, r, i, s) {
        var o, u, a, f;
        n = "" + n, typeof r == "object" ? o = r.style + " " + r.variant + " " + r.weight + " " + r.size + "px/" + r.lineHeight + "px " + r.family : o = r, u = this._textCache[t], u == null && (u = this._textCache[t] = {}), a = u[o], a == null && (a = u[o] = {}), f = a[n];
        if (f == null) {
            var l = e("<div></div>").html(n).css({
                position: "absolute",
                "max-width": s,
                top: -9999
            }).appendTo(this.getTextLayer(t));
            typeof r == "object" ? l.css({
                font: o,
                color: r.color
            }) : typeof r == "string" && l.addClass(r), f = a[n] = {
                width: l.outerWidth(!0),
                height: l.outerHeight(!0),
                element: l,
                positions: []
            }, l.detach();
        }
        return f;
    }, t.prototype.addText = function(e, t, n, r, i, s, o, u, a) {
        var f = this.getTextInfo(e, r, i, s, o), l = f.positions;
        u == "center" ? t -= f.width / 2 : u == "right" && (t -= f.width), a == "middle" ? n -= f.height / 2 : a == "bottom" && (n -= f.height);
        for (var c = 0, h; h = l[c]; c++) if (h.x == t && h.y == n) {
            h.active = !0;
            return;
        }
        h = {
            active: !0,
            rendered: !1,
            element: l.length ? f.element.clone() : f.element,
            x: t,
            y: n
        }, l.push(h), h.element.css({
            top: Math.round(n),
            left: Math.round(t),
            "text-align": u
        });
    }, t.prototype.removeText = function(e, t, n, r, s, o) {
        if (r == null) {
            var u = this._textCache[e];
            if (u != null) for (var a in u) if (i.call(u, a)) {
                var f = u[a];
                for (var l in f) if (i.call(f, l)) {
                    var c = f[l].positions;
                    for (var h = 0, p; p = c[h]; h++) p.active = !1;
                }
            }
        } else {
            var c = this.getTextInfo(e, r, s, o).positions;
            for (var h = 0, p; p = c[h]; h++) p.x == t && p.y == n && (p.active = !1);
        }
    }, e.plot = function(t, r, i) {
        var s = new n(e(t), r, i, e.plot.plugins);
        return s;
    }, e.plot.version = "0.8.1", e.plot.plugins = [], e.fn.plot = function(t, n) {
        return this.each(function() {
            e.plot(this, t, n);
        });
    };
}(jQuery);
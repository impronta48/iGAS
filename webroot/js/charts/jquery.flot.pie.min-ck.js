/* Flot plugin for rendering pie charts.

Copyright (c) 2007-2013 IOLA and Ole Laursen.
Licensed under the MIT license.

The plugin assumes that each series has a single data value, and that each
value is a positive integer or zero.  Negative numbers don't make sense for a
pie chart, and have unpredictable results.  The values do NOT need to be
passed in as percentages; the plugin will calculate the total and per-slice
percentages internally.

* Created by Brian Medendorp

* Updated with contributions from btburnett3, Anthony Aragues and Xavi Ivars

The plugin supports these options:

	series: {
		pie: {
			show: true/false
			radius: 0-1 for percentage of fullsize, or a specified pixel length, or 'auto'
			innerRadius: 0-1 for percentage of fullsize or a specified pixel length, for creating a donut effect
			startAngle: 0-2 factor of PI used for starting angle (in radians) i.e 3/2 starts at the top, 0 and 2 have the same result
			tilt: 0-1 for percentage to tilt the pie, where 1 is no tilt, and 0 is completely flat (nothing will show)
			offset: {
				top: integer value to move the pie up or down
				left: integer value to move the pie left or right, or 'auto'
			},
			stroke: {
				color: any hexidecimal color value (other formats may or may not work, so best to stick with something like '#FFF')
				width: integer pixel width of the stroke
			},
			label: {
				show: true/false, or 'auto'
				formatter:  a user-defined function that modifies the text/style of the label text
				radius: 0-1 for percentage of fullsize, or a specified pixel length
				background: {
					color: any hexidecimal color value (other formats may or may not work, so best to stick with something like '#000')
					opacity: 0-1
				},
				threshold: 0-1 for the percentage value at which to hide labels (if they're too small)
			},
			combine: {
				threshold: 0-1 for the percentage value at which to combine slices (if they're too small)
				color: any hexidecimal color value (other formats may or may not work, so best to stick with something like '#CCC'), if null, the plugin will automatically use the color of the first slice to be combined
				label: any text value of what the combined slice should be labeled
			}
			highlight: {
				opacity: 0-1
			}
		}
	}

More detail and specific examples can be found in the included HTML file.

*/(function(e) {
    function t(t) {
        function s(t, n, r) {
            x || (x = !0, y = t.getCanvas(), b = e(y).parent(), i = t.getOptions(), t.setData(o(t.getData())));
        }
        function o(t) {
            var n = 0, r = 0, s = 0, o = i.series.pie.combine.color, u = [];
            for (var a = 0; a < t.length; ++a) {
                var f = t[a].data;
                e.isArray(f) && f.length == 1 && (f = f[0]), e.isArray(f) ? !isNaN(parseFloat(f[1])) && isFinite(f[1]) ? f[1] = +f[1] : f[1] = 0 : !isNaN(parseFloat(f)) && isFinite(f) ? f = [ 1, +f ] : f = [ 1, 0 ], t[a].data = [ f ];
            }
            for (var a = 0; a < t.length; ++a) n += t[a].data[0][1];
            for (var a = 0; a < t.length; ++a) {
                var f = t[a].data[0][1];
                f / n <= i.series.pie.combine.threshold && (r += f, s++, o || (o = t[a].color));
            }
            for (var a = 0; a < t.length; ++a) {
                var f = t[a].data[0][1];
                (s < 2 || f / n > i.series.pie.combine.threshold) && u.push({
                    data: [ [ 1, f ] ],
                    color: t[a].color,
                    label: t[a].label,
                    angle: f * Math.PI * 2 / n,
                    percent: f / (n / 100)
                });
            }
            return s > 1 && u.push({
                data: [ [ 1, r ] ],
                color: o,
                label: i.series.pie.combine.label,
                angle: r * Math.PI * 2 / n,
                percent: r / (n / 100)
            }), u;
        }
        function u(t, s) {
            function o() {
                T.clearRect(0, 0, l, c), b.children().filter(".pieLabel, .pieLabelBackground").remove();
            }
            function u() {
                var e = i.series.pie.shadow.left, t = i.series.pie.shadow.top, n = 10, r = i.series.pie.shadow.alpha, s = i.series.pie.radius > 1 ? i.series.pie.radius : w * i.series.pie.radius;
                if (s >= l / 2 - e || s * i.series.pie.tilt >= c / 2 - t || s <= n) return;
                T.save(), T.translate(e, t), T.globalAlpha = r, T.fillStyle = "#000", T.translate(E, S), T.scale(1, i.series.pie.tilt);
                for (var o = 1; o <= n; o++) T.beginPath(), T.arc(0, 0, s, 0, Math.PI * 2, !1), T.fill(), s -= o;
                T.restore();
            }
            function f() {
                function t(e, t, n) {
                    if (e <= 0 || isNaN(e)) return;
                    n ? T.fillStyle = t : (T.strokeStyle = t, T.lineJoin = "round"), T.beginPath(), Math.abs(e - Math.PI * 2) > 1e-9 && T.moveTo(0, 0), T.arc(0, 0, s, o, o + e / 2, !1), T.arc(0, 0, s, o + e / 2, o + e, !1), T.closePath(), o += e, n ? T.fill() : T.stroke();
                }
                function n() {
                    function t(t, n, r) {
                        if (t.data[0][1] == 0) return !0;
                        var o = i.legend.labelFormatter, u, a = i.series.pie.label.formatter;
                        o ? u = o(t.label, t) : u = t.label, a && (u = a(u, t));
                        var f = (n + t.angle + n) / 2, h = E + Math.round(Math.cos(f) * s), p = S + Math.round(Math.sin(f) * s) * i.series.pie.tilt, d = "<span class='pieLabel' id='pieLabel" + r + "' style='position:absolute;top:" + p + "px;left:" + h + "px;'>" + u + "</span>";
                        b.append(d);
                        var v = b.children("#pieLabel" + r), m = p - v.height() / 2, g = h - v.width() / 2;
                        v.css("top", m), v.css("left", g);
                        if (0 - m > 0 || 0 - g > 0 || c - (m + v.height()) < 0 || l - (g + v.width()) < 0) return !1;
                        if (i.series.pie.label.background.opacity != 0) {
                            var y = i.series.pie.label.background.color;
                            y == null && (y = t.color);
                            var w = "top:" + m + "px;left:" + g + "px;";
                            e("<div class='pieLabelBackground' style='position:absolute;width:" + v.width() + "px;height:" + v.height() + "px;" + w + "background-color:" + y + ";'></div>").css("opacity", i.series.pie.label.background.opacity).insertBefore(v);
                        }
                        return !0;
                    }
                    var n = r, s = i.series.pie.label.radius > 1 ? i.series.pie.label.radius : w * i.series.pie.label.radius;
                    for (var o = 0; o < p.length; ++o) {
                        if (p[o].percent >= i.series.pie.label.threshold * 100 && !t(p[o], n, o)) return !1;
                        n += p[o].angle;
                    }
                    return !0;
                }
                var r = Math.PI * i.series.pie.startAngle, s = i.series.pie.radius > 1 ? i.series.pie.radius : w * i.series.pie.radius;
                T.save(), T.translate(E, S), T.scale(1, i.series.pie.tilt), T.save();
                var o = r;
                for (var u = 0; u < p.length; ++u) p[u].startAngle = o, t(p[u].angle, p[u].color, !0);
                T.restore();
                if (i.series.pie.stroke.width > 0) {
                    T.save(), T.lineWidth = i.series.pie.stroke.width, o = r;
                    for (var u = 0; u < p.length; ++u) t(p[u].angle, i.series.pie.stroke.color, !1);
                    T.restore();
                }
                return a(T), T.restore(), i.series.pie.label.show ? n() : !0;
            }
            if (!b) return;
            var l = t.getPlaceholder().width(), c = t.getPlaceholder().height(), h = b.children().filter(".legend").children().width() || 0;
            T = s, x = !1, w = Math.min(l, c / i.series.pie.tilt) / 2, S = c / 2 + i.series.pie.offset.top, E = l / 2, i.series.pie.offset.left == "auto" ? i.legend.position.match("w") ? E += h / 2 : E -= h / 2 : E += i.series.pie.offset.left, E < w ? E = w : E > l - w && (E = l - w);
            var p = t.getData(), d = 0;
            do d > 0 && (w *= r), d += 1, o(), i.series.pie.tilt <= .8 && u(); while (!f() && d < n);
            d >= n && (o(), b.prepend("<div class='error'>Could not draw pie with labels contained inside canvas</div>")), t.setSeries && t.insertLegend && (t.setSeries(p), t.insertLegend());
        }
        function a(e) {
            if (i.series.pie.innerRadius > 0) {
                e.save();
                var t = i.series.pie.innerRadius > 1 ? i.series.pie.innerRadius : w * i.series.pie.innerRadius;
                e.globalCompositeOperation = "destination-out", e.beginPath(), e.fillStyle = i.series.pie.stroke.color, e.arc(0, 0, t, 0, Math.PI * 2, !1), e.fill(), e.closePath(), e.restore(), e.save(), e.beginPath(), e.strokeStyle = i.series.pie.stroke.color, e.arc(0, 0, t, 0, Math.PI * 2, !1), e.stroke(), e.closePath(), e.restore();
            }
        }
        function f(e, t) {
            for (var n = !1, r = -1, i = e.length, s = i - 1; ++r < i; s = r) (e[r][1] <= t[1] && t[1] < e[s][1] || e[s][1] <= t[1] && t[1] < e[r][1]) && t[0] < (e[s][0] - e[r][0]) * (t[1] - e[r][1]) / (e[s][1] - e[r][1]) + e[r][0] && (n = !n);
            return n;
        }
        function l(e, n) {
            var r = t.getData(), i = t.getOptions(), s = i.series.pie.radius > 1 ? i.series.pie.radius : w * i.series.pie.radius, o, u;
            for (var a = 0; a < r.length; ++a) {
                var l = r[a];
                if (l.pie.show) {
                    T.save(), T.beginPath(), T.moveTo(0, 0), T.arc(0, 0, s, l.startAngle, l.startAngle + l.angle / 2, !1), T.arc(0, 0, s, l.startAngle + l.angle / 2, l.startAngle + l.angle, !1), T.closePath(), o = e - E, u = n - S;
                    if (T.isPointInPath) {
                        if (T.isPointInPath(e - E, n - S)) return T.restore(), {
                            datapoint: [ l.percent, l.data ],
                            dataIndex: 0,
                            series: l,
                            seriesIndex: a
                        };
                    } else {
                        var c = s * Math.cos(l.startAngle), h = s * Math.sin(l.startAngle), p = s * Math.cos(l.startAngle + l.angle / 4), d = s * Math.sin(l.startAngle + l.angle / 4), v = s * Math.cos(l.startAngle + l.angle / 2), m = s * Math.sin(l.startAngle + l.angle / 2), g = s * Math.cos(l.startAngle + l.angle / 1.5), y = s * Math.sin(l.startAngle + l.angle / 1.5), b = s * Math.cos(l.startAngle + l.angle), x = s * Math.sin(l.startAngle + l.angle), N = [ [ 0, 0 ], [ c, h ], [ p, d ], [ v, m ], [ g, y ], [ b, x ] ], C = [ o, u ];
                        if (f(N, C)) return T.restore(), {
                            datapoint: [ l.percent, l.data ],
                            dataIndex: 0,
                            series: l,
                            seriesIndex: a
                        };
                    }
                    T.restore();
                }
            }
            return null;
        }
        function c(e) {
            p("plothover", e);
        }
        function h(e) {
            p("plotclick", e);
        }
        function p(e, n) {
            var r = t.offset(), s = parseInt(n.pageX - r.left), o = parseInt(n.pageY - r.top), u = l(s, o);
            if (i.grid.autoHighlight) for (var a = 0; a < N.length; ++a) {
                var f = N[a];
                f.auto == e && (!u || f.series != u.series) && v(f.series);
            }
            u && d(u.series, e);
            var c = {
                pageX: n.pageX,
                pageY: n.pageY
            };
            b.trigger(e, [ c, u ]);
        }
        function d(e, n) {
            var r = m(e);
            r == -1 ? (N.push({
                series: e,
                auto: n
            }), t.triggerRedrawOverlay()) : n || (N[r].auto = !1);
        }
        function v(e) {
            e == null && (N = [], t.triggerRedrawOverlay());
            var n = m(e);
            n != -1 && (N.splice(n, 1), t.triggerRedrawOverlay());
        }
        function m(e) {
            for (var t = 0; t < N.length; ++t) {
                var n = N[t];
                if (n.series == e) return t;
            }
            return -1;
        }
        function g(e, t) {
            function n(e) {
                if (e.angle <= 0 || isNaN(e.angle)) return;
                t.fillStyle = "rgba(255, 255, 255, " + r.series.pie.highlight.opacity + ")", t.beginPath(), Math.abs(e.angle - Math.PI * 2) > 1e-9 && t.moveTo(0, 0), t.arc(0, 0, i, e.startAngle, e.startAngle + e.angle / 2, !1), t.arc(0, 0, i, e.startAngle + e.angle / 2, e.startAngle + e.angle, !1), t.closePath(), t.fill();
            }
            var r = e.getOptions(), i = r.series.pie.radius > 1 ? r.series.pie.radius : w * r.series.pie.radius;
            t.save(), t.translate(E, S), t.scale(1, r.series.pie.tilt);
            for (var s = 0; s < N.length; ++s) n(N[s].series);
            a(t), t.restore();
        }
        var y = null, b = null, w = null, E = null, S = null, x = !1, T = null, N = [];
        t.hooks.processOptions.push(function(e, t) {
            t.series.pie.show && (t.grid.show = !1, t.series.pie.label.show == "auto" && (t.legend.show ? t.series.pie.label.show = !1 : t.series.pie.label.show = !0), t.series.pie.radius == "auto" && (t.series.pie.label.show ? t.series.pie.radius = .75 : t.series.pie.radius = 1), t.series.pie.tilt > 1 ? t.series.pie.tilt = 1 : t.series.pie.tilt < 0 && (t.series.pie.tilt = 0));
        }), t.hooks.bindEvents.push(function(e, t) {
            var n = e.getOptions();
            n.series.pie.show && (n.grid.hoverable && t.unbind("mousemove").mousemove(c), n.grid.clickable && t.unbind("click").click(h));
        }), t.hooks.processDatapoints.push(function(e, t, n, r) {
            var i = e.getOptions();
            i.series.pie.show && s(e, t, n, r);
        }), t.hooks.drawOverlay.push(function(e, t) {
            var n = e.getOptions();
            n.series.pie.show && g(e, t);
        }), t.hooks.draw.push(function(e, t) {
            var n = e.getOptions();
            n.series.pie.show && u(e, t);
        });
    }
    var n = 10, r = .95, i = {
        series: {
            pie: {
                show: !1,
                radius: "auto",
                innerRadius: 0,
                startAngle: 1.5,
                tilt: 1,
                shadow: {
                    left: 5,
                    top: 15,
                    alpha: .02
                },
                offset: {
                    top: 0,
                    left: "auto"
                },
                stroke: {
                    color: "#fff",
                    width: 1
                },
                label: {
                    show: "auto",
                    formatter: function(e, t) {
                        return "<div style='font-size:x-small;text-align:center;padding:2px;color:" + t.color + ";'>" + e + "<br/>" + Math.round(t.percent) + "%</div>";
                    },
                    radius: 1,
                    background: {
                        color: null,
                        opacity: 0
                    },
                    threshold: 0
                },
                combine: {
                    threshold: -1,
                    color: null,
                    label: "Other"
                },
                highlight: {
                    opacity: .5
                }
            }
        }
    };
    e.plot.plugins.push({
        init: t,
        options: i,
        name: "pie",
        version: "1.1"
    });
})(jQuery);
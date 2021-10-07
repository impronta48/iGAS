(function() {
    function n(e) {
        return e[0];
    }
    function r(e) {
        return e[1];
    }
    function i(e, t, n) {
        return n == "offset" ? function(n) {
            return "translate(0," + (n + (n < 0) - e) * t + ")";
        } : function(n) {
            return (n < 0 ? "scale(1,-1)" : "") + "translate(0," + (n - e) * t + ")";
        };
    }
    d3.horizon = function() {
        function d(n) {
            n.each(function(n, r) {
                var d = d3.select(this), v = 2 * s + 1, m = Infinity, g = -Infinity, b = -Infinity, E, S, T, N = n.map(function(e, t) {
                    var n = a.call(this, e, t), r = f.call(this, e, t);
                    n < m && (m = n);
                    n > g && (g = n);
                    -r > b && (b = -r);
                    r > b && (b = r);
                    return [ n, r ];
                }), C = d3.scale.linear().domain([ m, g ]).range([ 0, l ]), k = d3.scale.linear().domain([ 0, b ]).range([ 0, c * s ]), L = i(s, c, o);
                if (this.__chart__) {
                    E = this.__chart__.x;
                    S = this.__chart__.y;
                    t0 = this.__chart__.t;
                    T = this.__chart__.id;
                } else {
                    E = C.copy();
                    S = k.copy();
                    t0 = L;
                    T = ++t;
                }
                var A = d.selectAll("defs").data([ null ]);
                A.enter().append("defs").append("clipPath").attr("id", "d3_horizon_clip" + T).append("rect").attr("width", l).attr("height", c);
                A.select("rect").transition().duration(h).attr("width", l).attr("height", c);
                d.selectAll("g").data([ null ]).enter().append("g").attr("clip-path", "url(#d3_horizon_clip" + T + ")");
                var O = d.select("g").selectAll("path").data(d3.range(-1, -s - 1, -1).concat(d3.range(1, s + 1)), Number), M = e.interpolate(u).x(function(e) {
                    return E(e[0]);
                }).y0(c * s).y1(function(e) {
                    return c * s - S(e[1]);
                })(N), _ = e.x(function(e) {
                    return C(e[0]);
                }).y1(function(e) {
                    return c * s - k(e[1]);
                })(N);
                O.enter().append("path").style("fill", p).attr("transform", t0).attr("d", M);
                O.transition().duration(h).style("fill", p).attr("transform", L).attr("d", _);
                O.exit().transition().duration(h).attr("transform", L).attr("d", _).remove();
                this.__chart__ = {
                    x: C,
                    y: k,
                    t: L,
                    id: T
                };
            });
            d3.timer.flush();
        }
        var s = 1, o = "offset", u = "linear", a = n, f = r, l = 960, c = 40, h = 0, p = d3.scale.linear().domain([ -1, 0, 1 ]).range([ "#d62728", "#fff", "#1f77b4" ]);
        d.duration = function(e) {
            if (!arguments.length) return h;
            h = +e;
            return d;
        };
        d.bands = function(e) {
            if (!arguments.length) return s;
            s = +e;
            p.domain([ -s, 0, s ]);
            return d;
        };
        d.mode = function(e) {
            if (!arguments.length) return o;
            o = e + "";
            return d;
        };
        d.colors = function(e) {
            if (!arguments.length) return p.range();
            p.range(e);
            return d;
        };
        d.interpolate = function(e) {
            if (!arguments.length) return u;
            u = e + "";
            return d;
        };
        d.x = function(e) {
            if (!arguments.length) return a;
            a = e;
            return d;
        };
        d.y = function(e) {
            if (!arguments.length) return f;
            f = e;
            return d;
        };
        d.width = function(e) {
            if (!arguments.length) return l;
            l = +e;
            return d;
        };
        d.height = function(e) {
            if (!arguments.length) return c;
            c = +e;
            return d;
        };
        return d;
    };
    var e = d3.svg.area(), t = 0;
})();
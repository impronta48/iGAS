(function() {
    function e(t, n, r) {
        function i(e) {
            var i = t(e), s = i < r, o, u = d3.extent(t.range()), f = u[0], l = u[1], c = s ? r - f : l - r;
            c == 0 && (c = l - f);
            return (s ? -1 : 1) * c * (n + 1) / (n + c / Math.abs(i - r)) + r;
        }
        i.distortion = function(e) {
            if (!arguments.length) return n;
            n = +e;
            return i;
        };
        i.focus = function(e) {
            if (!arguments.length) return r;
            r = +e;
            return i;
        };
        i.copy = function() {
            return e(t.copy(), n, r);
        };
        i.nice = t.nice;
        i.ticks = t.ticks;
        i.tickFormat = t.tickFormat;
        return d3.rebind(i, t, "domain", "range");
    }
    d3.fisheye = {
        scale: function(t) {
            return e(t(), 3, 0);
        },
        circular: function() {
            function s(t) {
                var s = t.x - i[0], o = t.y - i[1], u = Math.sqrt(s * s + o * o);
                if (!u || u >= e) return {
                    x: t.x,
                    y: t.y,
                    z: 1
                };
                var a = n * (1 - Math.exp(-u * r)) / u * .75 + .25;
                return {
                    x: i[0] + s * a,
                    y: i[1] + o * a,
                    z: Math.min(a, 10)
                };
            }
            function o() {
                n = Math.exp(t);
                n = n / (n - 1) * e;
                r = t / e;
                return s;
            }
            var e = 200, t = 2, n, r, i = [ 0, 0 ];
            s.radius = function(t) {
                if (!arguments.length) return e;
                e = +t;
                return o();
            };
            s.distortion = function(e) {
                if (!arguments.length) return t;
                t = +e;
                return o();
            };
            s.focus = function(e) {
                if (!arguments.length) return i;
                i = e;
                return s;
            };
            return o();
        }
    };
})();
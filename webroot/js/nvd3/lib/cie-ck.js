(function(e) {
    function n(e, t, n) {
        return new r(e, t, n);
    }
    function r(e, t, n) {
        this.l = e;
        this.a = t;
        this.b = n;
    }
    function i(e, t, n) {
        return new s(e, t, n);
    }
    function s(e, t, n) {
        this.l = e;
        this.c = t;
        this.h = n;
    }
    function l(t, n, r) {
        var i = (t + 16) / 116, s = i + n / 500, o = i - r / 200;
        s = d(s) * u;
        i = d(i) * a;
        o = d(o) * f;
        return e.rgb(m(3.2404542 * s - 1.5371385 * i - .4985314 * o), m(-0.969266 * s + 1.8760108 * i + .041556 * o), m(.0556434 * s - .2040259 * i + 1.0572252 * o));
    }
    function c(e, t, r) {
        e = g(e);
        t = g(t);
        r = g(r);
        var i = v((.4124564 * e + .3575761 * t + .1804375 * r) / u), s = v((.2126729 * e + .7151522 * t + .072175 * r) / a), o = v((.0193339 * e + .119192 * t + .9503041 * r) / f);
        return n(116 * s - 16, 500 * (i - s), 200 * (s - o));
    }
    function h(e, t, n) {
        var r = Math.sqrt(t * t + n * n), s = Math.atan2(n, t) / Math.PI * 180;
        return i(e, r, s);
    }
    function p(e, t, r) {
        r = r * Math.PI / 180;
        return n(e, Math.cos(r) * t, Math.sin(r) * t);
    }
    function d(e) {
        return e > .206893034 ? e * e * e : (e - 4 / 29) / 7.787037;
    }
    function v(e) {
        return e > .008856 ? Math.pow(e, 1 / 3) : 7.787037 * e + 4 / 29;
    }
    function m(e) {
        return Math.round(255 * (e <= .00304 ? 12.92 * e : 1.055 * Math.pow(e, 1 / 2.4) - .055));
    }
    function g(e) {
        return (e /= 255) <= .04045 ? e / 12.92 : Math.pow((e + .055) / 1.055, 2.4);
    }
    var t = e.cie = {};
    t.lab = function(t, i, o) {
        return arguments.length === 1 ? t instanceof r ? n(t.l, t.a, t.b) : t instanceof s ? p(t.l, t.c, t.h) : c((t = e.rgb(t)).r, t.g, t.b) : n(+t, +i, +o);
    };
    t.lch = function(t, n, o) {
        return arguments.length === 1 ? t instanceof s ? i(t.l, t.c, t.h) : t instanceof r ? h(t.l, t.a, t.b) : h((t = c((t = e.rgb(t)).r, t.g, t.b)).l, t.a, t.b) : i(+t, +n, +o);
    };
    t.interpolateLab = function(e, n) {
        e = t.lab(e);
        n = t.lab(n);
        var r = e.l, i = e.a, s = e.b, o = n.l - r, u = n.a - i, a = n.b - s;
        return function(e) {
            return l(r + o * e, i + u * e, s + a * e) + "";
        };
    };
    t.interpolateLch = function(e, n) {
        e = t.lch(e);
        n = t.lch(n);
        var r = e.l, i = e.c, s = e.h, o = n.l - r, u = n.c - i, a = n.h - s;
        a > 180 ? a -= 360 : a < -180 && (a += 360);
        return function(e) {
            return p(r + o * e, i + u * e, s + a * e) + "";
        };
    };
    r.prototype.brighter = function(e) {
        return n(Math.min(100, this.l + o * (arguments.length ? e : 1)), this.a, this.b);
    };
    r.prototype.darker = function(e) {
        return n(Math.max(0, this.l - o * (arguments.length ? e : 1)), this.a, this.b);
    };
    r.prototype.rgb = function() {
        return l(this.l, this.a, this.b);
    };
    r.prototype.toString = function() {
        return this.rgb() + "";
    };
    s.prototype.brighter = function(e) {
        return i(Math.min(100, this.l + o * (arguments.length ? e : 1)), this.c, this.h);
    };
    s.prototype.darker = function(e) {
        return i(Math.max(0, this.l - o * (arguments.length ? e : 1)), this.c, this.h);
    };
    s.prototype.rgb = function() {
        return p(this.l, this.c, this.h).rgb();
    };
    s.prototype.toString = function() {
        return this.rgb() + "";
    };
    var o = 18, u = .95047, a = 1, f = 1.08883;
})(d3);
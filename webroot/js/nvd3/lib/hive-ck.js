d3.hive = {};

d3.hive.link = function() {
    function o(n, r) {
        var i = u(e, this, n, r), s = u(t, this, n, r), o;
        s.a < i.a && (o = s, s = i, i = o);
        s.a - i.a > Math.PI && (i.a += 2 * Math.PI);
        var a = i.a + (s.a - i.a) / 3, f = s.a - (s.a - i.a) / 3;
        return i.r0 - i.r1 || s.r0 - s.r1 ? "M" + Math.cos(i.a) * i.r0 + "," + Math.sin(i.a) * i.r0 + "L" + Math.cos(i.a) * i.r1 + "," + Math.sin(i.a) * i.r1 + "C" + Math.cos(a) * i.r1 + "," + Math.sin(a) * i.r1 + " " + Math.cos(f) * s.r1 + "," + Math.sin(f) * s.r1 + " " + Math.cos(s.a) * s.r1 + "," + Math.sin(s.a) * s.r1 + "L" + Math.cos(s.a) * s.r0 + "," + Math.sin(s.a) * s.r0 + "C" + Math.cos(f) * s.r0 + "," + Math.sin(f) * s.r0 + " " + Math.cos(a) * i.r0 + "," + Math.sin(a) * i.r0 + " " + Math.cos(i.a) * i.r0 + "," + Math.sin(i.a) * i.r0 : "M" + Math.cos(i.a) * i.r0 + "," + Math.sin(i.a) * i.r0 + "C" + Math.cos(a) * i.r1 + "," + Math.sin(a) * i.r1 + " " + Math.cos(f) * s.r1 + "," + Math.sin(f) * s.r1 + " " + Math.cos(s.a) * s.r1 + "," + Math.sin(s.a) * s.r1;
    }
    function u(e, t, o, u) {
        var a = e.call(t, o, u), f = +(typeof n == "function" ? n.call(t, a, u) : n) + s, l = +(typeof r == "function" ? r.call(t, a, u) : r), c = r === i ? l : +(typeof i == "function" ? i.call(t, a, u) : i);
        return {
            r0: l,
            r1: c,
            a: f
        };
    }
    var e = function(e) {
        return e.source;
    }, t = function(e) {
        return e.target;
    }, n = function(e) {
        return e.angle;
    }, r = function(e) {
        return e.radius;
    }, i = r, s = -Math.PI / 2;
    o.source = function(t) {
        if (!arguments.length) return e;
        e = t;
        return o;
    };
    o.target = function(e) {
        if (!arguments.length) return t;
        t = e;
        return o;
    };
    o.angle = function(e) {
        if (!arguments.length) return n;
        n = e;
        return o;
    };
    o.radius = function(e) {
        if (!arguments.length) return r;
        r = i = e;
        return o;
    };
    o.startRadius = function(e) {
        if (!arguments.length) return r;
        r = e;
        return o;
    };
    o.endRadius = function(e) {
        if (!arguments.length) return i;
        i = e;
        return o;
    };
    return o;
};
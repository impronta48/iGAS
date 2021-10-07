d3.sankey = function() {
    function o() {
        i.forEach(function(e) {
            e.sourceLinks = [];
            e.targetLinks = [];
        });
        s.forEach(function(e) {
            var t = e.source, n = e.target;
            typeof t == "number" && (t = e.source = i[e.source]);
            typeof n == "number" && (n = e.target = i[e.target]);
            t.sourceLinks.push(e);
            n.targetLinks.push(e);
        });
    }
    function u() {
        i.forEach(function(e) {
            e.value = Math.max(d3.sum(e.sourceLinks, v), d3.sum(e.targetLinks, v));
        });
    }
    function a() {
        var e = i, n, s = 0;
        while (e.length) {
            n = [];
            e.forEach(function(e) {
                e.x = s;
                e.dx = t;
                e.sourceLinks.forEach(function(e) {
                    n.push(e.target);
                });
            });
            e = n;
            ++s;
        }
        l(s);
        c((r[0] - t) / (s - 1));
    }
    function f() {
        i.forEach(function(e) {
            e.targetLinks.length || (e.x = d3.min(e.sourceLinks, function(e) {
                return e.target.x;
            }) - 1);
        });
    }
    function l(e) {
        i.forEach(function(t) {
            t.sourceLinks.length || (t.x = e - 1);
        });
    }
    function c(e) {
        i.forEach(function(t) {
            t.x *= e;
        });
    }
    function h(e) {
        function u() {
            var e = d3.min(t, function(e) {
                return (r[1] - (e.length - 1) * n) / d3.sum(e, v);
            });
            t.forEach(function(t) {
                t.forEach(function(t, n) {
                    t.y = n;
                    t.dy = t.value * e;
                });
            });
            s.forEach(function(t) {
                t.dy = t.value * e;
            });
        }
        function a(e) {
            function n(e) {
                return d(e.source) * e.value;
            }
            t.forEach(function(t, r) {
                t.forEach(function(t) {
                    if (t.targetLinks.length) {
                        var r = d3.sum(t.targetLinks, n) / d3.sum(t.targetLinks, v);
                        t.y += (r - d(t)) * e;
                    }
                });
            });
        }
        function f(e) {
            function n(e) {
                return d(e.target) * e.value;
            }
            t.slice().reverse().forEach(function(t) {
                t.forEach(function(t) {
                    if (t.sourceLinks.length) {
                        var r = d3.sum(t.sourceLinks, n) / d3.sum(t.sourceLinks, v);
                        t.y += (r - d(t)) * e;
                    }
                });
            });
        }
        function l() {
            t.forEach(function(e) {
                var t, i, s = 0, o = e.length, u;
                e.sort(c);
                for (u = 0; u < o; ++u) {
                    t = e[u];
                    i = s - t.y;
                    i > 0 && (t.y += i);
                    s = t.y + t.dy + n;
                }
                i = s - n - r[1];
                if (i > 0) {
                    s = t.y -= i;
                    for (u = o - 2; u >= 0; --u) {
                        t = e[u];
                        i = t.y + t.dy + n - s;
                        i > 0 && (t.y -= i);
                        s = t.y;
                    }
                }
            });
        }
        function c(e, t) {
            return e.y - t.y;
        }
        var t = d3.nest().key(function(e) {
            return e.x;
        }).sortKeys(d3.ascending).entries(i).map(function(e) {
            return e.values;
        });
        u();
        l();
        for (var o = 1; e > 0; --e) {
            f(o *= .99);
            l();
            a(o);
            l();
        }
    }
    function p() {
        function e(e, t) {
            return e.source.y - t.source.y;
        }
        function t(e, t) {
            return e.target.y - t.target.y;
        }
        i.forEach(function(n) {
            n.sourceLinks.sort(t);
            n.targetLinks.sort(e);
        });
        i.forEach(function(e) {
            var t = 0, n = 0;
            e.sourceLinks.forEach(function(e) {
                e.sy = t;
                t += e.dy;
            });
            e.targetLinks.forEach(function(e) {
                e.ty = n;
                n += e.dy;
            });
        });
    }
    function d(e) {
        return e.y + e.dy / 2;
    }
    function v(e) {
        return e.value;
    }
    var e = {}, t = 24, n = 8, r = [ 1, 1 ], i = [], s = [];
    e.nodeWidth = function(n) {
        if (!arguments.length) return t;
        t = +n;
        return e;
    };
    e.nodePadding = function(t) {
        if (!arguments.length) return n;
        n = +t;
        return e;
    };
    e.nodes = function(t) {
        if (!arguments.length) return i;
        i = t;
        return e;
    };
    e.links = function(t) {
        if (!arguments.length) return s;
        s = t;
        return e;
    };
    e.size = function(t) {
        if (!arguments.length) return r;
        r = t;
        return e;
    };
    e.layout = function(t) {
        o();
        u();
        a();
        h(t);
        p();
        return e;
    };
    e.relayout = function() {
        p();
        return e;
    };
    e.link = function() {
        function t(t) {
            var n = t.source.x + t.source.dx, r = t.target.x, i = d3.interpolateNumber(n, r), s = i(e), o = i(1 - e), u = t.source.y + t.sy + t.dy / 2, a = t.target.y + t.ty + t.dy / 2;
            return "M" + n + "," + u + "C" + s + "," + u + " " + o + "," + a + " " + r + "," + a;
        }
        var e = .5;
        t.curvature = function(n) {
            if (!arguments.length) return e;
            e = +n;
            return t;
        };
        return t;
    };
    return e;
};
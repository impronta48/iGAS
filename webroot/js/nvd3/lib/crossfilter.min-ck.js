(function(e) {
    function t(e) {
        return e;
    }
    function n(e, t) {
        for (var n = 0, r = t.length, i = new Array(r); n < r; ++n) i[n] = e[t[n]];
        return i;
    }
    function r(e) {
        function t(t, n, r, i) {
            while (r < i) {
                var s = r + i >> 1;
                e(t[s]) < n ? r = s + 1 : i = s;
            }
            return r;
        }
        function n(t, n, r, i) {
            while (r < i) {
                var s = r + i >> 1;
                n < e(t[s]) ? i = s : r = s + 1;
            }
            return r;
        }
        return n.right = n, n.left = t, n;
    }
    function i(e) {
        function t(e, t, n) {
            var i = n - t, s = (i >>> 1) + 1;
            while (--s > 0) r(e, s, i, t);
            return e;
        }
        function n(e, t, n) {
            var i = n - t, s;
            while (--i > 0) s = e[t], e[t] = e[t + i], e[t + i] = s, r(e, 1, i, t);
            return e;
        }
        function r(t, n, r, i) {
            var s = t[--i + n], o = e(s), u;
            while ((u = n << 1) <= r) {
                u < r && e(t[i + u]) > e(t[i + u + 1]) && u++;
                if (o <= e(t[i + u])) break;
                t[i + n] = t[i + u], n = u;
            }
            t[i + n] = s;
        }
        return t.sort = n, t;
    }
    function s(e) {
        function t(t, r, i, s) {
            var o = new Array(s = Math.min(i - r, s)), u, a, f, l;
            for (a = 0; a < s; ++a) o[a] = t[r++];
            n(o, 0, s);
            if (r < i) {
                u = e(o[0]);
                do if (f = e(l = t[r]) > u) o[0] = l, u = e(n(o, 0, s)[0]); while (++r < i);
            }
            return o;
        }
        var n = i(e);
        return t;
    }
    function o(e) {
        function t(t, n, r) {
            for (var i = n + 1; i < r; ++i) {
                for (var s = i, o = t[i], u = e(o); s > n && e(t[s - 1]) > u; --s) t[s] = t[s - 1];
                t[s] = o;
            }
            return t;
        }
        return t;
    }
    function u(e) {
        function t(e, t, i) {
            return (i - t < k ? r : n)(e, t, i);
        }
        function n(n, r, i) {
            var s = (i - r) / 6 | 0, o = r + s, u = i - 1 - s, a = r + i - 1 >> 1, f = a - s, l = a + s, c = n[o], h = e(c), p = n[f], d = e(p), v = n[a], m = e(v), g = n[l], y = e(g), b = n[u], w = e(b), E;
            h > d && (E = c, c = p, p = E, E = h, h = d, d = E), y > w && (E = g, g = b, b = E, E = y, y = w, w = E), h > m && (E = c, c = v, v = E, E = h, h = m, m = E), d > m && (E = p, p = v, v = E, E = d, d = m, m = E), h > y && (E = c, c = g, g = E, E = h, h = y, y = E), m > y && (E = v, v = g, g = E, E = m, m = y, y = E), d > w && (E = p, p = b, b = E, E = d, d = w, w = E), d > m && (E = p, p = v, v = E, E = d, d = m, m = E), y > w && (E = g, g = b, b = E, E = y, y = w, w = E);
            var S = p, x = d, T = g, N = y;
            n[o] = c, n[f] = n[r], n[a] = v, n[l] = n[i - 1], n[u] = b;
            var C = r + 1, k = i - 2, L = x <= N && x >= N;
            if (L) for (var A = C; A <= k; ++A) {
                var O = n[A], M = e(O);
                if (M < x) A !== C && (n[A] = n[C], n[C] = O), ++C; else if (M > x) for (;;) {
                    var _ = e(n[k]);
                    if (_ > x) {
                        k--;
                        continue;
                    }
                    if (_ < x) {
                        n[A] = n[C], n[C++] = n[k], n[k--] = O;
                        break;
                    }
                    n[A] = n[k], n[k--] = O;
                    break;
                }
            } else for (var A = C; A <= k; A++) {
                var O = n[A], M = e(O);
                if (M < x) A !== C && (n[A] = n[C], n[C] = O), ++C; else if (M > N) for (;;) {
                    var _ = e(n[k]);
                    if (_ > N) {
                        k--;
                        if (k < A) break;
                        continue;
                    }
                    _ < x ? (n[A] = n[C], n[C++] = n[k], n[k--] = O) : (n[A] = n[k], n[k--] = O);
                    break;
                }
            }
            n[r] = n[C - 1], n[C - 1] = S, n[i - 1] = n[k + 1], n[k + 1] = T, t(n, r, C - 1), t(n, k + 2, i);
            if (L) return n;
            if (C < o && k > u) {
                var D, _;
                while ((D = e(n[C])) <= x && D >= x) ++C;
                while ((_ = e(n[k])) <= N && _ >= N) --k;
                for (var A = C; A <= k; A++) {
                    var O = n[A], M = e(O);
                    if (M <= x && M >= x) A !== C && (n[A] = n[C], n[C] = O), C++; else if (M <= N && M >= N) for (;;) {
                        var _ = e(n[k]);
                        if (_ <= N && _ >= N) {
                            k--;
                            if (k < A) break;
                            continue;
                        }
                        _ < x ? (n[A] = n[C], n[C++] = n[k], n[k--] = O) : (n[A] = n[k], n[k--] = O);
                        break;
                    }
                }
            }
            return t(n, C, k + 1);
        }
        var r = o(e);
        return t;
    }
    function a(e) {
        return new Array(e);
    }
    function f(e, t) {
        return function(n) {
            var r = n.length;
            return [ e.left(n, t, 0, r), e.right(n, t, 0, r) ];
        };
    }
    function l(e, t) {
        var n = t[0], r = t[1];
        return function(t) {
            var i = t.length;
            return [ e.left(t, n, 0, i), e.left(t, r, 0, i) ];
        };
    }
    function c(e) {
        return [ 0, e.length ];
    }
    function h() {
        return null;
    }
    function p() {
        return 0;
    }
    function d(e) {
        return e + 1;
    }
    function v(e) {
        return e - 1;
    }
    function m(e) {
        return function(t, n) {
            return t + +e(n);
        };
    }
    function g(e) {
        return function(t, n) {
            return t - e(n);
        };
    }
    function y() {
        function e(e) {
            var t = T, n = e.length;
            return n && (x = x.concat(e), k = M(k, T += n), O.forEach(function(r) {
                r(e, t, n);
            })), y;
        }
        function r(e) {
            function r(t, r, i) {
                $ = t.map(e), J = K(w(i), 0, i), $ = n($, J);
                var s = Q($), o = s[0], u = s[1], a;
                for (a = 0; a < o; ++a) k[J[a] + r] |= U;
                for (a = u; a < i; ++a) k[J[a] + r] |= U;
                if (!r) {
                    X = $, V = J, Z = o, et = u;
                    return;
                }
                var f = X, l = V, c = 0, h = 0;
                X = new Array(T), V = b(T, T);
                for (a = 0; c < r && h < i; ++a) f[c] < $[h] ? (X[a] = f[c], V[a] = l[c++]) : (X[a] = $[h], V[a] = J[h++] + r);
                for (; c < r; ++c, ++a) X[a] = f[c], V[a] = l[c];
                for (; h < i; ++h, ++a) X[a] = $[h], V[a] = J[h] + r;
                s = Q(X), Z = s[0], et = s[1];
            }
            function o(e, t, n) {
                Y.forEach(function(e) {
                    e($, J, t, n);
                }), $ = J = null;
            }
            function a(e) {
                var t, n, r, i = e[0], s = e[1], o = [], u = [];
                if (i < Z) for (t = i, n = Math.min(Z, s); t < n; ++t) k[r = V[t]] ^= U, o.push(r); else if (i > Z) for (t = Z, n = Math.min(i, et); t < n; ++t) k[r = V[t]] ^= U, u.push(r);
                if (s > et) for (t = Math.max(i, et), n = s; t < n; ++t) k[r = V[t]] ^= U, o.push(r); else if (s < et) for (t = Math.max(Z, s), n = et; t < n; ++t) k[r = V[t]] ^= U, u.push(r);
                return Z = i, et = s, A.forEach(function(e) {
                    e(U, o, u);
                }), R;
            }
            function y(e) {
                return e == null ? P() : Array.isArray(e) ? D(e) : L(e);
            }
            function L(e) {
                return a((Q = f(S, e))(X));
            }
            function D(e) {
                return a((Q = l(S, e))(X));
            }
            function P() {
                return a((Q = c)(X));
            }
            function H(e) {
                var t = [], n = et, r;
                while (--n >= Z && e > 0) k[r = V[n]] || (t.push(x[r]), --e);
                return t;
            }
            function I(e) {
                function n(t, n, i, s) {
                    function f() {
                        ++j === H && (c = _(c, P <<= 1), D = _(D, P), H = E(P));
                    }
                    var l = O, c = b(j, H), p = q, d = $, v = j, m = 0, g = 0, y, w, S, N, C, L;
                    Q && (p = d = h), O = new Array(j), j = 0, D = v > 1 ? M(D, T) : b(T, H), v && (S = (w = l[0]).key);
                    while (g < s && !((N = e(t[g])) >= N)) ++g;
                    while (g < s) {
                        if (w && S <= N) {
                            C = w, L = S, c[m] = j;
                            if (w = l[++m]) S = w.key;
                        } else C = {
                            key: N,
                            value: d()
                        }, L = N;
                        O[j] = C;
                        while (!(N > L)) {
                            D[y = n[g] + i] = j, k[y] & W || (C.value = p(C.value, x[y]));
                            if (++g >= s) break;
                            N = e(t[g]);
                        }
                        f();
                    }
                    while (m < v) O[c[m] = j] = l[m++], f();
                    if (j > m) for (m = 0; m < i; ++m) D[m] = c[D[m]];
                    y = A.indexOf(J), j > 1 ? (J = r, K = u) : (j === 1 ? (J = o, K = a) : (J = h, K = h), D = null), A[y] = J;
                }
                function r(e, t, n) {
                    if (e === U || Q) return;
                    var r, i, s, o;
                    for (r = 0, s = t.length; r < s; ++r) k[i = t[r]] & W || (o = O[D[i]], o.value = q(o.value, x[i]));
                    for (r = 0, s = n.length; r < s; ++r) (k[i = n[r]] & W) === e && (o = O[D[i]], o.value = R(o.value, x[i]));
                }
                function o(e, t, n) {
                    if (e === U || Q) return;
                    var r, i, s, o = O[0];
                    for (r = 0, s = t.length; r < s; ++r) k[i = t[r]] & W || (o.value = q(o.value, x[i]));
                    for (r = 0, s = n.length; r < s; ++r) (k[i = n[r]] & W) === e && (o.value = R(o.value, x[i]));
                }
                function u() {
                    var e, t;
                    for (e = 0; e < j; ++e) O[e].value = $();
                    for (e = 0; e < T; ++e) k[e] & W || (t = O[D[e]], t.value = q(t.value, x[e]));
                }
                function a() {
                    var e, t = O[0];
                    t.value = $();
                    for (e = 0; e < T; ++e) k[e] & W || (t.value = q(t.value, x[e]));
                }
                function f() {
                    return Q && (K(), Q = !1), O;
                }
                function l(e) {
                    var t = F(f(), 0, O.length, e);
                    return I.sort(t, 0, t.length);
                }
                function c(e, t, n) {
                    return q = e, R = t, $ = n, Q = !0, L;
                }
                function y() {
                    return c(d, v, p);
                }
                function w(e) {
                    return c(m(e), g(e), p);
                }
                function S(e) {
                    function t(t) {
                        return e(t.value);
                    }
                    return F = s(t), I = i(t), L;
                }
                function N() {
                    return S(t);
                }
                function C() {
                    return j;
                }
                var L = {
                    top: l,
                    all: f,
                    reduce: c,
                    reduceCount: y,
                    reduceSum: w,
                    order: S,
                    orderNatural: N,
                    size: C
                }, O, D, P = 8, H = E(P), j = 0, F, I, q, R, $, J = h, K = h, Q = !0;
                return arguments.length < 1 && (e = t), A.push(J), Y.push(n), n(X, V, 0, T), y().orderNatural();
            }
            function q() {
                var e = I(h), t = e.all;
                return delete e.all, delete e.top, delete e.order, delete e.orderNatural, delete e.size, e.value = function() {
                    return t()[0].value;
                }, e;
            }
            var R = {
                filter: y,
                filterExact: L,
                filterRange: D,
                filterAll: P,
                top: H,
                group: I,
                groupAll: q
            }, U = 1 << N++, W = ~U, X, V, $, J, K = u(function(e) {
                return $[e];
            }), Q = c, Y = [], Z = 0, et = 0;
            return O.unshift(r), O.push(o), N > C && (k = _(k, C <<= 1)), r(x, 0, T), o(x, 0, T), R;
        }
        function o() {
            function e(e, t, n) {
                var r;
                if (h) return;
                for (r = t; r < T; ++r) k[r] || (a = f(a, x[r]));
            }
            function t(e, t, n) {
                var r, i, s;
                if (h) return;
                for (r = 0, s = t.length; r < s; ++r) k[i = t[r]] || (a = f(a, x[i]));
                for (r = 0, s = n.length; r < s; ++r) k[i = n[r]] === e && (a = l(a, x[i]));
            }
            function n() {
                var e;
                a = c();
                for (e = 0; e < T; ++e) k[e] || (a = f(a, x[e]));
            }
            function r(e, t, n) {
                return f = e, l = t, c = n, h = !0, u;
            }
            function i() {
                return r(d, v, p);
            }
            function s(e) {
                return r(m(e), g(e), p);
            }
            function o() {
                return h && (n(), h = !1), a;
            }
            var u = {
                reduce: r,
                reduceCount: i,
                reduceSum: s,
                value: o
            }, a, f, l, c, h = !0;
            return A.push(t), O.push(e), e(x, 0, T), i();
        }
        function a() {
            return T;
        }
        var y = {
            add: e,
            dimension: r,
            groupAll: o,
            size: a
        }, x = [], T = 0, N = 0, C = 8, k = L(0), A = [], O = [];
        return arguments.length ? e(arguments[0]) : y;
    }
    function b(e, t) {
        return (t < 257 ? L : t < 65537 ? A : O)(e);
    }
    function w(e) {
        var t = b(e, e);
        for (var n = -1; ++n < e; ) t[n] = n;
        return t;
    }
    function E(e) {
        return e === 8 ? 256 : e === 16 ? 65536 : 4294967296;
    }
    y.version = "1.0.3", y.permute = n;
    var S = y.bisect = r(t);
    S.by = r;
    var x = y.heap = i(t);
    x.by = i;
    var T = y.heapselect = s(t);
    T.by = s;
    var N = y.insertionsort = o(t);
    N.by = o;
    var C = y.quicksort = u(t);
    C.by = u;
    var k = 32, L = a, A = a, O = a, M = t, _ = t;
    typeof Uint8Array != "undefined" && (L = function(e) {
        return new Uint8Array(e);
    }, A = function(e) {
        return new Uint16Array(e);
    }, O = function(e) {
        return new Uint32Array(e);
    }, M = function(e, t) {
        var n = new e.constructor(t);
        return n.set(e), n;
    }, _ = function(e, t) {
        var n;
        switch (t) {
          case 16:
            n = A(e.length);
            break;
          case 32:
            n = O(e.length);
            break;
          default:
            throw new Error("invalid array width!");
        }
        return n.set(e), n;
    }), e.crossfilter = y;
})(this);
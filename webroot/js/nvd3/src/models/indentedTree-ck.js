nv.models.indentedTree = function() {
    "use strict";
    function m(e) {
        e.each(function(e) {
            function k(e, t, n) {
                d3.event.stopPropagation();
                if (d3.event.shiftKey && !n) {
                    d3.event.shiftKey = !1;
                    e.values && e.values.forEach(function(e) {
                        (e.values || e._values) && k(e, 0, !0);
                    });
                    return !0;
                }
                if (!O(e)) return !0;
                if (e.values) {
                    e._values = e.values;
                    e.values = null;
                } else {
                    e.values = e._values;
                    e._values = null;
                }
                m.update();
            }
            function L(e) {
                return e._values && e._values.length ? c : e.values && e.values.length ? h : "";
            }
            function A(e) {
                return e._values && e._values.length;
            }
            function O(e) {
                var t = e.values || e._values;
                return t && t.length;
            }
            var t = 1, r = d3.select(this), i = d3.layout.tree().children(function(e) {
                return e.values;
            }).size([ n, a ]);
            m.update = function() {
                r.transition().duration(600).call(m);
            };
            e[0] || (e[0] = {
                key: u
            });
            var g = i.nodes(e[0]), y = d3.select(this).selectAll("div").data([ [ g ] ]), b = y.enter().append("div").attr("class", "nvd3 nv-wrap nv-indentedtree"), w = b.append("table"), E = y.select("table").attr("width", "100%").attr("class", l);
            if (s) {
                var S = w.append("thead"), x = S.append("tr");
                f.forEach(function(e) {
                    x.append("th").attr("width", e.width ? e.width : "10%").style("text-align", e.type == "numeric" ? "right" : "left").append("span").text(e.label);
                });
            }
            var T = E.selectAll("tbody").data(function(e) {
                return e;
            });
            T.enter().append("tbody");
            t = d3.max(g, function(e) {
                return e.depth;
            });
            i.size([ n, t * a ]);
            var N = T.selectAll("tr").data(function(e) {
                return e.filter(function(e) {
                    return o && !e.children ? o(e) : !0;
                });
            }, function(e, t) {
                return e.id || e.id || ++v;
            });
            N.exit().remove();
            N.select("img.nv-treeicon").attr("src", L).classed("folded", A);
            var C = N.enter().append("tr");
            f.forEach(function(e, t) {
                var n = C.append("td").style("padding-left", function(e) {
                    return (t ? 0 : e.depth * a + 12 + (L(e) ? 0 : 16)) + "px";
                }, "important").style("text-align", e.type == "numeric" ? "right" : "left");
                t == 0 && n.append("img").classed("nv-treeicon", !0).classed("nv-folded", A).attr("src", L).style("width", "14px").style("height", "14px").style("padding", "0 1px").style("display", function(e) {
                    return L(e) ? "inline-block" : "none";
                }).on("click", k);
                n.each(function(n) {
                    !t && d(n) ? d3.select(this).append("a").attr("href", d).attr("class", d3.functor(e.classes)).append("span") : d3.select(this).append("span");
                    d3.select(this).select("span").attr("class", d3.functor(e.classes)).text(function(t) {
                        return e.format ? e.format(t) : t[e.key] || "-";
                    });
                });
                if (e.showCount) {
                    n.append("span").attr("class", "nv-childrenCount");
                    N.selectAll("span.nv-childrenCount").text(function(e) {
                        return e.values && e.values.length || e._values && e._values.length ? "(" + (e.values && e.values.filter(function(e) {
                            return o ? o(e) : !0;
                        }).length || e._values && e._values.filter(function(e) {
                            return o ? o(e) : !0;
                        }).length || 0) + ")" : "";
                    });
                }
            });
            N.order().on("click", function(e) {
                p.elementClick({
                    row: this,
                    data: e,
                    pos: [ e.x, e.y ]
                });
            }).on("dblclick", function(e) {
                p.elementDblclick({
                    row: this,
                    data: e,
                    pos: [ e.x, e.y ]
                });
            }).on("mouseover", function(e) {
                p.elementMouseover({
                    row: this,
                    data: e,
                    pos: [ e.x, e.y ]
                });
            }).on("mouseout", function(e) {
                p.elementMouseout({
                    row: this,
                    data: e,
                    pos: [ e.x, e.y ]
                });
            });
        });
        return m;
    }
    var e = {
        top: 0,
        right: 0,
        bottom: 0,
        left: 0
    }, t = 960, n = 500, r = nv.utils.defaultColor(), i = Math.floor(Math.random() * 1e4), s = !0, o = !1, u = "No Data Available.", a = 20, f = [ {
        key: "key",
        label: "Name",
        type: "text"
    } ], l = null, c = "images/grey-plus.png", h = "images/grey-minus.png", p = d3.dispatch("elementClick", "elementDblclick", "elementMouseover", "elementMouseout"), d = function(e) {
        return e.url;
    }, v = 0;
    m.options = nv.utils.optionsFunc.bind(m);
    m.margin = function(t) {
        if (!arguments.length) return e;
        e.top = typeof t.top != "undefined" ? t.top : e.top;
        e.right = typeof t.right != "undefined" ? t.right : e.right;
        e.bottom = typeof t.bottom != "undefined" ? t.bottom : e.bottom;
        e.left = typeof t.left != "undefined" ? t.left : e.left;
        return m;
    };
    m.width = function(e) {
        if (!arguments.length) return t;
        t = e;
        return m;
    };
    m.height = function(e) {
        if (!arguments.length) return n;
        n = e;
        return m;
    };
    m.color = function(e) {
        if (!arguments.length) return r;
        r = nv.utils.getColor(e);
        scatter.color(r);
        return m;
    };
    m.id = function(e) {
        if (!arguments.length) return i;
        i = e;
        return m;
    };
    m.header = function(e) {
        if (!arguments.length) return s;
        s = e;
        return m;
    };
    m.noData = function(e) {
        if (!arguments.length) return u;
        u = e;
        return m;
    };
    m.filterZero = function(e) {
        if (!arguments.length) return o;
        o = e;
        return m;
    };
    m.columns = function(e) {
        if (!arguments.length) return f;
        f = e;
        return m;
    };
    m.tableClass = function(e) {
        if (!arguments.length) return l;
        l = e;
        return m;
    };
    m.iconOpen = function(e) {
        if (!arguments.length) return c;
        c = e;
        return m;
    };
    m.iconClose = function(e) {
        if (!arguments.length) return h;
        h = e;
        return m;
    };
    m.getUrl = function(e) {
        if (!arguments.length) return d;
        d = e;
        return m;
    };
    return m;
};
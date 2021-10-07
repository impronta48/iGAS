nv.utils.windowSize = function() {
    var e = {
        width: 640,
        height: 480
    };
    if (document.body && document.body.offsetWidth) {
        e.width = document.body.offsetWidth;
        e.height = document.body.offsetHeight;
    }
    if (document.compatMode == "CSS1Compat" && document.documentElement && document.documentElement.offsetWidth) {
        e.width = document.documentElement.offsetWidth;
        e.height = document.documentElement.offsetHeight;
    }
    if (window.innerWidth && window.innerHeight) {
        e.width = window.innerWidth;
        e.height = window.innerHeight;
    }
    return e;
};

nv.utils.windowResize = function(e) {
    if (e === undefined) return;
    var t = window.onresize;
    window.onresize = function(n) {
        typeof t == "function" && t(n);
        e(n);
    };
};

nv.utils.getColor = function(e) {
    return arguments.length ? Object.prototype.toString.call(e) === "[object Array]" ? function(t, n) {
        return t.color || e[n % e.length];
    } : e : nv.utils.defaultColor();
};

nv.utils.defaultColor = function() {
    var e = d3.scale.category20().range();
    return function(t, n) {
        return t.color || e[n % e.length];
    };
};

nv.utils.customTheme = function(e, t, n) {
    t = t || function(e) {
        return e.key;
    };
    n = n || d3.scale.category20().range();
    var r = n.length;
    return function(i, s) {
        var o = t(i);
        r || (r = n.length);
        return typeof e[o] != "undefined" ? typeof e[o] == "function" ? e[o]() : e[o] : n[--r];
    };
};

nv.utils.pjax = function(e, t) {
    function n(n) {
        d3.html(n, function(n) {
            var r = d3.select(t).node();
            r.parentNode.replaceChild(d3.select(n).select(t).node(), r);
            nv.utils.pjax(e, t);
        });
    }
    d3.selectAll(e).on("click", function() {
        history.pushState(this.href, this.textContent, this.href);
        n(this.href);
        d3.event.preventDefault();
    });
    d3.select(window).on("popstate", function() {
        d3.event.state && n(d3.event.state);
    });
};

nv.utils.calcApproxTextWidth = function(e) {
    if (e instanceof d3.selection) {
        var t = parseInt(e.style("font-size").replace("px", "")), n = e.text().length;
        return n * t * .5;
    }
    return 0;
};

nv.utils.NaNtoZero = function(e) {
    return typeof e != "number" || isNaN(e) || e === null || e === Infinity ? 0 : e;
};

nv.utils.optionsFunc = function(e) {
    e && d3.map(e).forEach(function(e, t) {
        typeof this[e] == "function" && this[e](t);
    }.bind(this));
    return this;
};
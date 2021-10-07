function daysInMonth(e, t) {
    return (new Date(t, e + 1, 0)).getDate();
}

function d3_time_range(e, t, n) {
    return function(r, i, s) {
        var o = e(r), u = [];
        o < r && t(o);
        if (s > 1) while (o < i) {
            var a = new Date(+o);
            n(a) % s === 0 && u.push(a);
            t(o);
        } else while (o < i) {
            u.push(new Date(+o));
            t(o);
        }
        return u;
    };
}

var nv = window.nv || {};

nv.version = "1.1.10b";

nv.dev = !0;

window.nv = nv;

nv.tooltip = {};

nv.utils = {};

nv.models = {};

nv.charts = {};

nv.graphs = [];

nv.logs = {};

nv.dispatch = d3.dispatch("render_start", "render_end");

if (nv.dev) {
    nv.dispatch.on("render_start", function(e) {
        nv.logs.startTime = +(new Date);
    });
    nv.dispatch.on("render_end", function(e) {
        nv.logs.endTime = +(new Date);
        nv.logs.totalTime = nv.logs.endTime - nv.logs.startTime;
        nv.log("total", nv.logs.totalTime);
    });
}

nv.log = function() {
    if (nv.dev && console.log && console.log.apply) console.log.apply(console, arguments); else if (nv.dev && typeof console.log == "function" && Function.prototype.bind) {
        var e = Function.prototype.bind.call(console.log, console);
        e.apply(console, arguments);
    }
    return arguments[arguments.length - 1];
};

nv.render = function(t) {
    t = t || 1;
    nv.render.active = !0;
    nv.dispatch.render_start();
    setTimeout(function() {
        var e, n;
        for (var r = 0; r < t && (n = nv.render.queue[r]); r++) {
            e = n.generate();
            typeof n.callback == typeof Function && n.callback(e);
            nv.graphs.push(e);
        }
        nv.render.queue.splice(0, r);
        if (nv.render.queue.length) setTimeout(arguments.callee, 0); else {
            nv.render.active = !1;
            nv.dispatch.render_end();
        }
    }, 0);
};

nv.render.active = !1;

nv.render.queue = [];

nv.addGraph = function(e) {
    typeof arguments[0] == typeof Function && (e = {
        generate: arguments[0],
        callback: arguments[1]
    });
    nv.render.queue.push(e);
    nv.render.active || nv.render();
};

nv.identity = function(e) {
    return e;
};

nv.strip = function(e) {
    return e.replace(/(\s|&)/g, "");
};

d3.time.monthEnd = function(e) {
    return new Date(e.getFullYear(), e.getMonth(), 0);
};

d3.time.monthEnds = d3_time_range(d3.time.monthEnd, function(e) {
    e.setUTCDate(e.getUTCDate() + 1);
    e.setDate(daysInMonth(e.getMonth() + 1, e.getFullYear()));
}, function(e) {
    return e.getMonth();
});
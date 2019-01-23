/* Flot plugin for automatically redrawing plots as the placeholder resizes.

Copyright (c) 2007-2013 IOLA and Ole Laursen.
Licensed under the MIT license.

It works by listening for changes on the placeholder div (through the jQuery
resize event plugin) - if the size changes, it will redraw the plot.

There are no options. If you need to disable the plugin for some plots, you
can just fix the size of their placeholders.

*//* Inline dependency:
 * jQuery resize event - v1.1 - 3/14/2010
 * http://benalman.com/projects/jquery-resize-plugin/
 *
 * Copyright (c) 2010 "Cowboy" Ben Alman
 * Dual licensed under the MIT and GPL licenses.
 * http://benalman.com/about/license/
 */(function(e, t, n) {
    function r() {
        o = t[u](function() {
            i.each(function() {
                var t = e(this), n = t.width(), r = t.height(), i = e.data(this, f);
                (n !== i.w || r !== i.h) && t.trigger(a, [ i.w = n, i.h = r ]);
            }), r();
        }, s[l]);
    }
    var i = e([]), s = e.resize = e.extend(e.resize, {}), o, u = "setTimeout", a = "resize", f = a + "-special-event", l = "delay", c = "throttleWindow";
    s[l] = 250, s[c] = !0, e.event.special[a] = {
        setup: function() {
            if (!s[c] && this[u]) return !1;
            var t = e(this);
            i = i.add(t), e.data(this, f, {
                w: t.width(),
                h: t.height()
            }), i.length === 1 && r();
        },
        teardown: function() {
            if (!s[c] && this[u]) return !1;
            var t = e(this);
            i = i.not(t), t.removeData(f), i.length || clearTimeout(o);
        },
        add: function(t) {
            function r(t, r, s) {
                var o = e(this), u = e.data(this, f);
                u.w = r !== n ? r : o.width(), u.h = s !== n ? s : o.height(), i.apply(this, arguments);
            }
            if (!s[c] && this[u]) return !1;
            var i;
            if (e.isFunction(t)) return i = t, r;
            i = t.handler, t.handler = r;
        }
    };
})(jQuery, this), function(e) {
    function t(e) {
        function t() {
            var t = e.getPlaceholder();
            if (t.width() == 0 || t.height() == 0) return;
            e.resize(), e.setupGrid(), e.draw();
        }
        function n(e, n) {
            e.getPlaceholder().resize(t);
        }
        function r(e, n) {
            e.getPlaceholder().unbind("resize", t);
        }
        e.hooks.bindEvents.push(n), e.hooks.shutdown.push(r);
    }
    var n = {};
    e.plot.plugins.push({
        init: t,
        options: n,
        name: "resize",
        version: "1.0"
    });
}(jQuery);
/*
 * Gritter for jQuery
 * http://www.boedesign.com/
 *
 * Copyright (c) 2012 Jordan Boesch
 * Dual licensed under the MIT and GPL licenses.
 *
 * Date: February 24, 2012
 * Version: 1.7.4
 */(function(e) {
    e.gritter = {};
    e.gritter.options = {
        position: "",
        class_name: "",
        fade_in_speed: "medium",
        fade_out_speed: 1e3,
        time: 6e3
    };
    e.gritter.add = function(e) {
        try {
            return t.add(e || {});
        } catch (n) {
            var r = "Gritter Error: " + n;
            typeof console != "undefined" && console.error ? console.error(r, e) : alert(r);
        }
    };
    e.gritter.remove = function(e, n) {
        t.removeSpecific(e, n || {});
    };
    e.gritter.removeAll = function(e) {
        t.stop(e || {});
    };
    var t = {
        position: "",
        fade_in_speed: "",
        fade_out_speed: "",
        time: "",
        _custom_timer: 0,
        _item_count: 0,
        _is_setup: 0,
        _tpl_close: '<a class="gritter-close" href="#" tabindex="1">Close Notification</a>',
        _tpl_title: '<span class="gritter-title">[[title]]</span>',
        _tpl_item: '<div id="gritter-item-[[number]]" class="gritter-item-wrapper [[item_class]]" style="display:none" role="alert"><div class="gritter-top"></div><div class="gritter-item">[[close]][[image]]<div class="[[class_name]]">[[title]]<p>[[text]]</p></div><div style="clear:both"></div></div><div class="gritter-bottom"></div></div>',
        _tpl_wrap: '<div id="gritter-notice-wrapper"></div>',
        add: function(n) {
            typeof n == "string" && (n = {
                text: n
            });
            if (n.text === null) throw 'You must supply "text" parameter.';
            this._is_setup || this._runSetup();
            var r = n.title, i = n.text, s = n.image || "", o = n.sticky || !1, u = n.class_name || e.gritter.options.class_name, a = e.gritter.options.position, f = n.time || "";
            this._verifyWrapper();
            this._item_count++;
            var l = this._item_count, c = this._tpl_item;
            e([ "before_open", "after_open", "before_close", "after_close" ]).each(function(r, i) {
                t["_" + i + "_" + l] = e.isFunction(n[i]) ? n[i] : function() {};
            });
            this._custom_timer = 0;
            f && (this._custom_timer = f);
            var h = s != "" ? '<img src="' + s + '" class="gritter-image" />' : "", p = s != "" ? "gritter-with-image" : "gritter-without-image";
            r ? r = this._str_replace("[[title]]", r, this._tpl_title) : r = "";
            c = this._str_replace([ "[[title]]", "[[text]]", "[[close]]", "[[image]]", "[[number]]", "[[class_name]]", "[[item_class]]" ], [ r, i, this._tpl_close, h, this._item_count, p, u ], c);
            if (this["_before_open_" + l]() === !1) return !1;
            e("#gritter-notice-wrapper").addClass(a).append(c);
            var d = e("#gritter-item-" + this._item_count);
            d.fadeIn(this.fade_in_speed, function() {
                t["_after_open_" + l](e(this));
            });
            o || this._setFadeTimer(d, l);
            e(d).bind("mouseenter mouseleave", function(n) {
                n.type == "mouseenter" ? o || t._restoreItemIfFading(e(this), l) : o || t._setFadeTimer(e(this), l);
                t._hoverState(e(this), n.type);
            });
            e(d).find(".gritter-close").click(function() {
                t.removeSpecific(l, {}, null, !0);
                return !1;
            });
            return l;
        },
        _countRemoveWrapper: function(t, n, r) {
            n.remove();
            this["_after_close_" + t](n, r);
            e(".gritter-item-wrapper").length == 0 && e("#gritter-notice-wrapper").remove();
        },
        _fade: function(e, n, r, i) {
            var r = r || {}, s = typeof r.fade != "undefined" ? r.fade : !0, o = r.speed || this.fade_out_speed, u = i;
            this["_before_close_" + n](e, u);
            i && e.unbind("mouseenter mouseleave");
            s ? e.animate({
                opacity: 0
            }, o, function() {
                e.animate({
                    height: 0
                }, 300, function() {
                    t._countRemoveWrapper(n, e, u);
                });
            }) : this._countRemoveWrapper(n, e);
        },
        _hoverState: function(e, t) {
            if (t == "mouseenter") {
                e.addClass("hover");
                e.find(".gritter-close").show();
            } else {
                e.removeClass("hover");
                e.find(".gritter-close").hide();
            }
        },
        removeSpecific: function(t, n, r, i) {
            if (!r) var r = e("#gritter-item-" + t);
            this._fade(r, t, n || {}, i);
        },
        _restoreItemIfFading: function(e, t) {
            clearTimeout(this["_int_id_" + t]);
            e.stop().css({
                opacity: "",
                height: ""
            });
        },
        _runSetup: function() {
            for (opt in e.gritter.options) this[opt] = e.gritter.options[opt];
            this._is_setup = 1;
        },
        _setFadeTimer: function(e, n) {
            var r = this._custom_timer ? this._custom_timer : this.time;
            this["_int_id_" + n] = setTimeout(function() {
                t._fade(e, n);
            }, r);
        },
        stop: function(t) {
            var n = e.isFunction(t.before_close) ? t.before_close : function() {}, r = e.isFunction(t.after_close) ? t.after_close : function() {}, i = e("#gritter-notice-wrapper");
            n(i);
            i.fadeOut(function() {
                e(this).remove();
                r();
            });
        },
        _str_replace: function(e, t, n, r) {
            var i = 0, s = 0, o = "", u = "", a = 0, f = 0, l = [].concat(e), c = [].concat(t), h = n, p = c instanceof Array, d = h instanceof Array;
            h = [].concat(h);
            r && (this.window[r] = 0);
            for (i = 0, a = h.length; i < a; i++) {
                if (h[i] === "") continue;
                for (s = 0, f = l.length; s < f; s++) {
                    o = h[i] + "";
                    u = p ? c[s] !== undefined ? c[s] : "" : c[0];
                    h[i] = o.split(l[s]).join(u);
                    r && h[i] !== o && (this.window[r] += (o.length - h[i].length) / l[s].length);
                }
            }
            return d ? h : h[0];
        },
        _verifyWrapper: function() {
            e("#gritter-notice-wrapper").length == 0 && e("body").append(this._tpl_wrap);
        }
    };
})(jQuery);
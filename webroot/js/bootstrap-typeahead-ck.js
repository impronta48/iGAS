//  ----------------------------------------------------------------------------
//
//  bootstrap-typeahead.js  
//
//  Twitter Bootstrap Typeahead Plugin
//  v1.2.2
//  https://github.com/tcrosen/twitter-bootstrap-typeahead
//
//
//  Author
//  ----------
//  Terry Rosen
//  tcrosen@gmail.com | @rerrify | github.com/tcrosen/
//
//
//  Description
//  ----------
//  Custom implementation of Twitter's Bootstrap Typeahead Plugin
//  http://twitter.github.com/bootstrap/javascript.html#typeahead
//
//
//  Requirements
//  ----------
//  jQuery 1.7+
//  Twitter Bootstrap 2.0+
//
//  ----------------------------------------------------------------------------
!function(e) {
    "use strict";
    var t = function(t, n) {
        this.$element = e(t);
        this.options = e.extend(!0, {}, e.fn.typeahead.defaults, n);
        this.$menu = e(this.options.menu).appendTo("body");
        this.shown = !1;
        this.eventSupported = this.options.eventSupported || this.eventSupported;
        this.grepper = this.options.grepper || this.grepper;
        this.highlighter = this.options.highlighter || this.highlighter;
        this.lookup = this.options.lookup || this.lookup;
        this.matcher = this.options.matcher || this.matcher;
        this.render = this.options.render || this.render;
        this.select = this.options.select || this.select;
        this.sorter = this.options.sorter || this.sorter;
        this.source = this.options.source || this.source;
        if (!this.source.length) {
            var r = this.options.ajax;
            typeof r == "string" ? this.ajax = e.extend({}, e.fn.typeahead.defaults.ajax, {
                url: r
            }) : this.ajax = e.extend({}, e.fn.typeahead.defaults.ajax, r);
            this.ajax.url || (this.ajax = null);
        }
        this.listen();
    };
    t.prototype = {
        constructor: t,
        eventSupported: function(e) {
            var t = e in this.$element;
            if (!t) {
                this.$element.setAttribute(e, "return;");
                t = typeof this.$element[e] == "function";
            }
            return t;
        },
        ajaxer: function() {
            var t = this, n = t.$element.val();
            if (n === t.query) return t;
            t.query = n;
            if (t.ajax.timerId) {
                clearTimeout(t.ajax.timerId);
                t.ajax.timerId = null;
            }
            if (!n || n.length < t.ajax.triggerLength) {
                if (t.ajax.xhr) {
                    t.ajax.xhr.abort();
                    t.ajax.xhr = null;
                    t.ajaxToggleLoadClass(!1);
                }
                return t.shown ? t.hide() : t;
            }
            t.ajax.timerId = setTimeout(function() {
                e.proxy(t.ajaxExecute(n), t);
            }, t.ajax.timeout);
            return t;
        },
        ajaxExecute: function(t) {
            this.ajaxToggleLoadClass(!0);
            this.ajax.xhr && this.ajax.xhr.abort();
            var n = this.ajax.preDispatch ? this.ajax.preDispatch(t) : {
                query: t
            }, r = this.ajax.method === "post" ? e.post : e.get;
            this.ajax.xhr = r(this.ajax.url, n, e.proxy(this.ajaxLookup, this));
            this.ajax.timerId = null;
        },
        ajaxLookup: function(e) {
            var t;
            this.ajaxToggleLoadClass(!1);
            if (!this.ajax.xhr) return;
            this.ajax.preProcess && (e = this.ajax.preProcess(e));
            this.ajax.data = e;
            t = this.grepper(this.ajax.data);
            if (!t || !t.length) return this.shown ? this.hide() : this;
            this.ajax.xhr = null;
            return this.render(t.slice(0, this.options.items)).show();
        },
        ajaxToggleLoadClass: function(e) {
            if (!this.ajax.loadingClass) return;
            this.$element.toggleClass(this.ajax.loadingClass, e);
        },
        lookup: function(e) {
            var t = this, n;
            if (!t.ajax) {
                t.query = t.$element.val();
                if (!t.query) return t.shown ? t.hide() : t;
                n = t.grepper(t.source);
                return !n || !n.length ? t.shown ? t.hide() : t : t.render(n.slice(0, t.options.items)).show();
            }
            t.ajaxer();
        },
        grepper: function(t) {
            var n = this, r;
            if (t && t.length && !t[0].hasOwnProperty(n.options.display)) return null;
            r = e.grep(t, function(e) {
                return n.matcher(e[n.options.display], e);
            });
            return this.sorter(r);
        },
        matcher: function(e) {
            return ~e.toLowerCase().indexOf(this.query.toLowerCase());
        },
        sorter: function(e) {
            var t = this, n = [], r = [], i = [], s;
            while (s = e.shift()) s[t.options.display].toLowerCase().indexOf(this.query.toLowerCase()) ? ~s[t.options.display].indexOf(this.query) ? r.push(s) : i.push(s) : n.push(s);
            return n.concat(r, i);
        },
        show: function() {
            var t = e.extend({}, this.$element.offset(), {
                height: this.$element[0].offsetHeight
            });
            this.$menu.css({
                top: t.top + t.height,
                left: t.left
            });
            this.$menu.show();
            this.shown = !0;
            return this;
        },
        hide: function() {
            this.$menu.hide();
            this.shown = !1;
            return this;
        },
        highlighter: function(e) {
            var t = this.query.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, "\\$&");
            return e.replace(new RegExp("(" + t + ")", "ig"), function(e, t) {
                return "<strong>" + t + "</strong>";
            });
        },
        render: function(t) {
            var n = this;
            t = e(t).map(function(t, r) {
                t = e(n.options.item).attr("data-value", r[n.options.val]);
                t.find("a").html(n.highlighter(r[n.options.display], r));
                return t[0];
            });
            t.first().addClass("active");
            this.$menu.html(t);
            return this;
        },
        select: function() {
            var e = this.$menu.find(".active");
            this.$element.val(e.text()).change();
            this.options.itemSelected(e, e.attr("data-value"), e.text());
            return this.hide();
        },
        next: function(t) {
            var n = this.$menu.find(".active").removeClass("active"), r = n.next();
            r.length || (r = e(this.$menu.find("li")[0]));
            r.addClass("active");
        },
        prev: function(e) {
            var t = this.$menu.find(".active").removeClass("active"), n = t.prev();
            n.length || (n = this.$menu.find("li").last());
            n.addClass("active");
        },
        listen: function() {
            this.$element.on("blur", e.proxy(this.blur, this)).on("keyup", e.proxy(this.keyup, this));
            this.eventSupported("keydown") ? this.$element.on("keydown", e.proxy(this.keypress, this)) : this.$element.on("keypress", e.proxy(this.keypress, this));
            this.$menu.on("click", e.proxy(this.click, this)).on("mouseenter", "li", e.proxy(this.mouseenter, this));
        },
        keyup: function(e) {
            e.stopPropagation();
            e.preventDefault();
            switch (e.keyCode) {
              case 40:
              case 38:
                break;
              case 9:
              case 13:
                if (!this.shown) return;
                this.select();
                break;
              case 27:
                this.hide();
                break;
              default:
                this.lookup();
            }
        },
        keypress: function(e) {
            e.stopPropagation();
            if (!this.shown) return;
            switch (e.keyCode) {
              case 9:
              case 13:
              case 27:
                e.preventDefault();
                break;
              case 38:
                e.preventDefault();
                this.prev();
                break;
              case 40:
                e.preventDefault();
                this.next();
            }
        },
        blur: function(e) {
            var t = this;
            e.stopPropagation();
            e.preventDefault();
            setTimeout(function() {
                t.$menu.is(":focus") || t.hide();
            }, 150);
        },
        click: function(e) {
            e.stopPropagation();
            e.preventDefault();
            this.select();
        },
        mouseenter: function(t) {
            this.$menu.find(".active").removeClass("active");
            e(t.currentTarget).addClass("active");
        }
    };
    e.fn.typeahead = function(n) {
        return this.each(function() {
            var r = e(this), i = r.data("typeahead"), s = typeof n == "object" && n;
            i || r.data("typeahead", i = new t(this, s));
            typeof n == "string" && i[n]();
        });
    };
    e.fn.typeahead.defaults = {
        source: [],
        items: 8,
        menu: '<ul class="typeahead dropdown-menu"></ul>',
        item: '<li><a href="#"></a></li>',
        display: "name",
        val: "id",
        itemSelected: function() {},
        ajax: {
            url: null,
            timeout: 300,
            method: "post",
            triggerLength: 3,
            loadingClass: null,
            displayField: null,
            preDispatch: null,
            preProcess: null
        }
    };
    e.fn.typeahead.Constructor = t;
    e(function() {
        e("body").on("focus.typeahead.data-api", '[data-provide="typeahead"]', function(t) {
            var n = e(this);
            if (n.data("typeahead")) return;
            t.preventDefault();
            n.typeahead(n.data());
        });
    });
}(window.jQuery);
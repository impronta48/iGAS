!function(e) {
    var t = function(n, r, i) {
        if (i) {
            i.stopPropagation();
            i.preventDefault();
        }
        this.$element = e(n);
        this.$newElement = null;
        this.button = null;
        this.options = e.extend({}, e.fn.selectpicker.defaults, this.$element.data(), typeof r == "object" && r);
        this.options.title == null && (this.options.title = this.$element.attr("title"));
        this.val = t.prototype.val;
        this.render = t.prototype.render;
        this.init();
    };
    t.prototype = {
        constructor: t,
        init: function(t) {
            var n = this;
            this.$element.hide();
            this.multiple = this.$element.prop("multiple");
            var r = this.$element.attr("class") !== undefined ? this.$element.attr("class").split(/\s+/) : "", i = this.$element.attr("id");
            this.$element.after(this.createView());
            this.$newElement = this.$element.next(".select");
            var s = this.$newElement, o = this.$newElement.find(".dropdown-menu"), u = this.$newElement.find(".dropdown-arrow"), a = o.find("li > a"), f = s.addClass("open").find(".dropdown-menu li > a").outerHeight();
            s.removeClass("open");
            var l = o.find("li .divider").outerHeight(!0), c = this.$newElement.offset().top, h = 0, p = 0, d = this.$newElement.outerHeight();
            this.button = this.$newElement.find("> button");
            if (i !== undefined) {
                this.button.attr("id", i);
                e('label[for="' + i + '"]').click(function() {
                    s.find("button#" + i).focus();
                });
            }
            for (var v = 0; v < r.length; v++) r[v] != "selectpicker" && this.$newElement.addClass(r[v]);
            this.multiple && this.$newElement.addClass("select-multiple");
            this.button.addClass(this.options.style);
            o.addClass(this.options.menuStyle);
            u.addClass(function() {
                if (n.options.menuStyle) return n.options.menuStyle.replace("dropdown-", "dropdown-arrow-");
            });
            this.checkDisabled();
            this.checkTabIndex();
            this.clickListener();
            var m = parseInt(o.css("padding-top")) + parseInt(o.css("padding-bottom")) + parseInt(o.css("border-top-width")) + parseInt(o.css("border-bottom-width"));
            if (this.options.size == "auto") {
                function g() {
                    var t = c - e(window).scrollTop(), n = e(window).innerHeight, r = m + parseInt(o.css("margin-top")) + parseInt(o.css("margin-bottom")) + 2, i = n - t - d - r;
                    p = i;
                    s.hasClass("dropup") && (p = t - r);
                    o.css({
                        "max-height": p + "px",
                        "overflow-y": "auto",
                        "min-height": f * 3 + "px"
                    });
                }
                g();
                e(window).resize(g);
                e(window).scroll(g);
                this.$element.bind("DOMNodeInserted", g);
            } else if (this.options.size && this.options.size != "auto" && o.find("li").length > this.options.size) {
                var y = o.find("li > *").filter(":not(.divider)").slice(0, this.options.size).last().parent().index(), b = o.find("li").slice(0, y + 1).find(".divider").length;
                p = f * this.options.size + b * l + m;
                o.css({
                    "max-height": p + "px",
                    "overflow-y": "scroll"
                });
            }
            this.$element.bind("DOMNodeInserted", e.proxy(this.reloadLi, this));
            this.render();
        },
        createDropdown: function() {
            var t = "<div class='btn-group select'><i class='dropdown-arrow'></i><button class='btn dropdown-toggle clearfix' data-toggle='dropdown'><span class='filter-option pull-left'></span>&nbsp;<span class='caret'></span></button><ul class='dropdown-menu' role='menu'></ul></div>";
            return e(t);
        },
        createView: function() {
            var e = this.createDropdown(), t = this.createLi();
            e.find("ul").append(t);
            return e;
        },
        reloadLi: function() {
            this.destroyLi();
            $li = this.createLi();
            this.$newElement.find("ul").append($li);
            this.render();
        },
        destroyLi: function() {
            this.$newElement.find("li").remove();
        },
        createLi: function() {
            var t = this, n = [], r = [], i = "";
            this.$element.find("option").each(function() {
                n.push(e(this).text());
            });
            this.$element.find("option").each(function(n) {
                var i = e(this).attr("class") !== undefined ? e(this).attr("class") : "", s = e(this).text(), o = e(this).data("subtext") !== undefined ? '<small class="muted">' + e(this).data("subtext") + "</small>" : "";
                s += o;
                if (e(this).parent().is("optgroup") && e(this).data("divider") != 1) if (e(this).index() == 0) {
                    var u = e(this).parent().attr("label"), a = e(this).parent().data("subtext") !== undefined ? '<small class="muted">' + e(this).parent().data("subtext") + "</small>" : "";
                    u += a;
                    e(this)[0].index != 0 ? r.push('<div class="divider"></div><dt>' + u + "</dt>" + t.createA(s, "opt " + i)) : r.push("<dt>" + u + "</dt>" + t.createA(s, "opt " + i));
                } else r.push(t.createA(s, "opt " + i)); else e(this).data("divider") == 1 ? r.push('<div class="divider"></div>') : r.push(t.createA(s, i));
            });
            if (n.length > 0) for (var s = 0; s < n.length; s++) {
                var o = this.$element.find("option").eq(s);
                i += "<li rel=" + s + ">" + r[s] + "</li>";
            }
            this.$element.find("option:selected").length == 0 && !t.options.title && this.$element.find("option").eq(0).prop("selected", !0).attr("selected", "selected");
            return e(i);
        },
        createA: function(e, t) {
            return '<a tabindex="-1" href="#" class="' + t + '">' + '<span class="pull-left">' + e + "</span>" + "</a>";
        },
        render: function() {
            var t = this;
            if (this.options.width == "auto") {
                var n = this.$newElement.find(".dropdown-menu").css("width");
                this.$newElement.css("width", n);
            } else this.options.width && this.options.width != "auto" && this.$newElement.css("width", this.options.width);
            this.$element.find("option").each(function(n) {
                t.setDisabled(n, e(this).is(":disabled") || e(this).parent().is(":disabled"));
                t.setSelected(n, e(this).is(":selected"));
            });
            var r = this.$element.find("option:selected").map(function(t, n) {
                return e(this).attr("title") != undefined ? e(this).attr("title") : e(this).text();
            }).toArray(), i = r.join(", ");
            if (t.multiple && t.options.selectedTextFormat.indexOf("count") > -1) {
                var s = t.options.selectedTextFormat.split(">");
                if (s.length > 1 && r.length > s[1] || s.length == 1 && r.length >= 2) i = r.length + " of " + this.$element.find("option").length + " selected";
            }
            i || (i = t.options.title != undefined ? t.options.title : t.options.noneSelectedText);
            this.$element.next(".select").find(".filter-option").html(i);
        },
        setSelected: function(e, t) {
            t ? this.$newElement.find("li").eq(e).addClass("selected") : this.$newElement.find("li").eq(e).removeClass("selected");
        },
        setDisabled: function(e, t) {
            t ? this.$newElement.find("li").eq(e).addClass("disabled") : this.$newElement.find("li").eq(e).removeClass("disabled");
        },
        checkDisabled: function() {
            if (this.$element.is(":disabled")) {
                this.button.addClass("disabled");
                this.button.click(function(e) {
                    e.preventDefault();
                });
            }
        },
        checkTabIndex: function() {
            if (this.$element.is("[tabindex]")) {
                var e = this.$element.attr("tabindex");
                this.button.attr("tabindex", e);
            }
        },
        clickListener: function() {
            var t = this;
            e("body").on("touchstart.dropdown", ".dropdown-menu", function(e) {
                e.stopPropagation();
            });
            this.$newElement.on("click", "li a", function(n) {
                var r = e(this).parent().index(), i = e(this).parent(), s = i.parents(".select");
                t.multiple && n.stopPropagation();
                n.preventDefault();
                if (s.prev("select").not(":disabled") && !e(this).parent().hasClass("disabled")) {
                    if (!t.multiple) {
                        s.prev("select").find("option").removeAttr("selected");
                        s.prev("select").find("option").eq(r).prop("selected", !0).attr("selected", "selected");
                    } else {
                        var o = s.prev("select").find("option").eq(r).prop("selected");
                        o ? s.prev("select").find("option").eq(r).removeAttr("selected") : s.prev("select").find("option").eq(r).prop("selected", !0).attr("selected", "selected");
                    }
                    s.find(".filter-option").html(i.text());
                    s.find("button").focus();
                    s.prev("select").trigger("change");
                }
            });
            this.$newElement.on("click", "li.disabled a, li dt, li .divider", function(t) {
                t.preventDefault();
                t.stopPropagation();
                $select = e(this).parent().parents(".select");
                $select.find("button").focus();
            });
            this.$element.on("change", function(e) {
                t.render();
            });
        },
        val: function(e) {
            if (e != undefined) {
                this.$element.val(e);
                this.$element.trigger("change");
                return this.$element;
            }
            return this.$element.val();
        }
    };
    e.fn.selectpicker = function(n, r) {
        var i = arguments, s, o = this.each(function() {
            var o = e(this), u = o.data("selectpicker"), a = typeof n == "object" && n;
            if (!u) o.data("selectpicker", u = new t(this, a, r)); else for (var f in n) u[f] = n[f];
            if (typeof n == "string") {
                property = n;
                if (u[property] instanceof Function) {
                    [].shift.apply(i);
                    s = u[property].apply(u, i);
                } else s = u[property];
            }
        });
        return s != undefined ? s : o;
    };
    e.fn.selectpicker.defaults = {
        style: null,
        size: "auto",
        title: null,
        selectedTextFormat: "values",
        noneSelectedText: "Nothing selected",
        width: null,
        menuStyle: null,
        toggleSize: null
    };
}(window.jQuery);
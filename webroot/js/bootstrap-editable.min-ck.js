/*! X-editable - v1.5.0 
* In-place editing with Twitter Bootstrap, jQuery UI or pure jQuery
* http://github.com/vitalets/x-editable
* Copyright (c) 2013 Vitaliy Potapov; Licensed MIT */!function(e) {
    "use strict";
    var t = function(t, n) {
        this.options = e.extend({}, e.fn.editableform.defaults, n), this.$div = e(t), this.options.scope || (this.options.scope = this);
    };
    t.prototype = {
        constructor: t,
        initInput: function() {
            this.input = this.options.input, this.value = this.input.str2value(this.options.value), this.input.prerender();
        },
        initTemplate: function() {
            this.$form = e(e.fn.editableform.template);
        },
        initButtons: function() {
            var t = this.$form.find(".editable-buttons");
            t.append(e.fn.editableform.buttons), "bottom" === this.options.showbuttons && t.addClass("editable-buttons-bottom");
        },
        render: function() {
            this.$loading = e(e.fn.editableform.loading), this.$div.empty().append(this.$loading), this.initTemplate(), this.options.showbuttons ? this.initButtons() : this.$form.find(".editable-buttons").remove(), this.showLoading(), this.isSaving = !1, this.$div.triggerHandler("rendering"), this.initInput(), this.$form.find("div.editable-input").append(this.input.$tpl), this.$div.append(this.$form), e.when(this.input.render()).then(e.proxy(function() {
                if (this.options.showbuttons || this.input.autosubmit(), this.$form.find(".editable-cancel").click(e.proxy(this.cancel, this)), this.input.error) this.error(this.input.error), this.$form.find(".editable-submit").attr("disabled", !0), this.input.$input.attr("disabled", !0), this.$form.submit(function(e) {
                    e.preventDefault();
                }); else {
                    this.error(!1), this.input.$input.removeAttr("disabled"), this.$form.find(".editable-submit").removeAttr("disabled");
                    var t = null === this.value || void 0 === this.value || "" === this.value ? this.options.defaultValue : this.value;
                    this.input.value2input(t), this.$form.submit(e.proxy(this.submit, this));
                }
                this.$div.triggerHandler("rendered"), this.showForm(), this.input.postrender && this.input.postrender();
            }, this));
        },
        cancel: function() {
            this.$div.triggerHandler("cancel");
        },
        showLoading: function() {
            var e, t;
            this.$form ? (e = this.$form.outerWidth(), t = this.$form.outerHeight(), e && this.$loading.width(e), t && this.$loading.height(t), this.$form.hide()) : (e = this.$loading.parent().width(), e && this.$loading.width(e)), this.$loading.show();
        },
        showForm: function(e) {
            this.$loading.hide(), this.$form.show(), e !== !1 && this.input.activate(), this.$div.triggerHandler("show");
        },
        error: function(t) {
            var n, r = this.$form.find(".control-group"), i = this.$form.find(".editable-error-block");
            if (t === !1) r.removeClass(e.fn.editableform.errorGroupClass), i.removeClass(e.fn.editableform.errorBlockClass).empty().hide(); else {
                if (t) {
                    n = t.split("\n");
                    for (var s = 0; s < n.length; s++) n[s] = e("<div>").text(n[s]).html();
                    t = n.join("<br>");
                }
                r.addClass(e.fn.editableform.errorGroupClass), i.addClass(e.fn.editableform.errorBlockClass).html(t).show();
            }
        },
        submit: function(t) {
            t.stopPropagation(), t.preventDefault();
            var n, r = this.input.input2value();
            if (n = this.validate(r)) return this.error(n), this.showForm(), void 0;
            if (!this.options.savenochange && this.input.value2str(r) == this.input.value2str(this.value)) return this.$div.triggerHandler("nochange"), void 0;
            var i = this.input.value2submit(r);
            this.isSaving = !0, e.when(this.save(i)).done(e.proxy(function(e) {
                this.isSaving = !1;
                var t = "function" == typeof this.options.success ? this.options.success.call(this.options.scope, e, r) : null;
                return t === !1 ? (this.error(!1), this.showForm(!1), void 0) : "string" == typeof t ? (this.error(t), this.showForm(), void 0) : (t && "object" == typeof t && t.hasOwnProperty("newValue") && (r = t.newValue), this.error(!1), this.value = r, this.$div.triggerHandler("save", {
                    newValue: r,
                    submitValue: i,
                    response: e
                }), void 0);
            }, this)).fail(e.proxy(function(e) {
                this.isSaving = !1;
                var t;
                t = "function" == typeof this.options.error ? this.options.error.call(this.options.scope, e, r) : "string" == typeof e ? e : e.responseText || e.statusText || "Unknown error!", this.error(t), this.showForm();
            }, this));
        },
        save: function(t) {
            this.options.pk = e.fn.editableutils.tryParseJson(this.options.pk, !0);
            var n, r = "function" == typeof this.options.pk ? this.options.pk.call(this.options.scope) : this.options.pk, i = !!("function" == typeof this.options.url || this.options.url && ("always" === this.options.send || "auto" === this.options.send && null !== r && void 0 !== r));
            return i ? (this.showLoading(), n = {
                name: this.options.name || "",
                value: t,
                pk: r
            }, "function" == typeof this.options.params ? n = this.options.params.call(this.options.scope, n) : (this.options.params = e.fn.editableutils.tryParseJson(this.options.params, !0), e.extend(n, this.options.params)), "function" == typeof this.options.url ? this.options.url.call(this.options.scope, n) : e.ajax(e.extend({
                url: this.options.url,
                data: n,
                type: "POST"
            }, this.options.ajaxOptions))) : void 0;
        },
        validate: function(e) {
            return void 0 === e && (e = this.value), "function" == typeof this.options.validate ? this.options.validate.call(this.options.scope, e) : void 0;
        },
        option: function(e, t) {
            e in this.options && (this.options[e] = t), "value" === e && this.setValue(t);
        },
        setValue: function(e, t) {
            this.value = t ? this.input.str2value(e) : e, this.$form && this.$form.is(":visible") && this.input.value2input(this.value);
        }
    }, e.fn.editableform = function(n) {
        var r = arguments;
        return this.each(function() {
            var i = e(this), s = i.data("editableform"), o = "object" == typeof n && n;
            s || i.data("editableform", s = new t(this, o)), "string" == typeof n && s[n].apply(s, Array.prototype.slice.call(r, 1));
        });
    }, e.fn.editableform.Constructor = t, e.fn.editableform.defaults = {
        type: "text",
        url: null,
        params: null,
        name: null,
        pk: null,
        value: null,
        defaultValue: null,
        send: "auto",
        validate: null,
        success: null,
        error: null,
        ajaxOptions: null,
        showbuttons: !0,
        scope: null,
        savenochange: !1
    }, e.fn.editableform.template = '<form class="form-inline editableform"><div class="control-group"><div><div class="editable-input"></div><div class="editable-buttons"></div></div><div class="editable-error-block"></div></div></form>', e.fn.editableform.loading = '<div class="editableform-loading"></div>', e.fn.editableform.buttons = '<button type="submit" class="editable-submit">ok</button><button type="button" class="editable-cancel">cancel</button>', e.fn.editableform.errorGroupClass = null, e.fn.editableform.errorBlockClass = "editable-error", e.fn.editableform.engine = "jquery";
}(window.jQuery), function(e) {
    "use strict";
    e.fn.editableutils = {
        inherit: function(e, t) {
            var n = function() {};
            n.prototype = t.prototype, e.prototype = new n, e.prototype.constructor = e, e.superclass = t.prototype;
        },
        setCursorPosition: function(e, t) {
            if (e.setSelectionRange) e.setSelectionRange(t, t); else if (e.createTextRange) {
                var n = e.createTextRange();
                n.collapse(!0), n.moveEnd("character", t), n.moveStart("character", t), n.select();
            }
        },
        tryParseJson: function(e, t) {
            if ("string" == typeof e && e.length && e.match(/^[\{\[].*[\}\]]$/)) if (t) try {
                e = (new Function("return " + e))();
            } catch (n) {} finally {
                return e;
            } else e = (new Function("return " + e))();
            return e;
        },
        sliceObj: function(t, n, r) {
            var i, s, o = {};
            if (!e.isArray(n) || !n.length) return o;
            for (var u = 0; u < n.length; u++) i = n[u], t.hasOwnProperty(i) && (o[i] = t[i]), r !== !0 && (s = i.toLowerCase(), t.hasOwnProperty(s) && (o[i] = t[s]));
            return o;
        },
        getConfigData: function(t) {
            var n = {};
            return e.each(t.data(), function(e, t) {
                ("object" != typeof t || t && "object" == typeof t && (t.constructor === Object || t.constructor === Array)) && (n[e] = t);
            }), n;
        },
        objectKeys: function(e) {
            if (Object.keys) return Object.keys(e);
            if (e !== Object(e)) throw new TypeError("Object.keys called on a non-object");
            var t, n = [];
            for (t in e) Object.prototype.hasOwnProperty.call(e, t) && n.push(t);
            return n;
        },
        escape: function(t) {
            return e("<div>").text(t).html();
        },
        itemsByValue: function(t, n, r) {
            if (!n || null === t) return [];
            if ("function" != typeof r) {
                var i = r || "value";
                r = function(e) {
                    return e[i];
                };
            }
            var s = e.isArray(t), o = [], u = this;
            return e.each(n, function(n, i) {
                if (i.children) o = o.concat(u.itemsByValue(t, i.children, r)); else if (s) e.grep(t, function(e) {
                    return e == (i && "object" == typeof i ? r(i) : i);
                }).length && o.push(i); else {
                    var l = i && "object" == typeof i ? r(i) : i;
                    t == l && o.push(i);
                }
            }), o;
        },
        createInput: function(t) {
            var n, r, i, s = t.type;
            return "date" === s && ("inline" === t.mode ? e.fn.editabletypes.datefield ? s = "datefield" : e.fn.editabletypes.dateuifield && (s = "dateuifield") : e.fn.editabletypes.date ? s = "date" : e.fn.editabletypes.dateui && (s = "dateui"), "date" !== s || e.fn.editabletypes.date || (s = "combodate")), "datetime" === s && "inline" === t.mode && (s = "datetimefield"), "wysihtml5" !== s || e.fn.editabletypes[s] || (s = "textarea"), "function" == typeof e.fn.editabletypes[s] ? (n = e.fn.editabletypes[s], r = this.sliceObj(t, this.objectKeys(n.defaults)), i = new n(r)) : (e.error("Unknown type: " + s), !1);
        },
        supportsTransitions: function() {
            var e = document.body || document.documentElement, t = e.style, n = "transition", r = [ "Moz", "Webkit", "Khtml", "O", "ms" ];
            if ("string" == typeof t[n]) return !0;
            n = n.charAt(0).toUpperCase() + n.substr(1);
            for (var i = 0; i < r.length; i++) if ("string" == typeof t[r[i] + n]) return !0;
            return !1;
        }
    };
}(window.jQuery), function(e) {
    "use strict";
    var t = function(e, t) {
        this.init(e, t);
    }, n = function(e, t) {
        this.init(e, t);
    };
    t.prototype = {
        containerName: null,
        containerDataName: null,
        innerCss: null,
        containerClass: "editable-container editable-popup",
        defaults: {},
        init: function(n, r) {
            this.$element = e(n), this.options = e.extend({}, e.fn.editableContainer.defaults, r), this.splitOptions(), this.formOptions.scope = this.$element[0], this.initContainer(), this.delayedHide = !1, this.$element.on("destroyed", e.proxy(function() {
                this.destroy();
            }, this)), e(document).data("editable-handlers-attached") || (e(document).on("keyup.editable", function(t) {
                27 === t.which && e(".editable-open").editableContainer("hide");
            }), e(document).on("click.editable", function(n) {
                var r, i = e(n.target), s = [ ".editable-container", ".ui-datepicker-header", ".datepicker", ".modal-backdrop", ".bootstrap-wysihtml5-insert-image-modal", ".bootstrap-wysihtml5-insert-link-modal" ];
                if (e.contains(document.documentElement, n.target) && !i.is(document)) {
                    for (r = 0; r < s.length; r++) if (i.is(s[r]) || i.parents(s[r]).length) return;
                    t.prototype.closeOthers(n.target);
                }
            }), e(document).data("editable-handlers-attached", !0));
        },
        splitOptions: function() {
            if (this.containerOptions = {}, this.formOptions = {}, !e.fn[this.containerName]) throw new Error(this.containerName + " not found. Have you included corresponding js file?");
            for (var t in this.options) t in this.defaults ? this.containerOptions[t] = this.options[t] : this.formOptions[t] = this.options[t];
        },
        tip: function() {
            return this.container() ? this.container().$tip : null;
        },
        container: function() {
            var e;
            return this.containerDataName && (e = this.$element.data(this.containerDataName)) ? e : e = this.$element.data(this.containerName);
        },
        call: function() {
            this.$element[this.containerName].apply(this.$element, arguments);
        },
        initContainer: function() {
            this.call(this.containerOptions);
        },
        renderForm: function() {
            this.$form.editableform(this.formOptions).on({
                save: e.proxy(this.save, this),
                nochange: e.proxy(function() {
                    this.hide("nochange");
                }, this),
                cancel: e.proxy(function() {
                    this.hide("cancel");
                }, this),
                show: e.proxy(function() {
                    this.delayedHide ? (this.hide(this.delayedHide.reason), this.delayedHide = !1) : this.setPosition();
                }, this),
                rendering: e.proxy(this.setPosition, this),
                resize: e.proxy(this.setPosition, this),
                rendered: e.proxy(function() {
                    this.$element.triggerHandler("shown", e(this.options.scope).data("editable"));
                }, this)
            }).editableform("render");
        },
        show: function(t) {
            this.$element.addClass("editable-open"), t !== !1 && this.closeOthers(this.$element[0]), this.innerShow(), this.tip().addClass(this.containerClass), this.$form, this.$form = e("<div>"), this.tip().is(this.innerCss) ? this.tip().append(this.$form) : this.tip().find(this.innerCss).append(this.$form), this.renderForm();
        },
        hide: function(e) {
            if (this.tip() && this.tip().is(":visible") && this.$element.hasClass("editable-open")) {
                if (this.$form.data("editableform").isSaving) return this.delayedHide = {
                    reason: e
                }, void 0;
                this.delayedHide = !1, this.$element.removeClass("editable-open"), this.innerHide(), this.$element.triggerHandler("hidden", e || "manual");
            }
        },
        innerShow: function() {},
        innerHide: function() {},
        toggle: function(e) {
            this.container() && this.tip() && this.tip().is(":visible") ? this.hide() : this.show(e);
        },
        setPosition: function() {},
        save: function(e, t) {
            this.$element.triggerHandler("save", t), this.hide("save");
        },
        option: function(e, t) {
            this.options[e] = t, e in this.containerOptions ? (this.containerOptions[e] = t, this.setContainerOption(e, t)) : (this.formOptions[e] = t, this.$form && this.$form.editableform("option", e, t));
        },
        setContainerOption: function(e, t) {
            this.call("option", e, t);
        },
        destroy: function() {
            this.hide(), this.innerDestroy(), this.$element.off("destroyed"), this.$element.removeData("editableContainer");
        },
        innerDestroy: function() {},
        closeOthers: function(t) {
            e(".editable-open").each(function(n, r) {
                if (r !== t && !e(r).find(t).length) {
                    var i = e(r), s = i.data("editableContainer");
                    s && ("cancel" === s.options.onblur ? i.data("editableContainer").hide("onblur") : "submit" === s.options.onblur && i.data("editableContainer").tip().find("form").submit());
                }
            });
        },
        activate: function() {
            this.tip && this.tip().is(":visible") && this.$form && this.$form.data("editableform").input.activate();
        }
    }, e.fn.editableContainer = function(r) {
        var i = arguments;
        return this.each(function() {
            var s = e(this), o = "editableContainer", u = s.data(o), f = "object" == typeof r && r, l = "inline" === f.mode ? n : t;
            u || s.data(o, u = new l(this, f)), "string" == typeof r && u[r].apply(u, Array.prototype.slice.call(i, 1));
        });
    }, e.fn.editableContainer.Popup = t, e.fn.editableContainer.Inline = n, e.fn.editableContainer.defaults = {
        value: null,
        placement: "top",
        autohide: !0,
        onblur: "cancel",
        anim: !1,
        mode: "popup"
    }, jQuery.event.special.destroyed = {
        remove: function(e) {
            e.handler && e.handler();
        }
    };
}(window.jQuery), function(e) {
    "use strict";
    e.extend(e.fn.editableContainer.Inline.prototype, e.fn.editableContainer.Popup.prototype, {
        containerName: "editableform",
        innerCss: ".editable-inline",
        containerClass: "editable-container editable-inline",
        initContainer: function() {
            this.$tip = e("<span></span>"), this.options.anim || (this.options.anim = 0);
        },
        splitOptions: function() {
            this.containerOptions = {}, this.formOptions = this.options;
        },
        tip: function() {
            return this.$tip;
        },
        innerShow: function() {
            this.$element.hide(), this.tip().insertAfter(this.$element).show();
        },
        innerHide: function() {
            this.$tip.hide(this.options.anim, e.proxy(function() {
                this.$element.show(), this.innerDestroy();
            }, this));
        },
        innerDestroy: function() {
            this.tip() && this.tip().empty().remove();
        }
    });
}(window.jQuery), function(e) {
    "use strict";
    var t = function(t, n) {
        this.$element = e(t), this.options = e.extend({}, e.fn.editable.defaults, n, e.fn.editableutils.getConfigData(this.$element)), this.options.selector ? this.initLive() : this.init(), this.options.highlight && !e.fn.editableutils.supportsTransitions() && (this.options.highlight = !1);
    };
    t.prototype = {
        constructor: t,
        init: function() {
            var t, n = !1;
            if (this.options.name = this.options.name || this.$element.attr("id"), this.options.scope = this.$element[0], this.input = e.fn.editableutils.createInput(this.options), this.input) {
                switch (void 0 === this.options.value || null === this.options.value ? (this.value = this.input.html2value(e.trim(this.$element.html())), n = !0) : (this.options.value = e.fn.editableutils.tryParseJson(this.options.value, !0), this.value = "string" == typeof this.options.value ? this.input.str2value(this.options.value) : this.options.value), this.$element.addClass("editable"), "textarea" === this.input.type && this.$element.addClass("editable-pre-wrapped"), "manual" !== this.options.toggle ? (this.$element.addClass("editable-click"), this.$element.on(this.options.toggle + ".editable", e.proxy(function(e) {
                    if (this.options.disabled || e.preventDefault(), "mouseenter" === this.options.toggle) this.show(); else {
                        var t = "click" !== this.options.toggle;
                        this.toggle(t);
                    }
                }, this))) : this.$element.attr("tabindex", -1), "function" == typeof this.options.display && (this.options.autotext = "always"), this.options.autotext) {
                  case "always":
                    t = !0;
                    break;
                  case "auto":
                    t = !e.trim(this.$element.text()).length && null !== this.value && void 0 !== this.value && !n;
                    break;
                  default:
                    t = !1;
                }
                e.when(t ? this.render() : !0).then(e.proxy(function() {
                    this.options.disabled ? this.disable() : this.enable(), this.$element.triggerHandler("init", this);
                }, this));
            }
        },
        initLive: function() {
            var t = this.options.selector;
            this.options.selector = !1, this.options.autotext = "never", this.$element.on(this.options.toggle + ".editable", t, e.proxy(function(t) {
                var n = e(t.target);
                n.data("editable") || (n.hasClass(this.options.emptyclass) && n.empty(), n.editable(this.options).trigger(t));
            }, this));
        },
        render: function(e) {
            return this.options.display !== !1 ? this.input.value2htmlFinal ? this.input.value2html(this.value, this.$element[0], this.options.display, e) : "function" == typeof this.options.display ? this.options.display.call(this.$element[0], this.value, e) : this.input.value2html(this.value, this.$element[0]) : void 0;
        },
        enable: function() {
            this.options.disabled = !1, this.$element.removeClass("editable-disabled"), this.handleEmpty(this.isEmpty), "manual" !== this.options.toggle && "-1" === this.$element.attr("tabindex") && this.$element.removeAttr("tabindex");
        },
        disable: function() {
            this.options.disabled = !0, this.hide(), this.$element.addClass("editable-disabled"), this.handleEmpty(this.isEmpty), this.$element.attr("tabindex", -1);
        },
        toggleDisabled: function() {
            this.options.disabled ? this.enable() : this.disable();
        },
        option: function(t, n) {
            return t && "object" == typeof t ? (e.each(t, e.proxy(function(t, n) {
                this.option(e.trim(t), n);
            }, this)), void 0) : (this.options[t] = n, "disabled" === t ? n ? this.disable() : this.enable() : ("value" === t && this.setValue(n), this.container && this.container.option(t, n), this.input.option && this.input.option(t, n), void 0));
        },
        handleEmpty: function(t) {
            this.options.display !== !1 && (this.isEmpty = void 0 !== t ? t : "function" == typeof this.input.isEmpty ? this.input.isEmpty(this.$element) : "" === e.trim(this.$element.html()), this.options.disabled ? this.isEmpty && (this.$element.empty(), this.options.emptyclass && this.$element.removeClass(this.options.emptyclass)) : this.isEmpty ? (this.$element.html(this.options.emptytext), this.options.emptyclass && this.$element.addClass(this.options.emptyclass)) : this.options.emptyclass && this.$element.removeClass(this.options.emptyclass));
        },
        show: function(t) {
            if (!this.options.disabled) {
                if (this.container) {
                    if (this.container.tip().is(":visible")) return;
                } else {
                    var n = e.extend({}, this.options, {
                        value: this.value,
                        input: this.input
                    });
                    this.$element.editableContainer(n), this.$element.on("save.internal", e.proxy(this.save, this)), this.container = this.$element.data("editableContainer");
                }
                this.container.show(t);
            }
        },
        hide: function() {
            this.container && this.container.hide();
        },
        toggle: function(e) {
            this.container && this.container.tip().is(":visible") ? this.hide() : this.show(e);
        },
        save: function(e, t) {
            if (this.options.unsavedclass) {
                var n = !1;
                n = n || "function" == typeof this.options.url, n = n || this.options.display === !1, n = n || void 0 !== t.response, n = n || this.options.savenochange && this.input.value2str(this.value) !== this.input.value2str(t.newValue), n ? this.$element.removeClass(this.options.unsavedclass) : this.$element.addClass(this.options.unsavedclass);
            }
            if (this.options.highlight) {
                var r = this.$element, i = r.css("background-color");
                r.css("background-color", this.options.highlight), setTimeout(function() {
                    "transparent" === i && (i = ""), r.css("background-color", i), r.addClass("editable-bg-transition"), setTimeout(function() {
                        r.removeClass("editable-bg-transition");
                    }, 1700);
                }, 10);
            }
            this.setValue(t.newValue, !1, t.response);
        },
        validate: function() {
            return "function" == typeof this.options.validate ? this.options.validate.call(this, this.value) : void 0;
        },
        setValue: function(t, n, r) {
            this.value = n ? this.input.str2value(t) : t, this.container && this.container.option("value", this.value), e.when(this.render(r)).then(e.proxy(function() {
                this.handleEmpty();
            }, this));
        },
        activate: function() {
            this.container && this.container.activate();
        },
        destroy: function() {
            this.disable(), this.container && this.container.destroy(), this.input.destroy(), "manual" !== this.options.toggle && (this.$element.removeClass("editable-click"), this.$element.off(this.options.toggle + ".editable")), this.$element.off("save.internal"), this.$element.removeClass("editable editable-open editable-disabled"), this.$element.removeData("editable");
        }
    }, e.fn.editable = function(n) {
        var r = {}, i = arguments, s = "editable";
        switch (n) {
          case "validate":
            return this.each(function() {
                var t, n = e(this), i = n.data(s);
                i && (t = i.validate()) && (r[i.options.name] = t);
            }), r;
          case "getValue":
            return 2 === arguments.length && arguments[1] === !0 ? r = this.eq(0).data(s).value : this.each(function() {
                var t = e(this), n = t.data(s);
                n && void 0 !== n.value && null !== n.value && (r[n.options.name] = n.input.value2submit(n.value));
            }), r;
          case "submit":
            var o, u = arguments[1] || {}, f = this, l = this.editable("validate");
            return e.isEmptyObject(l) ? (o = this.editable("getValue"), u.data && e.extend(o, u.data), e.ajax(e.extend({
                url: u.url,
                data: o,
                type: "POST"
            }, u.ajaxOptions)).success(function(e) {
                "function" == typeof u.success && u.success.call(f, e, u);
            }).error(function() {
                "function" == typeof u.error && u.error.apply(f, arguments);
            })) : "function" == typeof u.error && u.error.call(f, l), this;
        }
        return this.each(function() {
            var r = e(this), o = r.data(s), u = "object" == typeof n && n;
            return u && u.selector ? (o = new t(this, u), void 0) : (o || r.data(s, o = new t(this, u)), "string" == typeof n && o[n].apply(o, Array.prototype.slice.call(i, 1)), void 0);
        });
    }, e.fn.editable.defaults = {
        type: "text",
        disabled: !1,
        toggle: "click",
        emptytext: "Empty",
        autotext: "auto",
        value: null,
        display: null,
        emptyclass: "editable-empty",
        unsavedclass: "editable-unsaved",
        selector: null,
        highlight: "#FFFF80"
    };
}(window.jQuery), function(e) {
    "use strict";
    e.fn.editabletypes = {};
    var t = function() {};
    t.prototype = {
        init: function(t, n, r) {
            this.type = t, this.options = e.extend({}, r, n);
        },
        prerender: function() {
            this.$tpl = e(this.options.tpl), this.$input = this.$tpl, this.$clear = null, this.error = null;
        },
        render: function() {},
        value2html: function(t, n) {
            e(n)[this.options.escape ? "text" : "html"](e.trim(t));
        },
        html2value: function(t) {
            return e("<div>").html(t).text();
        },
        value2str: function(e) {
            return e;
        },
        str2value: function(e) {
            return e;
        },
        value2submit: function(e) {
            return e;
        },
        value2input: function(e) {
            this.$input.val(e);
        },
        input2value: function() {
            return this.$input.val();
        },
        activate: function() {
            this.$input.is(":visible") && this.$input.focus();
        },
        clear: function() {
            this.$input.val(null);
        },
        escape: function(t) {
            return e("<div>").text(t).html();
        },
        autosubmit: function() {},
        destroy: function() {},
        setClass: function() {
            this.options.inputclass && this.$input.addClass(this.options.inputclass);
        },
        setAttr: function(e) {
            void 0 !== this.options[e] && null !== this.options[e] && this.$input.attr(e, this.options[e]);
        },
        option: function(e, t) {
            this.options[e] = t;
        }
    }, t.defaults = {
        tpl: "",
        inputclass: null,
        escape: !0,
        scope: null,
        showbuttons: !0
    }, e.extend(e.fn.editabletypes, {
        abstractinput: t
    });
}(window.jQuery), function(e) {
    "use strict";
    var t = function() {};
    e.fn.editableutils.inherit(t, e.fn.editabletypes.abstractinput), e.extend(t.prototype, {
        render: function() {
            var t = e.Deferred();
            return this.error = null, this.onSourceReady(function() {
                this.renderList(), t.resolve();
            }, function() {
                this.error = this.options.sourceError, t.resolve();
            }), t.promise();
        },
        html2value: function() {
            return null;
        },
        value2html: function(t, n, r, i) {
            var s = e.Deferred(), o = function() {
                "function" == typeof r ? r.call(n, t, this.sourceData, i) : this.value2htmlFinal(t, n), s.resolve();
            };
            return null === t ? o.call(this) : this.onSourceReady(o, function() {
                s.resolve();
            }), s.promise();
        },
        onSourceReady: function(t, n) {
            var r;
            if (e.isFunction(this.options.source) ? (r = this.options.source.call(this.options.scope), this.sourceData = null) : r = this.options.source, this.options.sourceCache && e.isArray(this.sourceData)) return t.call(this), void 0;
            try {
                r = e.fn.editableutils.tryParseJson(r, !1);
            } catch (i) {
                return n.call(this), void 0;
            }
            if ("string" == typeof r) {
                if (this.options.sourceCache) {
                    var s, o = r;
                    if (e(document).data(o) || e(document).data(o, {}), s = e(document).data(o), s.loading === !1 && s.sourceData) return this.sourceData = s.sourceData, this.doPrepend(), t.call(this), void 0;
                    if (s.loading === !0) return s.callbacks.push(e.proxy(function() {
                        this.sourceData = s.sourceData, this.doPrepend(), t.call(this);
                    }, this)), s.err_callbacks.push(e.proxy(n, this)), void 0;
                    s.loading = !0, s.callbacks = [], s.err_callbacks = [];
                }
                var u = e.extend({
                    url: r,
                    type: "get",
                    cache: !1,
                    dataType: "json",
                    success: e.proxy(function(r) {
                        s && (s.loading = !1), this.sourceData = this.makeArray(r), e.isArray(this.sourceData) ? (s && (s.sourceData = this.sourceData, e.each(s.callbacks, function() {
                            this.call();
                        })), this.doPrepend(), t.call(this)) : (n.call(this), s && e.each(s.err_callbacks, function() {
                            this.call();
                        }));
                    }, this),
                    error: e.proxy(function() {
                        n.call(this), s && (s.loading = !1, e.each(s.err_callbacks, function() {
                            this.call();
                        }));
                    }, this)
                }, this.options.sourceOptions);
                e.ajax(u);
            } else this.sourceData = this.makeArray(r), e.isArray(this.sourceData) ? (this.doPrepend(), t.call(this)) : n.call(this);
        },
        doPrepend: function() {
            null !== this.options.prepend && void 0 !== this.options.prepend && (e.isArray(this.prependData) || (e.isFunction(this.options.prepend) && (this.options.prepend = this.options.prepend.call(this.options.scope)), this.options.prepend = e.fn.editableutils.tryParseJson(this.options.prepend, !0), "string" == typeof this.options.prepend && (this.options.prepend = {
                "": this.options.prepend
            }), this.prependData = this.makeArray(this.options.prepend)), e.isArray(this.prependData) && e.isArray(this.sourceData) && (this.sourceData = this.prependData.concat(this.sourceData)));
        },
        renderList: function() {},
        value2htmlFinal: function() {},
        makeArray: function(t) {
            var n, r, i, s, o = [];
            if (!t || "string" == typeof t) return null;
            if (e.isArray(t)) {
                s = function(e, t) {
                    return r = {
                        value: e,
                        text: t
                    }, n++ >= 2 ? !1 : void 0;
                };
                for (var u = 0; u < t.length; u++) i = t[u], "object" == typeof i ? (n = 0, e.each(i, s), 1 === n ? o.push(r) : n > 1 && (i.children && (i.children = this.makeArray(i.children)), o.push(i))) : o.push({
                    value: i,
                    text: i
                });
            } else e.each(t, function(e, t) {
                o.push({
                    value: e,
                    text: t
                });
            });
            return o;
        },
        option: function(e, t) {
            this.options[e] = t, "source" === e && (this.sourceData = null), "prepend" === e && (this.prependData = null);
        }
    }), t.defaults = e.extend({}, e.fn.editabletypes.abstractinput.defaults, {
        source: null,
        prepend: !1,
        sourceError: "Error when loading list",
        sourceCache: !0,
        sourceOptions: null
    }), e.fn.editabletypes.list = t;
}(window.jQuery), function(e) {
    "use strict";
    var t = function(e) {
        this.init("text", e, t.defaults);
    };
    e.fn.editableutils.inherit(t, e.fn.editabletypes.abstractinput), e.extend(t.prototype, {
        render: function() {
            this.renderClear(), this.setClass(), this.setAttr("placeholder");
        },
        activate: function() {
            this.$input.is(":visible") && (this.$input.focus(), e.fn.editableutils.setCursorPosition(this.$input.get(0), this.$input.val().length), this.toggleClear && this.toggleClear());
        },
        renderClear: function() {
            this.options.clear && (this.$clear = e('<span class="editable-clear-x"></span>'), this.$input.after(this.$clear).css("padding-right", 24).keyup(e.proxy(function(t) {
                if (!~e.inArray(t.keyCode, [ 40, 38, 9, 13, 27 ])) {
                    clearTimeout(this.t);
                    var n = this;
                    this.t = setTimeout(function() {
                        n.toggleClear(t);
                    }, 100);
                }
            }, this)).parent().css("position", "relative"), this.$clear.click(e.proxy(this.clear, this)));
        },
        postrender: function() {},
        toggleClear: function() {
            if (this.$clear) {
                var e = this.$input.val().length, t = this.$clear.is(":visible");
                e && !t && this.$clear.show(), !e && t && this.$clear.hide();
            }
        },
        clear: function() {
            this.$clear.hide(), this.$input.val("").focus();
        }
    }), t.defaults = e.extend({}, e.fn.editabletypes.abstractinput.defaults, {
        tpl: '<input type="text">',
        placeholder: null,
        clear: !0
    }), e.fn.editabletypes.text = t;
}(window.jQuery), function(e) {
    "use strict";
    var t = function(e) {
        this.init("textarea", e, t.defaults);
    };
    e.fn.editableutils.inherit(t, e.fn.editabletypes.abstractinput), e.extend(t.prototype, {
        render: function() {
            this.setClass(), this.setAttr("placeholder"), this.setAttr("rows"), this.$input.keydown(function(t) {
                t.ctrlKey && 13 === t.which && e(this).closest("form").submit();
            });
        },
        activate: function() {
            e.fn.editabletypes.text.prototype.activate.call(this);
        }
    }), t.defaults = e.extend({}, e.fn.editabletypes.abstractinput.defaults, {
        tpl: "<textarea></textarea>",
        inputclass: "input-large",
        placeholder: null,
        rows: 7
    }), e.fn.editabletypes.textarea = t;
}(window.jQuery), function(e) {
    "use strict";
    var t = function(e) {
        this.init("select", e, t.defaults);
    };
    e.fn.editableutils.inherit(t, e.fn.editabletypes.list), e.extend(t.prototype, {
        renderList: function() {
            this.$input.empty();
            var t = function(n, r) {
                var i;
                if (e.isArray(r)) for (var s = 0; s < r.length; s++) i = {}, r[s].children ? (i.label = r[s].text, n.append(t(e("<optgroup>", i), r[s].children))) : (i.value = r[s].value, r[s].disabled && (i.disabled = !0), n.append(e("<option>", i).text(r[s].text)));
                return n;
            };
            t(this.$input, this.sourceData), this.setClass(), this.$input.on("keydown.editable", function(t) {
                13 === t.which && e(this).closest("form").submit();
            });
        },
        value2htmlFinal: function(t, n) {
            var r = "", i = e.fn.editableutils.itemsByValue(t, this.sourceData);
            i.length && (r = i[0].text), e.fn.editabletypes.abstractinput.prototype.value2html.call(this, r, n);
        },
        autosubmit: function() {
            this.$input.off("keydown.editable").on("change.editable", function() {
                e(this).closest("form").submit();
            });
        }
    }), t.defaults = e.extend({}, e.fn.editabletypes.list.defaults, {
        tpl: "<select></select>"
    }), e.fn.editabletypes.select = t;
}(window.jQuery), function(e) {
    "use strict";
    var t = function(e) {
        this.init("checklist", e, t.defaults);
    };
    e.fn.editableutils.inherit(t, e.fn.editabletypes.list), e.extend(t.prototype, {
        renderList: function() {
            var t;
            if (this.$tpl.empty(), e.isArray(this.sourceData)) {
                for (var n = 0; n < this.sourceData.length; n++) t = e("<label>").append(e("<input>", {
                    type: "checkbox",
                    value: this.sourceData[n].value
                })).append(e("<span>").text(" " + this.sourceData[n].text)), e("<div>").append(t).appendTo(this.$tpl);
                this.$input = this.$tpl.find('input[type="checkbox"]'), this.setClass();
            }
        },
        value2str: function(t) {
            return e.isArray(t) ? t.sort().join(e.trim(this.options.separator)) : "";
        },
        str2value: function(t) {
            var n, r = null;
            return "string" == typeof t && t.length ? (n = new RegExp("\\s*" + e.trim(this.options.separator) + "\\s*"), r = t.split(n)) : r = e.isArray(t) ? t : [ t ], r;
        },
        value2input: function(t) {
            this.$input.prop("checked", !1), e.isArray(t) && t.length && this.$input.each(function(n, r) {
                var i = e(r);
                e.each(t, function(e, t) {
                    i.val() == t && i.prop("checked", !0);
                });
            });
        },
        input2value: function() {
            var t = [];
            return this.$input.filter(":checked").each(function(n, r) {
                t.push(e(r).val());
            }), t;
        },
        value2htmlFinal: function(t, n) {
            var r = [], i = e.fn.editableutils.itemsByValue(t, this.sourceData), s = this.options.escape;
            i.length ? (e.each(i, function(t, n) {
                var i = s ? e.fn.editableutils.escape(n.text) : n.text;
                r.push(i);
            }), e(n).html(r.join("<br>"))) : e(n).empty();
        },
        activate: function() {
            this.$input.first().focus();
        },
        autosubmit: function() {
            this.$input.on("keydown", function(t) {
                13 === t.which && e(this).closest("form").submit();
            });
        }
    }), t.defaults = e.extend({}, e.fn.editabletypes.list.defaults, {
        tpl: '<div class="editable-checklist"></div>',
        inputclass: null,
        separator: ","
    }), e.fn.editabletypes.checklist = t;
}(window.jQuery), function(e) {
    "use strict";
    var t = function(e) {
        this.init("password", e, t.defaults);
    };
    e.fn.editableutils.inherit(t, e.fn.editabletypes.text), e.extend(t.prototype, {
        value2html: function(t, n) {
            t ? e(n).text("[hidden]") : e(n).empty();
        },
        html2value: function() {
            return null;
        }
    }), t.defaults = e.extend({}, e.fn.editabletypes.text.defaults, {
        tpl: '<input type="password">'
    }), e.fn.editabletypes.password = t;
}(window.jQuery), function(e) {
    "use strict";
    var t = function(e) {
        this.init("email", e, t.defaults);
    };
    e.fn.editableutils.inherit(t, e.fn.editabletypes.text), t.defaults = e.extend({}, e.fn.editabletypes.text.defaults, {
        tpl: '<input type="email">'
    }), e.fn.editabletypes.email = t;
}(window.jQuery), function(e) {
    "use strict";
    var t = function(e) {
        this.init("url", e, t.defaults);
    };
    e.fn.editableutils.inherit(t, e.fn.editabletypes.text), t.defaults = e.extend({}, e.fn.editabletypes.text.defaults, {
        tpl: '<input type="url">'
    }), e.fn.editabletypes.url = t;
}(window.jQuery), function(e) {
    "use strict";
    var t = function(e) {
        this.init("tel", e, t.defaults);
    };
    e.fn.editableutils.inherit(t, e.fn.editabletypes.text), t.defaults = e.extend({}, e.fn.editabletypes.text.defaults, {
        tpl: '<input type="tel">'
    }), e.fn.editabletypes.tel = t;
}(window.jQuery), function(e) {
    "use strict";
    var t = function(e) {
        this.init("number", e, t.defaults);
    };
    e.fn.editableutils.inherit(t, e.fn.editabletypes.text), e.extend(t.prototype, {
        render: function() {
            t.superclass.render.call(this), this.setAttr("min"), this.setAttr("max"), this.setAttr("step");
        },
        postrender: function() {
            this.$clear && this.$clear.css({
                right: 24
            });
        }
    }), t.defaults = e.extend({}, e.fn.editabletypes.text.defaults, {
        tpl: '<input type="number">',
        inputclass: "input-mini",
        min: null,
        max: null,
        step: null
    }), e.fn.editabletypes.number = t;
}(window.jQuery), function(e) {
    "use strict";
    var t = function(e) {
        this.init("range", e, t.defaults);
    };
    e.fn.editableutils.inherit(t, e.fn.editabletypes.number), e.extend(t.prototype, {
        render: function() {
            this.$input = this.$tpl.filter("input"), this.setClass(), this.setAttr("min"), this.setAttr("max"), this.setAttr("step"), this.$input.on("input", function() {
                e(this).siblings("output").text(e(this).val());
            });
        },
        activate: function() {
            this.$input.focus();
        }
    }), t.defaults = e.extend({}, e.fn.editabletypes.number.defaults, {
        tpl: '<input type="range"><output style="width: 30px; display: inline-block"></output>',
        inputclass: "input-medium"
    }), e.fn.editabletypes.range = t;
}(window.jQuery), function(e) {
    "use strict";
    var t = function(e) {
        this.init("time", e, t.defaults);
    };
    e.fn.editableutils.inherit(t, e.fn.editabletypes.abstractinput), e.extend(t.prototype, {
        render: function() {
            this.setClass();
        }
    }), t.defaults = e.extend({}, e.fn.editabletypes.abstractinput.defaults, {
        tpl: '<input type="time">'
    }), e.fn.editabletypes.time = t;
}(window.jQuery), function(e) {
    "use strict";
    var t = function(n) {
        if (this.init("select2", n, t.defaults), n.select2 = n.select2 || {}, this.sourceData = null, n.placeholder && (n.select2.placeholder = n.placeholder), !n.select2.tags && n.source) {
            var r = n.source;
            e.isFunction(n.source) && (r = n.source.call(n.scope)), "string" == typeof r ? (n.select2.ajax = n.select2.ajax || {}, n.select2.ajax.data || (n.select2.ajax.data = function(e) {
                return {
                    query: e
                };
            }), n.select2.ajax.results || (n.select2.ajax.results = function(e) {
                return {
                    results: e
                };
            }), n.select2.ajax.url = r) : (this.sourceData = this.convertSource(r), n.select2.data = this.sourceData);
        }
        if (this.options.select2 = e.extend({}, t.defaults.select2, n.select2), this.isMultiple = this.options.select2.tags || this.options.select2.multiple, this.isRemote = "ajax" in this.options.select2, this.idFunc = this.options.select2.id, "function" != typeof this.idFunc) {
            var i = this.idFunc || "id";
            this.idFunc = function(e) {
                return e[i];
            };
        }
        this.formatSelection = this.options.select2.formatSelection, "function" != typeof this.formatSelection && (this.formatSelection = function(e) {
            return e.text;
        });
    };
    e.fn.editableutils.inherit(t, e.fn.editabletypes.abstractinput), e.extend(t.prototype, {
        render: function() {
            this.setClass(), this.isRemote && this.$input.on("select2-loaded", e.proxy(function(e) {
                this.sourceData = e.items.results;
            }, this)), this.isMultiple && this.$input.on("change", function() {
                e(this).closest("form").parent().triggerHandler("resize");
            });
        },
        value2html: function(n, r) {
            var i, s = "", o = this;
            this.options.select2.tags ? i = n : this.sourceData && (i = e.fn.editableutils.itemsByValue(n, this.sourceData, this.idFunc)), e.isArray(i) ? (s = [], e.each(i, function(e, t) {
                s.push(t && "object" == typeof t ? o.formatSelection(t) : t);
            })) : i && (s = o.formatSelection(i)), s = e.isArray(s) ? s.join(this.options.viewseparator) : s, t.superclass.value2html.call(this, s, r);
        },
        html2value: function(e) {
            return this.options.select2.tags ? this.str2value(e, this.options.viewseparator) : null;
        },
        value2input: function(t) {
            if (this.$input.data("select2") ? this.$input.val(t).trigger("change", !0) : (this.$input.val(t), this.$input.select2(this.options.select2)), this.isRemote && !this.isMultiple && !this.options.select2.initSelection) {
                var n = this.options.select2.id, r = this.options.select2.formatSelection;
                if (!n && !r) {
                    var i = {
                        id: t,
                        text: e(this.options.scope).text()
                    };
                    this.$input.select2("data", i);
                }
            }
        },
        input2value: function() {
            return this.$input.select2("val");
        },
        str2value: function(t, n) {
            if ("string" != typeof t || !this.isMultiple) return t;
            n = n || this.options.select2.separator || e.fn.select2.defaults.separator;
            var r, i, s;
            if (null === t || t.length < 1) return null;
            for (r = t.split(n), i = 0, s = r.length; s > i; i += 1) r[i] = e.trim(r[i]);
            return r;
        },
        autosubmit: function() {
            this.$input.on("change", function(t, n) {
                n || e(this).closest("form").submit();
            });
        },
        convertSource: function(t) {
            if (e.isArray(t) && t.length && void 0 !== t[0].value) for (var n = 0; n < t.length; n++) void 0 !== t[n].value && (t[n].id = t[n].value, delete t[n].value);
            return t;
        },
        destroy: function() {
            this.$input.data("select2") && this.$input.select2("destroy");
        }
    }), t.defaults = e.extend({}, e.fn.editabletypes.abstractinput.defaults, {
        tpl: '<input type="hidden">',
        select2: null,
        placeholder: null,
        source: null,
        viewseparator: ", "
    }), e.fn.editabletypes.select2 = t;
}(window.jQuery), function(e) {
    var t = function(t, n) {
        return this.$element = e(t), this.$element.is("input") ? (this.options = e.extend({}, e.fn.combodate.defaults, n, this.$element.data()), this.init(), void 0) : (e.error("Combodate should be applied to INPUT element"), void 0);
    };
    t.prototype = {
        constructor: t,
        init: function() {
            this.map = {
                day: [ "D", "date" ],
                month: [ "M", "month" ],
                year: [ "Y", "year" ],
                hour: [ "[Hh]", "hours" ],
                minute: [ "m", "minutes" ],
                second: [ "s", "seconds" ],
                ampm: [ "[Aa]", "" ]
            }, this.$widget = e('<span class="combodate"></span>').html(this.getTemplate()), this.initCombos(), this.$widget.on("change", "select", e.proxy(function() {
                this.$element.val(this.getValue());
            }, this)), this.$widget.find("select").css("width", "auto"), this.$element.hide().after(this.$widget), this.setValue(this.$element.val() || this.options.value);
        },
        getTemplate: function() {
            var t = this.options.template;
            return e.each(this.map, function(e, n) {
                n = n[0];
                var r = new RegExp(n + "+"), i = n.length > 1 ? n.substring(1, 2) : n;
                t = t.replace(r, "{" + i + "}");
            }), t = t.replace(/ /g, "&nbsp;"), e.each(this.map, function(e, n) {
                n = n[0];
                var r = n.length > 1 ? n.substring(1, 2) : n;
                t = t.replace("{" + r + "}", '<select class="' + e + '"></select>');
            }), t;
        },
        initCombos: function() {
            var t = this;
            e.each(this.map, function(e) {
                var n, r, i = t.$widget.find("." + e);
                i.length && (t["$" + e] = i, n = "fill" + e.charAt(0).toUpperCase() + e.slice(1), r = t[n](), t["$" + e].html(t.renderItems(r)));
            });
        },
        initItems: function(e) {
            var t, n = [];
            if ("name" === this.options.firstItem) {
                t = moment.relativeTime || moment.langData()._relativeTime;
                var r = "function" == typeof t[e] ? t[e](1, !0, e, !1) : t[e];
                r = r.split(" ").reverse()[0], n.push([ "", r ]);
            } else "empty" === this.options.firstItem && n.push([ "", "" ]);
            return n;
        },
        renderItems: function(e) {
            for (var t = [], n = 0; n < e.length; n++) t.push('<option value="' + e[n][0] + '">' + e[n][1] + "</option>");
            return t.join("\n");
        },
        fillDay: function() {
            var e, t, n = this.initItems("d"), r = -1 !== this.options.template.indexOf("DD");
            for (t = 1; 31 >= t; t++) e = r ? this.leadZero(t) : t, n.push([ t, e ]);
            return n;
        },
        fillMonth: function() {
            var e, t, n = this.initItems("M"), r = -1 !== this.options.template.indexOf("MMMM"), i = -1 !== this.options.template.indexOf("MMM"), s = -1 !== this.options.template.indexOf("MM");
            for (t = 0; 11 >= t; t++) e = r ? moment().date(1).month(t).format("MMMM") : i ? moment().date(1).month(t).format("MMM") : s ? this.leadZero(t + 1) : t + 1, n.push([ t, e ]);
            return n;
        },
        fillYear: function() {
            var e, t, n = [], r = -1 !== this.options.template.indexOf("YYYY");
            for (t = this.options.maxYear; t >= this.options.minYear; t--) e = r ? t : (t + "").substring(2), n[this.options.yearDescending ? "push" : "unshift"]([ t, e ]);
            return n = this.initItems("y").concat(n);
        },
        fillHour: function() {
            var e, t, n = this.initItems("h"), r = -1 !== this.options.template.indexOf("h"), i = (-1 !== this.options.template.indexOf("H"), -1 !== this.options.template.toLowerCase().indexOf("hh")), s = r ? 1 : 0, o = r ? 12 : 23;
            for (t = s; o >= t; t++) e = i ? this.leadZero(t) : t, n.push([ t, e ]);
            return n;
        },
        fillMinute: function() {
            var e, t, n = this.initItems("m"), r = -1 !== this.options.template.indexOf("mm");
            for (t = 0; 59 >= t; t += this.options.minuteStep) e = r ? this.leadZero(t) : t, n.push([ t, e ]);
            return n;
        },
        fillSecond: function() {
            var e, t, n = this.initItems("s"), r = -1 !== this.options.template.indexOf("ss");
            for (t = 0; 59 >= t; t += this.options.secondStep) e = r ? this.leadZero(t) : t, n.push([ t, e ]);
            return n;
        },
        fillAmpm: function() {
            var e = -1 !== this.options.template.indexOf("a"), t = (-1 !== this.options.template.indexOf("A"), [ [ "am", e ? "am" : "AM" ], [ "pm", e ? "pm" : "PM" ] ]);
            return t;
        },
        getValue: function(t) {
            var n, r = {}, i = this, s = !1;
            return e.each(this.map, function(e) {
                if ("ampm" !== e) {
                    var t = "day" === e ? 1 : 0;
                    return r[e] = i["$" + e] ? parseInt(i["$" + e].val(), 10) : t, isNaN(r[e]) ? (s = !0, !1) : void 0;
                }
            }), s ? "" : (this.$ampm && (r.hour = 12 === r.hour ? "am" === this.$ampm.val() ? 0 : 12 : "am" === this.$ampm.val() ? r.hour : r.hour + 12), n = moment([ r.year, r.month, r.day, r.hour, r.minute, r.second ]), this.highlight(n), t = void 0 === t ? this.options.format : t, null === t ? n.isValid() ? n : null : n.isValid() ? n.format(t) : "");
        },
        setValue: function(t) {
            function n(t, n) {
                var r = {};
                return t.children("option").each(function(t, i) {
                    var s, o = e(i).attr("value");
                    "" !== o && (s = Math.abs(o - n), ("undefined" == typeof r.distance || s < r.distance) && (r = {
                        value: o,
                        distance: s
                    }));
                }), r.value;
            }
            if (t) {
                var r = "string" == typeof t ? moment(t, this.options.format) : moment(t), i = this, s = {};
                r.isValid() && (e.each(this.map, function(e, t) {
                    "ampm" !== e && (s[e] = r[t[1]]());
                }), this.$ampm && (s.hour >= 12 ? (s.ampm = "pm", s.hour > 12 && (s.hour -= 12)) : (s.ampm = "am", 0 === s.hour && (s.hour = 12))), e.each(s, function(e, t) {
                    i["$" + e] && ("minute" === e && i.options.minuteStep > 1 && i.options.roundTime && (t = n(i["$" + e], t)), "second" === e && i.options.secondStep > 1 && i.options.roundTime && (t = n(i["$" + e], t)), i["$" + e].val(t));
                }), this.$element.val(r.format(this.options.format)));
            }
        },
        highlight: function(e) {
            e.isValid() ? this.options.errorClass ? this.$widget.removeClass(this.options.errorClass) : this.$widget.find("select").css("border-color", this.borderColor) : this.options.errorClass ? this.$widget.addClass(this.options.errorClass) : (this.borderColor || (this.borderColor = this.$widget.find("select").css("border-color")), this.$widget.find("select").css("border-color", "red"));
        },
        leadZero: function(e) {
            return 9 >= e ? "0" + e : e;
        },
        destroy: function() {
            this.$widget.remove(), this.$element.removeData("combodate").show();
        }
    }, e.fn.combodate = function(n) {
        var r, i = Array.apply(null, arguments);
        return i.shift(), "getValue" === n && this.length && (r = this.eq(0).data("combodate")) ? r.getValue.apply(r, i) : this.each(function() {
            var r = e(this), s = r.data("combodate"), o = "object" == typeof n && n;
            s || r.data("combodate", s = new t(this, o)), "string" == typeof n && "function" == typeof s[n] && s[n].apply(s, i);
        });
    }, e.fn.combodate.defaults = {
        format: "DD-MM-YYYY HH:mm",
        template: "D / MMM / YYYY   H : mm",
        value: null,
        minYear: 1970,
        maxYear: 2015,
        yearDescending: !0,
        minuteStep: 5,
        secondStep: 1,
        firstItem: "empty",
        errorClass: null,
        roundTime: !0
    };
}(window.jQuery), function(e) {
    "use strict";
    var t = function(n) {
        this.init("combodate", n, t.defaults), this.options.viewformat || (this.options.viewformat = this.options.format), n.combodate = e.fn.editableutils.tryParseJson(n.combodate, !0), this.options.combodate = e.extend({}, t.defaults.combodate, n.combodate, {
            format: this.options.format,
            template: this.options.template
        });
    };
    e.fn.editableutils.inherit(t, e.fn.editabletypes.abstractinput), e.extend(t.prototype, {
        render: function() {
            this.$input.combodate(this.options.combodate), "bs3" === e.fn.editableform.engine && this.$input.siblings().find("select").addClass("form-control"), this.options.inputclass && this.$input.siblings().find("select").addClass(this.options.inputclass);
        },
        value2html: function(e, n) {
            var r = e ? e.format(this.options.viewformat) : "";
            t.superclass.value2html.call(this, r, n);
        },
        html2value: function(e) {
            return e ? moment(e, this.options.viewformat) : null;
        },
        value2str: function(e) {
            return e ? e.format(this.options.format) : "";
        },
        str2value: function(e) {
            return e ? moment(e, this.options.format) : null;
        },
        value2submit: function(e) {
            return this.value2str(e);
        },
        value2input: function(e) {
            this.$input.combodate("setValue", e);
        },
        input2value: function() {
            return this.$input.combodate("getValue", null);
        },
        activate: function() {
            this.$input.siblings(".combodate").find("select").eq(0).focus();
        },
        autosubmit: function() {}
    }), t.defaults = e.extend({}, e.fn.editabletypes.abstractinput.defaults, {
        tpl: '<input type="text">',
        inputclass: null,
        format: "YYYY-MM-DD",
        viewformat: null,
        template: "D / MMM / YYYY",
        combodate: null
    }), e.fn.editabletypes.combodate = t;
}(window.jQuery), function(e) {
    "use strict";
    var t = e.fn.editableform.Constructor.prototype.initInput;
    e.extend(e.fn.editableform.Constructor.prototype, {
        initTemplate: function() {
            this.$form = e(e.fn.editableform.template), this.$form.find(".control-group").addClass("form-group"), this.$form.find(".editable-error-block").addClass("help-block");
        },
        initInput: function() {
            t.apply(this);
            var n = null === this.input.options.inputclass || this.input.options.inputclass === !1, r = "input-sm", i = "text,select,textarea,password,email,url,tel,number,range,time,typeaheadjs".split(",");
            ~e.inArray(this.input.type, i) && (this.input.$input.addClass("form-control"), n && (this.input.options.inputclass = r, this.input.$input.addClass(r)));
            for (var s = this.$form.find(".editable-buttons"), o = n ? [ r ] : this.input.options.inputclass.split(" "), u = 0; u < o.length; u++) "input-lg" === o[u].toLowerCase() && s.find("button").removeClass("btn-sm").addClass("btn-lg");
        }
    }), e.fn.editableform.buttons = '<button type="submit" class="btn btn-primary btn-sm editable-submit"><i class="glyphicon glyphicon-ok"></i></button><button type="button" class="btn btn-default btn-sm editable-cancel"><i class="fa fa-times"></i></button>', e.fn.editableform.errorGroupClass = "has-error", e.fn.editableform.errorBlockClass = null, e.fn.editableform.engine = "bs3";
}(window.jQuery), function(e) {
    "use strict";
    e.extend(e.fn.editableContainer.Popup.prototype, {
        containerName: "popover",
        containerDataName: "bs.popover",
        innerCss: ".popover-content",
        defaults: e.fn.popover.Constructor.DEFAULTS,
        initContainer: function() {
            e.extend(this.containerOptions, {
                trigger: "manual",
                selector: !1,
                content: " ",
                template: this.defaults.template
            });
            var t;
            this.$element.data("template") && (t = this.$element.data("template"), this.$element.removeData("template")), this.call(this.containerOptions), t && this.$element.data("template", t);
        },
        innerShow: function() {
            this.call("show");
        },
        innerHide: function() {
            this.call("hide");
        },
        innerDestroy: function() {
            this.call("destroy");
        },
        setContainerOption: function(e, t) {
            this.container().options[e] = t;
        },
        setPosition: function() {
            !function() {
                var e = this.tip(), t = "function" == typeof this.options.placement ? this.options.placement.call(this, e[0], this.$element[0]) : this.options.placement, n = this.getPosition(), r = e[0].offsetWidth, i = e[0].offsetHeight, s = this.getCalculatedOffset(t, n, r, i);
                this.applyPlacement(s, t);
            }.call(this.container());
        }
    });
}(window.jQuery), function(e) {
    function t() {
        return new Date(Date.UTC.apply(Date, arguments));
    }
    function n(t, n) {
        var r, i = e(t).data(), s = {}, o = new RegExp("^" + n.toLowerCase() + "([A-Z])"), n = new RegExp("^" + n.toLowerCase());
        for (var u in i) n.test(u) && (r = u.replace(o, function(e, t) {
            return t.toLowerCase();
        }), s[r] = i[u]);
        return s;
    }
    function r(t) {
        var n = {};
        if (l[t] || (t = t.split("-")[0], l[t])) {
            var r = l[t];
            return e.each(f, function(e, t) {
                t in r && (n[t] = r[t]);
            }), n;
        }
    }
    var i = function(t, n) {
        this._process_options(n), this.element = e(t), this.isInline = !1, this.isInput = this.element.is("input"), this.component = this.element.is(".date") ? this.element.find(".add-on, .btn") : !1, this.hasInput = this.component && this.element.find("input").length, this.component && 0 === this.component.length && (this.component = !1), this.picker = e(c.template), this._buildEvents(), this._attachEvents(), this.isInline ? this.picker.addClass("datepicker-inline").appendTo(this.element) : this.picker.addClass("datepicker-dropdown dropdown-menu"), this.o.rtl && (this.picker.addClass("datepicker-rtl"), this.picker.find(".prev i, .next i").toggleClass("icon-arrow-left icon-arrow-right")), this.viewMode = this.o.startView, this.o.calendarWeeks && this.picker.find("tfoot th.today").attr("colspan", function(e, t) {
            return parseInt(t) + 1;
        }), this._allow_update = !1, this.setStartDate(this.o.startDate), this.setEndDate(this.o.endDate), this.setDaysOfWeekDisabled(this.o.daysOfWeekDisabled), this.fillDow(), this.fillMonths(), this._allow_update = !0, this.update(), this.showMode(), this.isInline && this.show();
    };
    i.prototype = {
        constructor: i,
        _process_options: function(t) {
            this._o = e.extend({}, this._o, t);
            var n = this.o = e.extend({}, this._o), r = n.language;
            switch (l[r] || (r = r.split("-")[0], l[r] || (r = a.language)), n.language = r, n.startView) {
              case 2:
              case "decade":
                n.startView = 2;
                break;
              case 1:
              case "year":
                n.startView = 1;
                break;
              default:
                n.startView = 0;
            }
            switch (n.minViewMode) {
              case 1:
              case "months":
                n.minViewMode = 1;
                break;
              case 2:
              case "years":
                n.minViewMode = 2;
                break;
              default:
                n.minViewMode = 0;
            }
            n.startView = Math.max(n.startView, n.minViewMode), n.weekStart %= 7, n.weekEnd = (n.weekStart + 6) % 7;
            var i = c.parseFormat(n.format);
            n.startDate !== -1 / 0 && (n.startDate = c.parseDate(n.startDate, i, n.language)), 1 / 0 !== n.endDate && (n.endDate = c.parseDate(n.endDate, i, n.language)), n.daysOfWeekDisabled = n.daysOfWeekDisabled || [], e.isArray(n.daysOfWeekDisabled) || (n.daysOfWeekDisabled = n.daysOfWeekDisabled.split(/[,\s]*/)), n.daysOfWeekDisabled = e.map(n.daysOfWeekDisabled, function(e) {
                return parseInt(e, 10);
            });
        },
        _events: [],
        _secondaryEvents: [],
        _applyEvents: function(e) {
            for (var t, n, r = 0; r < e.length; r++) t = e[r][0], n = e[r][1], t.on(n);
        },
        _unapplyEvents: function(e) {
            for (var t, n, r = 0; r < e.length; r++) t = e[r][0], n = e[r][1], t.off(n);
        },
        _buildEvents: function() {
            this.isInput ? this._events = [ [ this.element, {
                focus: e.proxy(this.show, this),
                keyup: e.proxy(this.update, this),
                keydown: e.proxy(this.keydown, this)
            } ] ] : this.component && this.hasInput ? this._events = [ [ this.element.find("input"), {
                focus: e.proxy(this.show, this),
                keyup: e.proxy(this.update, this),
                keydown: e.proxy(this.keydown, this)
            } ], [ this.component, {
                click: e.proxy(this.show, this)
            } ] ] : this.element.is("div") ? this.isInline = !0 : this._events = [ [ this.element, {
                click: e.proxy(this.show, this)
            } ] ], this._secondaryEvents = [ [ this.picker, {
                click: e.proxy(this.click, this)
            } ], [ e(window), {
                resize: e.proxy(this.place, this)
            } ], [ e(document), {
                mousedown: e.proxy(function(e) {
                    this.element.is(e.target) || this.element.find(e.target).size() || this.picker.is(e.target) || this.picker.find(e.target).size() || this.hide();
                }, this)
            } ] ];
        },
        _attachEvents: function() {
            this._detachEvents(), this._applyEvents(this._events);
        },
        _detachEvents: function() {
            this._unapplyEvents(this._events);
        },
        _attachSecondaryEvents: function() {
            this._detachSecondaryEvents(), this._applyEvents(this._secondaryEvents);
        },
        _detachSecondaryEvents: function() {
            this._unapplyEvents(this._secondaryEvents);
        },
        _trigger: function(t, n) {
            var r = n || this.date, i = new Date(r.getTime() + 6e4 * r.getTimezoneOffset());
            this.element.trigger({
                type: t,
                date: i,
                format: e.proxy(function(e) {
                    var t = e || this.o.format;
                    return c.formatDate(r, t, this.o.language);
                }, this)
            });
        },
        show: function(e) {
            this.isInline || this.picker.appendTo("body"), this.picker.show(), this.height = this.component ? this.component.outerHeight() : this.element.outerHeight(), this.place(), this._attachSecondaryEvents(), e && e.preventDefault(), this._trigger("show");
        },
        hide: function() {
            this.isInline || this.picker.is(":visible") && (this.picker.hide().detach(), this._detachSecondaryEvents(), this.viewMode = this.o.startView, this.showMode(), this.o.forceParse && (this.isInput && this.element.val() || this.hasInput && this.element.find("input").val()) && this.setValue(), this._trigger("hide"));
        },
        remove: function() {
            this.hide(), this._detachEvents(), this._detachSecondaryEvents(), this.picker.remove(), delete this.element.data().datepicker, this.isInput || delete this.element.data().date;
        },
        getDate: function() {
            var e = this.getUTCDate();
            return new Date(e.getTime() + 6e4 * e.getTimezoneOffset());
        },
        getUTCDate: function() {
            return this.date;
        },
        setDate: function(e) {
            this.setUTCDate(new Date(e.getTime() - 6e4 * e.getTimezoneOffset()));
        },
        setUTCDate: function(e) {
            this.date = e, this.setValue();
        },
        setValue: function() {
            var e = this.getFormattedDate();
            this.isInput ? this.element.val(e) : this.component && this.element.find("input").val(e);
        },
        getFormattedDate: function(e) {
            return void 0 === e && (e = this.o.format), c.formatDate(this.date, e, this.o.language);
        },
        setStartDate: function(e) {
            this._process_options({
                startDate: e
            }), this.update(), this.updateNavArrows();
        },
        setEndDate: function(e) {
            this._process_options({
                endDate: e
            }), this.update(), this.updateNavArrows();
        },
        setDaysOfWeekDisabled: function(e) {
            this._process_options({
                daysOfWeekDisabled: e
            }), this.update(), this.updateNavArrows();
        },
        place: function() {
            if (!this.isInline) {
                var t = parseInt(this.element.parents().filter(function() {
                    return "auto" != e(this).css("z-index");
                }).first().css("z-index")) + 10, n = this.component ? this.component.parent().offset() : this.element.offset(), r = this.component ? this.component.outerHeight(!0) : this.element.outerHeight(!0);
                this.picker.css({
                    top: n.top + r,
                    left: n.left,
                    zIndex: t
                });
            }
        },
        _allow_update: !0,
        update: function() {
            if (this._allow_update) {
                var e, t = !1;
                arguments && arguments.length && ("string" == typeof arguments[0] || arguments[0] instanceof Date) ? (e = arguments[0], t = !0) : (e = this.isInput ? this.element.val() : this.element.data("date") || this.element.find("input").val(), delete this.element.data().date), this.date = c.parseDate(e, this.o.format, this.o.language), t && this.setValue(), this.viewDate = this.date < this.o.startDate ? new Date(this.o.startDate) : this.date > this.o.endDate ? new Date(this.o.endDate) : new Date(this.date), this.fill();
            }
        },
        fillDow: function() {
            var e = this.o.weekStart, t = "<tr>";
            if (this.o.calendarWeeks) {
                var n = '<th class="cw">&nbsp;</th>';
                t += n, this.picker.find(".datepicker-days thead tr:first-child").prepend(n);
            }
            for (; e < this.o.weekStart + 7; ) t += '<th class="dow">' + l[this.o.language].daysMin[e++ % 7] + "</th>";
            t += "</tr>", this.picker.find(".datepicker-days thead").append(t);
        },
        fillMonths: function() {
            for (var e = "", t = 0; 12 > t; ) e += '<span class="month">' + l[this.o.language].monthsShort[t++] + "</span>";
            this.picker.find(".datepicker-months td").html(e);
        },
        setRange: function(t) {
            t && t.length ? this.range = e.map(t, function(e) {
                return e.valueOf();
            }) : delete this.range, this.fill();
        },
        getClassNames: function(t) {
            var n = [], r = this.viewDate.getUTCFullYear(), i = this.viewDate.getUTCMonth(), s = this.date.valueOf(), o = new Date;
            return t.getUTCFullYear() < r || t.getUTCFullYear() == r && t.getUTCMonth() < i ? n.push("old") : (t.getUTCFullYear() > r || t.getUTCFullYear() == r && t.getUTCMonth() > i) && n.push("new"), this.o.todayHighlight && t.getUTCFullYear() == o.getFullYear() && t.getUTCMonth() == o.getMonth() && t.getUTCDate() == o.getDate() && n.push("today"), s && t.valueOf() == s && n.push("active"), (t.valueOf() < this.o.startDate || t.valueOf() > this.o.endDate || -1 !== e.inArray(t.getUTCDay(), this.o.daysOfWeekDisabled)) && n.push("disabled"), this.range && (t > this.range[0] && t < this.range[this.range.length - 1] && n.push("range"), -1 != e.inArray(t.valueOf(), this.range) && n.push("selected")), n;
        },
        fill: function() {
            var n, r = new Date(this.viewDate), i = r.getUTCFullYear(), s = r.getUTCMonth(), o = this.o.startDate !== -1 / 0 ? this.o.startDate.getUTCFullYear() : -1 / 0, u = this.o.startDate !== -1 / 0 ? this.o.startDate.getUTCMonth() : -1 / 0, a = 1 / 0 !== this.o.endDate ? this.o.endDate.getUTCFullYear() : 1 / 0, f = 1 / 0 !== this.o.endDate ? this.o.endDate.getUTCMonth() : 1 / 0;
            this.date && this.date.valueOf(), this.picker.find(".datepicker-days thead th.datepicker-switch").text(l[this.o.language].months[s] + " " + i), this.picker.find("tfoot th.today").text(l[this.o.language].today).toggle(this.o.todayBtn !== !1), this.picker.find("tfoot th.clear").text(l[this.o.language].clear).toggle(this.o.clearBtn !== !1), this.updateNavArrows(), this.fillMonths();
            var h = t(i, s - 1, 28, 0, 0, 0, 0), p = c.getDaysInMonth(h.getUTCFullYear(), h.getUTCMonth());
            h.setUTCDate(p), h.setUTCDate(p - (h.getUTCDay() - this.o.weekStart + 7) % 7);
            var d = new Date(h);
            d.setUTCDate(d.getUTCDate() + 42), d = d.valueOf();
            for (var v, m = []; h.valueOf() < d; ) {
                if (h.getUTCDay() == this.o.weekStart && (m.push("<tr>"), this.o.calendarWeeks)) {
                    var g = new Date(+h + 864e5 * ((this.o.weekStart - h.getUTCDay() - 7) % 7)), y = new Date(+g + 864e5 * ((11 - g.getUTCDay()) % 7)), w = new Date(+(w = t(y.getUTCFullYear(), 0, 1)) + 864e5 * ((11 - w.getUTCDay()) % 7)), E = (y - w) / 864e5 / 7 + 1;
                    m.push('<td class="cw">' + E + "</td>");
                }
                v = this.getClassNames(h), v.push("day");
                var S = this.o.beforeShowDay(h);
                void 0 === S ? S = {} : "boolean" == typeof S ? S = {
                    enabled: S
                } : "string" == typeof S && (S = {
                    classes: S
                }), S.enabled === !1 && v.push("disabled"), S.classes && (v = v.concat(S.classes.split(/\s+/))), S.tooltip && (n = S.tooltip), v = e.unique(v), m.push('<td class="' + v.join(" ") + '"' + (n ? ' title="' + n + '"' : "") + ">" + h.getUTCDate() + "</td>"), h.getUTCDay() == this.o.weekEnd && m.push("</tr>"), h.setUTCDate(h.getUTCDate() + 1);
            }
            this.picker.find(".datepicker-days tbody").empty().append(m.join(""));
            var x = this.date && this.date.getUTCFullYear(), T = this.picker.find(".datepicker-months").find("th:eq(1)").text(i).end().find("span").removeClass("active");
            x && x == i && T.eq(this.date.getUTCMonth()).addClass("active"), (o > i || i > a) && T.addClass("disabled"), i == o && T.slice(0, u).addClass("disabled"), i == a && T.slice(f + 1).addClass("disabled"), m = "", i = 10 * parseInt(i / 10, 10);
            var N = this.picker.find(".datepicker-years").find("th:eq(1)").text(i + "-" + (i + 9)).end().find("td");
            i -= 1;
            for (var C = -1; 11 > C; C++) m += '<span class="year' + (-1 == C ? " old" : 10 == C ? " new" : "") + (x == i ? " active" : "") + (o > i || i > a ? " disabled" : "") + '">' + i + "</span>", i += 1;
            N.html(m);
        },
        updateNavArrows: function() {
            if (this._allow_update) {
                var e = new Date(this.viewDate), t = e.getUTCFullYear(), n = e.getUTCMonth();
                switch (this.viewMode) {
                  case 0:
                    this.o.startDate !== -1 / 0 && t <= this.o.startDate.getUTCFullYear() && n <= this.o.startDate.getUTCMonth() ? this.picker.find(".prev").css({
                        visibility: "hidden"
                    }) : this.picker.find(".prev").css({
                        visibility: "visible"
                    }), 1 / 0 !== this.o.endDate && t >= this.o.endDate.getUTCFullYear() && n >= this.o.endDate.getUTCMonth() ? this.picker.find(".next").css({
                        visibility: "hidden"
                    }) : this.picker.find(".next").css({
                        visibility: "visible"
                    });
                    break;
                  case 1:
                  case 2:
                    this.o.startDate !== -1 / 0 && t <= this.o.startDate.getUTCFullYear() ? this.picker.find(".prev").css({
                        visibility: "hidden"
                    }) : this.picker.find(".prev").css({
                        visibility: "visible"
                    }), 1 / 0 !== this.o.endDate && t >= this.o.endDate.getUTCFullYear() ? this.picker.find(".next").css({
                        visibility: "hidden"
                    }) : this.picker.find(".next").css({
                        visibility: "visible"
                    });
                }
            }
        },
        click: function(n) {
            n.preventDefault();
            var r = e(n.target).closest("span, td, th");
            if (1 == r.length) switch (r[0].nodeName.toLowerCase()) {
              case "th":
                switch (r[0].className) {
                  case "datepicker-switch":
                    this.showMode(1);
                    break;
                  case "prev":
                  case "next":
                    var i = c.modes[this.viewMode].navStep * ("prev" == r[0].className ? -1 : 1);
                    switch (this.viewMode) {
                      case 0:
                        this.viewDate = this.moveMonth(this.viewDate, i);
                        break;
                      case 1:
                      case 2:
                        this.viewDate = this.moveYear(this.viewDate, i);
                    }
                    this.fill();
                    break;
                  case "today":
                    var s = new Date;
                    s = t(s.getFullYear(), s.getMonth(), s.getDate(), 0, 0, 0), this.showMode(-2);
                    var o = "linked" == this.o.todayBtn ? null : "view";
                    this._setDate(s, o);
                    break;
                  case "clear":
                    var u;
                    this.isInput ? u = this.element : this.component && (u = this.element.find("input")), u && u.val("").change(), this._trigger("changeDate"), this.update(), this.o.autoclose && this.hide();
                }
                break;
              case "span":
                if (!r.is(".disabled")) {
                    if (this.viewDate.setUTCDate(1), r.is(".month")) {
                        var a = 1, f = r.parent().find("span").index(r), l = this.viewDate.getUTCFullYear();
                        this.viewDate.setUTCMonth(f), this._trigger("changeMonth", this.viewDate), 1 === this.o.minViewMode && this._setDate(t(l, f, a, 0, 0, 0, 0));
                    } else {
                        var l = parseInt(r.text(), 10) || 0, a = 1, f = 0;
                        this.viewDate.setUTCFullYear(l), this._trigger("changeYear", this.viewDate), 2 === this.o.minViewMode && this._setDate(t(l, f, a, 0, 0, 0, 0));
                    }
                    this.showMode(-1), this.fill();
                }
                break;
              case "td":
                if (r.is(".day") && !r.is(".disabled")) {
                    var a = parseInt(r.text(), 10) || 1, l = this.viewDate.getUTCFullYear(), f = this.viewDate.getUTCMonth();
                    r.is(".old") ? 0 === f ? (f = 11, l -= 1) : f -= 1 : r.is(".new") && (11 == f ? (f = 0, l += 1) : f += 1), this._setDate(t(l, f, a, 0, 0, 0, 0));
                }
            }
        },
        _setDate: function(e, t) {
            t && "date" != t || (this.date = new Date(e)), t && "view" != t || (this.viewDate = new Date(e)), this.fill(), this.setValue(), this._trigger("changeDate");
            var n;
            this.isInput ? n = this.element : this.component && (n = this.element.find("input")), n && (n.change(), !this.o.autoclose || t && "date" != t || this.hide());
        },
        moveMonth: function(e, t) {
            if (!t) return e;
            var n, r, i = new Date(e.valueOf()), s = i.getUTCDate(), o = i.getUTCMonth(), u = Math.abs(t);
            if (t = t > 0 ? 1 : -1, 1 == u) r = -1 == t ? function() {
                return i.getUTCMonth() == o;
            } : function() {
                return i.getUTCMonth() != n;
            }, n = o + t, i.setUTCMonth(n), (0 > n || n > 11) && (n = (n + 12) % 12); else {
                for (var a = 0; u > a; a++) i = this.moveMonth(i, t);
                n = i.getUTCMonth(), i.setUTCDate(s), r = function() {
                    return n != i.getUTCMonth();
                };
            }
            for (; r(); ) i.setUTCDate(--s), i.setUTCMonth(n);
            return i;
        },
        moveYear: function(e, t) {
            return this.moveMonth(e, 12 * t);
        },
        dateWithinRange: function(e) {
            return e >= this.o.startDate && e <= this.o.endDate;
        },
        keydown: function(e) {
            if (this.picker.is(":not(:visible)")) return 27 == e.keyCode && this.show(), void 0;
            var t, n, r, i = !1;
            switch (e.keyCode) {
              case 27:
                this.hide(), e.preventDefault();
                break;
              case 37:
              case 39:
                if (!this.o.keyboardNavigation) break;
                t = 37 == e.keyCode ? -1 : 1, e.ctrlKey ? (n = this.moveYear(this.date, t), r = this.moveYear(this.viewDate, t)) : e.shiftKey ? (n = this.moveMonth(this.date, t), r = this.moveMonth(this.viewDate, t)) : (n = new Date(this.date), n.setUTCDate(this.date.getUTCDate() + t), r = new Date(this.viewDate), r.setUTCDate(this.viewDate.getUTCDate() + t)), this.dateWithinRange(n) && (this.date = n, this.viewDate = r, this.setValue(), this.update(), e.preventDefault(), i = !0);
                break;
              case 38:
              case 40:
                if (!this.o.keyboardNavigation) break;
                t = 38 == e.keyCode ? -1 : 1, e.ctrlKey ? (n = this.moveYear(this.date, t), r = this.moveYear(this.viewDate, t)) : e.shiftKey ? (n = this.moveMonth(this.date, t), r = this.moveMonth(this.viewDate, t)) : (n = new Date(this.date), n.setUTCDate(this.date.getUTCDate() + 7 * t), r = new Date(this.viewDate), r.setUTCDate(this.viewDate.getUTCDate() + 7 * t)), this.dateWithinRange(n) && (this.date = n, this.viewDate = r, this.setValue(), this.update(), e.preventDefault(), i = !0);
                break;
              case 13:
                this.hide(), e.preventDefault();
                break;
              case 9:
                this.hide();
            }
            if (i) {
                this._trigger("changeDate");
                var s;
                this.isInput ? s = this.element : this.component && (s = this.element.find("input")), s && s.change();
            }
        },
        showMode: function(e) {
            e && (this.viewMode = Math.max(this.o.minViewMode, Math.min(2, this.viewMode + e))), this.picker.find(">div").hide().filter(".datepicker-" + c.modes[this.viewMode].clsName).css("display", "block"), this.updateNavArrows();
        }
    };
    var s = function(t, n) {
        this.element = e(t), this.inputs = e.map(n.inputs, function(e) {
            return e.jquery ? e[0] : e;
        }), delete n.inputs, e(this.inputs).datepicker(n).bind("changeDate", e.proxy(this.dateUpdated, this)), this.pickers = e.map(this.inputs, function(t) {
            return e(t).data("datepicker");
        }), this.updateDates();
    };
    s.prototype = {
        updateDates: function() {
            this.dates = e.map(this.pickers, function(e) {
                return e.date;
            }), this.updateRanges();
        },
        updateRanges: function() {
            var t = e.map(this.dates, function(e) {
                return e.valueOf();
            });
            e.each(this.pickers, function(e, n) {
                n.setRange(t);
            });
        },
        dateUpdated: function(t) {
            var n = e(t.target).data("datepicker"), r = n.getUTCDate(), i = e.inArray(t.target, this.inputs), s = this.inputs.length;
            if (-1 != i) {
                if (r < this.dates[i]) for (; i >= 0 && r < this.dates[i]; ) this.pickers[i--].setUTCDate(r); else if (r > this.dates[i]) for (; s > i && r > this.dates[i]; ) this.pickers[i++].setUTCDate(r);
                this.updateDates();
            }
        },
        remove: function() {
            e.map(this.pickers, function(e) {
                e.remove();
            }), delete this.element.data().datepicker;
        }
    };
    var o = e.fn.datepicker, u = e.fn.datepicker = function(t) {
        var o = Array.apply(null, arguments);
        o.shift();
        var u;
        return this.each(function() {
            var f = e(this), l = f.data("datepicker"), c = "object" == typeof t && t;
            if (!l) {
                var p = n(this, "date"), v = e.extend({}, a, p, c), m = r(v.language), y = e.extend({}, a, m, p, c);
                if (f.is(".input-daterange") || y.inputs) {
                    var w = {
                        inputs: y.inputs || f.find("input").toArray()
                    };
                    f.data("datepicker", l = new s(this, e.extend(y, w)));
                } else f.data("datepicker", l = new i(this, y));
            }
            return "string" == typeof t && "function" == typeof l[t] && (u = l[t].apply(l, o), void 0 !== u) ? !1 : void 0;
        }), void 0 !== u ? u : this;
    }, a = e.fn.datepicker.defaults = {
        autoclose: !1,
        beforeShowDay: e.noop,
        calendarWeeks: !1,
        clearBtn: !1,
        daysOfWeekDisabled: [],
        endDate: 1 / 0,
        forceParse: !0,
        format: "mm/dd/yyyy",
        keyboardNavigation: !0,
        language: "en",
        minViewMode: 0,
        rtl: !1,
        startDate: -1 / 0,
        startView: 0,
        todayBtn: !1,
        todayHighlight: !1,
        weekStart: 0
    }, f = e.fn.datepicker.locale_opts = [ "format", "rtl", "weekStart" ];
    e.fn.datepicker.Constructor = i;
    var l = e.fn.datepicker.dates = {
        en: {
            days: [ "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday" ],
            daysShort: [ "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun" ],
            daysMin: [ "Su", "Mo", "Tu", "We", "Th", "Fr", "Sa", "Su" ],
            months: [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ],
            monthsShort: [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ],
            today: "Today",
            clear: "Clear"
        }
    }, c = {
        modes: [ {
            clsName: "days",
            navFnc: "Month",
            navStep: 1
        }, {
            clsName: "months",
            navFnc: "FullYear",
            navStep: 1
        }, {
            clsName: "years",
            navFnc: "FullYear",
            navStep: 10
        } ],
        isLeapYear: function(e) {
            return 0 === e % 4 && 0 !== e % 100 || 0 === e % 400;
        },
        getDaysInMonth: function(e, t) {
            return [ 31, c.isLeapYear(e) ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ][t];
        },
        validParts: /dd?|DD?|mm?|MM?|yy(?:yy)?/g,
        nonpunctuation: /[^ -\/:-@\[\u3400-\u9fff-`{-~\t\n\r]+/g,
        parseFormat: function(e) {
            var t = e.replace(this.validParts, "\0").split("\0"), n = e.match(this.validParts);
            if (!t || !t.length || !n || 0 === n.length) throw new Error("Invalid date format.");
            return {
                separators: t,
                parts: n
            };
        },
        parseDate: function(n, r, s) {
            if (n instanceof Date) return n;
            if ("string" == typeof r && (r = c.parseFormat(r)), /^[\-+]\d+[dmwy]([\s,]+[\-+]\d+[dmwy])*$/.test(n)) {
                var o, u, a = /([\-+]\d+)([dmwy])/, f = n.match(/([\-+]\d+)([dmwy])/g);
                n = new Date;
                for (var h = 0; h < f.length; h++) switch (o = a.exec(f[h]), u = parseInt(o[1]), o[2]) {
                  case "d":
                    n.setUTCDate(n.getUTCDate() + u);
                    break;
                  case "m":
                    n = i.prototype.moveMonth.call(i.prototype, n, u);
                    break;
                  case "w":
                    n.setUTCDate(n.getUTCDate() + 7 * u);
                    break;
                  case "y":
                    n = i.prototype.moveYear.call(i.prototype, n, u);
                }
                return t(n.getUTCFullYear(), n.getUTCMonth(), n.getUTCDate(), 0, 0, 0);
            }
            var p, d, o, f = n && n.match(this.nonpunctuation) || [], n = new Date, v = {}, m = [ "yyyy", "yy", "M", "MM", "m", "mm", "d", "dd" ], g = {
                yyyy: function(e, t) {
                    return e.setUTCFullYear(t);
                },
                yy: function(e, t) {
                    return e.setUTCFullYear(2e3 + t);
                },
                m: function(e, t) {
                    for (t -= 1; 0 > t; ) t += 12;
                    for (t %= 12, e.setUTCMonth(t); e.getUTCMonth() != t; ) e.setUTCDate(e.getUTCDate() - 1);
                    return e;
                },
                d: function(e, t) {
                    return e.setUTCDate(t);
                }
            };
            g.M = g.MM = g.mm = g.m, g.dd = g.d, n = t(n.getFullYear(), n.getMonth(), n.getDate(), 0, 0, 0);
            var y = r.parts.slice();
            if (f.length != y.length && (y = e(y).filter(function(t, n) {
                return -1 !== e.inArray(n, m);
            }).toArray()), f.length == y.length) {
                for (var h = 0, w = y.length; w > h; h++) {
                    if (p = parseInt(f[h], 10), o = y[h], isNaN(p)) switch (o) {
                      case "MM":
                        d = e(l[s].months).filter(function() {
                            var e = this.slice(0, f[h].length), t = f[h].slice(0, e.length);
                            return e == t;
                        }), p = e.inArray(d[0], l[s].months) + 1;
                        break;
                      case "M":
                        d = e(l[s].monthsShort).filter(function() {
                            var e = this.slice(0, f[h].length), t = f[h].slice(0, e.length);
                            return e == t;
                        }), p = e.inArray(d[0], l[s].monthsShort) + 1;
                    }
                    v[o] = p;
                }
                for (var E, h = 0; h < m.length; h++) E = m[h], E in v && !isNaN(v[E]) && g[E](n, v[E]);
            }
            return n;
        },
        formatDate: function(t, n, r) {
            "string" == typeof n && (n = c.parseFormat(n));
            var i = {
                d: t.getUTCDate(),
                D: l[r].daysShort[t.getUTCDay()],
                DD: l[r].days[t.getUTCDay()],
                m: t.getUTCMonth() + 1,
                M: l[r].monthsShort[t.getUTCMonth()],
                MM: l[r].months[t.getUTCMonth()],
                yy: t.getUTCFullYear().toString().substring(2),
                yyyy: t.getUTCFullYear()
            };
            i.dd = (i.d < 10 ? "0" : "") + i.d, i.mm = (i.m < 10 ? "0" : "") + i.m;
            for (var t = [], s = e.extend([], n.separators), o = 0, u = n.parts.length; u >= o; o++) s.length && t.push(s.shift()), t.push(i[n.parts[o]]);
            return t.join("");
        },
        headTemplate: '<thead><tr><th class="prev"><i class="fa fa-arrow-left"/></th><th colspan="5" class="datepicker-switch"></th><th class="next"><i class="fa fa-arrow-right"/></th></tr></thead>',
        contTemplate: '<tbody><tr><td colspan="7"></td></tr></tbody>',
        footTemplate: '<tfoot><tr><th colspan="7" class="today"></th></tr><tr><th colspan="7" class="clear"></th></tr></tfoot>'
    };
    c.template = '<div class="datepicker"><div class="datepicker-days"><table class=" table-condensed">' + c.headTemplate + "<tbody></tbody>" + c.footTemplate + "</table>" + "</div>" + '<div class="datepicker-months">' + '<table class="table-condensed">' + c.headTemplate + c.contTemplate + c.footTemplate + "</table>" + "</div>" + '<div class="datepicker-years">' + '<table class="table-condensed">' + c.headTemplate + c.contTemplate + c.footTemplate + "</table>" + "</div>" + "</div>", e.fn.datepicker.DPGlobal = c, e.fn.datepicker.noConflict = function() {
        return e.fn.datepicker = o, this;
    }, e(document).on("focus.datepicker.data-api click.datepicker.data-api", '[data-provide="datepicker"]', function(t) {
        var n = e(this);
        n.data("datepicker") || (t.preventDefault(), u.call(n, "show"));
    }), e(function() {
        u.call(e('[data-provide="datepicker-inline"]'));
    });
}(window.jQuery), function(e) {
    "use strict";
    e.fn.bdatepicker = e.fn.datepicker.noConflict(), e.fn.datepicker || (e.fn.datepicker = e.fn.bdatepicker);
    var t = function(e) {
        this.init("date", e, t.defaults), this.initPicker(e, t.defaults);
    };
    e.fn.editableutils.inherit(t, e.fn.editabletypes.abstractinput), e.extend(t.prototype, {
        initPicker: function(t, n) {
            this.options.viewformat || (this.options.viewformat = this.options.format), t.datepicker = e.fn.editableutils.tryParseJson(t.datepicker, !0), this.options.datepicker = e.extend({}, n.datepicker, t.datepicker, {
                format: this.options.viewformat
            }), this.options.datepicker.language = this.options.datepicker.language || "en", this.dpg = e.fn.bdatepicker.DPGlobal, this.parsedFormat = this.dpg.parseFormat(this.options.format), this.parsedViewFormat = this.dpg.parseFormat(this.options.viewformat);
        },
        render: function() {
            this.$input.bdatepicker(this.options.datepicker), this.options.clear && (this.$clear = e('<a href="#"></a>').html(this.options.clear).click(e.proxy(function(e) {
                e.preventDefault(), e.stopPropagation(), this.clear();
            }, this)), this.$tpl.parent().append(e('<div class="editable-clear">').append(this.$clear)));
        },
        value2html: function(e, n) {
            var r = e ? this.dpg.formatDate(e, this.parsedViewFormat, this.options.datepicker.language) : "";
            t.superclass.value2html.call(this, r, n);
        },
        html2value: function(e) {
            return this.parseDate(e, this.parsedViewFormat);
        },
        value2str: function(e) {
            return e ? this.dpg.formatDate(e, this.parsedFormat, this.options.datepicker.language) : "";
        },
        str2value: function(e) {
            return this.parseDate(e, this.parsedFormat);
        },
        value2submit: function(e) {
            return this.value2str(e);
        },
        value2input: function(e) {
            this.$input.bdatepicker("update", e);
        },
        input2value: function() {
            return this.$input.data("datepicker").date;
        },
        activate: function() {},
        clear: function() {
            this.$input.data("datepicker").date = null, this.$input.find(".active").removeClass("active"), this.options.showbuttons || this.$input.closest("form").submit();
        },
        autosubmit: function() {
            this.$input.on("mouseup", ".day", function(t) {
                if (!e(t.currentTarget).is(".old") && !e(t.currentTarget).is(".new")) {
                    var n = e(this).closest("form");
                    setTimeout(function() {
                        n.submit();
                    }, 200);
                }
            });
        },
        parseDate: function(e, t) {
            var n, r = null;
            return e && (r = this.dpg.parseDate(e, t, this.options.datepicker.language), "string" == typeof e && (n = this.dpg.formatDate(r, t, this.options.datepicker.language), e !== n && (r = null))), r;
        }
    }), t.defaults = e.extend({}, e.fn.editabletypes.abstractinput.defaults, {
        tpl: '<div class="editable-date well"></div>',
        inputclass: null,
        format: "yyyy-mm-dd",
        viewformat: null,
        datepicker: {
            weekStart: 0,
            startView: 0,
            minViewMode: 0,
            autoclose: !1
        },
        clear: "&times; clear"
    }), e.fn.editabletypes.date = t;
}(window.jQuery), function(e) {
    "use strict";
    var t = function(e) {
        this.init("datefield", e, t.defaults), this.initPicker(e, t.defaults);
    };
    e.fn.editableutils.inherit(t, e.fn.editabletypes.date), e.extend(t.prototype, {
        render: function() {
            this.$input = this.$tpl.find("input"), this.setClass(), this.setAttr("placeholder"), this.$tpl.bdatepicker(this.options.datepicker), this.$input.off("focus keydown"), this.$input.keyup(e.proxy(function() {
                this.$tpl.removeData("date"), this.$tpl.bdatepicker("update");
            }, this));
        },
        value2input: function(e) {
            this.$input.val(e ? this.dpg.formatDate(e, this.parsedViewFormat, this.options.datepicker.language) : ""), this.$tpl.bdatepicker("update");
        },
        input2value: function() {
            return this.html2value(this.$input.val());
        },
        activate: function() {
            e.fn.editabletypes.text.prototype.activate.call(this);
        },
        autosubmit: function() {}
    }), t.defaults = e.extend({}, e.fn.editabletypes.date.defaults, {
        tpl: '<div class="input-append date"><input type="text"/><span class="add-on"><i class="fa fa-th"></i></span></div>',
        inputclass: "input-small",
        datepicker: {
            weekStart: 0,
            startView: 0,
            minViewMode: 0,
            autoclose: !0
        }
    }), e.fn.editabletypes.datefield = t;
}(window.jQuery), function(e) {
    "use strict";
    var t = function(e) {
        this.init("datetime", e, t.defaults), this.initPicker(e, t.defaults);
    };
    e.fn.editableutils.inherit(t, e.fn.editabletypes.abstractinput), e.extend(t.prototype, {
        initPicker: function(t, n) {
            this.options.viewformat || (this.options.viewformat = this.options.format), t.datetimepicker = e.fn.editableutils.tryParseJson(t.datetimepicker, !0), this.options.datetimepicker = e.extend({}, n.datetimepicker, t.datetimepicker, {
                format: this.options.viewformat
            }), this.options.datetimepicker.language = this.options.datetimepicker.language || "en", this.dpg = e.fn.datetimepicker.DPGlobal, this.parsedFormat = this.dpg.parseFormat(this.options.format, this.options.formatType), this.parsedViewFormat = this.dpg.parseFormat(this.options.viewformat, this.options.formatType);
        },
        render: function() {
            this.$input.datetimepicker(this.options.datetimepicker), this.$input.on("changeMode", function() {
                var t = e(this).closest("form").parent();
                setTimeout(function() {
                    t.triggerHandler("resize");
                }, 0);
            }), this.options.clear && (this.$clear = e('<a href="#"></a>').html(this.options.clear).click(e.proxy(function(e) {
                e.preventDefault(), e.stopPropagation(), this.clear();
            }, this)), this.$tpl.parent().append(e('<div class="editable-clear">').append(this.$clear)));
        },
        value2html: function(e, n) {
            var r = e ? this.dpg.formatDate(this.toUTC(e), this.parsedViewFormat, this.options.datetimepicker.language, this.options.formatType) : "";
            return n ? (t.superclass.value2html.call(this, r, n), void 0) : r;
        },
        html2value: function(e) {
            var t = this.parseDate(e, this.parsedViewFormat);
            return t ? this.fromUTC(t) : null;
        },
        value2str: function(e) {
            return e ? this.dpg.formatDate(this.toUTC(e), this.parsedFormat, this.options.datetimepicker.language, this.options.formatType) : "";
        },
        str2value: function(e) {
            var t = this.parseDate(e, this.parsedFormat);
            return t ? this.fromUTC(t) : null;
        },
        value2submit: function(e) {
            return this.value2str(e);
        },
        value2input: function(e) {
            e && this.$input.data("datetimepicker").setDate(e);
        },
        input2value: function() {
            var e = this.$input.data("datetimepicker");
            return e.date ? e.getDate() : null;
        },
        activate: function() {},
        clear: function() {
            this.$input.data("datetimepicker").date = null, this.$input.find(".active").removeClass("active"), this.options.showbuttons || this.$input.closest("form").submit();
        },
        autosubmit: function() {
            this.$input.on("mouseup", ".minute", function() {
                var t = e(this).closest("form");
                setTimeout(function() {
                    t.submit();
                }, 200);
            });
        },
        toUTC: function(e) {
            return e ? new Date(e.valueOf() - 6e4 * e.getTimezoneOffset()) : e;
        },
        fromUTC: function(e) {
            return e ? new Date(e.valueOf() + 6e4 * e.getTimezoneOffset()) : e;
        },
        parseDate: function(e, t) {
            var n, r = null;
            return e && (r = this.dpg.parseDate(e, t, this.options.datetimepicker.language, this.options.formatType), "string" == typeof e && (n = this.dpg.formatDate(r, t, this.options.datetimepicker.language, this.options.formatType), e !== n && (r = null))), r;
        }
    }), t.defaults = e.extend({}, e.fn.editabletypes.abstractinput.defaults, {
        tpl: '<div class="editable-date well"></div>',
        inputclass: null,
        format: "yyyy-mm-dd hh:ii",
        formatType: "standard",
        viewformat: null,
        datetimepicker: {
            todayHighlight: !1,
            autoclose: !1
        },
        clear: "&times; clear"
    }), e.fn.editabletypes.datetime = t;
}(window.jQuery), function(e) {
    "use strict";
    var t = function(e) {
        this.init("datetimefield", e, t.defaults), this.initPicker(e, t.defaults);
    };
    e.fn.editableutils.inherit(t, e.fn.editabletypes.datetime), e.extend(t.prototype, {
        render: function() {
            this.$input = this.$tpl.find("input"), this.setClass(), this.setAttr("placeholder"), this.$tpl.datetimepicker(this.options.datetimepicker), this.$input.off("focus keydown"), this.$input.keyup(e.proxy(function() {
                this.$tpl.removeData("date"), this.$tpl.datetimepicker("update");
            }, this));
        },
        value2input: function(e) {
            this.$input.val(this.value2html(e)), this.$tpl.datetimepicker("update");
        },
        input2value: function() {
            return this.html2value(this.$input.val());
        },
        activate: function() {
            e.fn.editabletypes.text.prototype.activate.call(this);
        },
        autosubmit: function() {}
    }), t.defaults = e.extend({}, e.fn.editabletypes.datetime.defaults, {
        tpl: '<div class="input-append date"><input type="text"/><span class="add-on"><i class="fa fa-th"></i></span></div>',
        inputclass: "input-medium",
        datetimepicker: {
            todayHighlight: !1,
            autoclose: !0
        }
    }), e.fn.editabletypes.datetimefield = t;
}(window.jQuery);
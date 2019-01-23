/* ===================================================
 * bootstrap-markdown.js v1.1.4
 * http://github.com/toopay/bootstrap-markdown
 * ===================================================
 * Copyright 2013 Taufan Aditya
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================== */!function(e) {
    "use strict";
    var t = function(t, n) {
        this.$ns = "bootstrap-markdown";
        this.$element = e(t);
        this.$editable = {
            el: null,
            type: null,
            attrKeys: [],
            attrValues: [],
            content: null
        };
        this.$options = e.extend(!0, {}, e.fn.markdown.defaults, n);
        this.$oldContent = null;
        this.$isPreview = !1;
        this.$editor = null;
        this.$textarea = null;
        this.$handler = [];
        this.$callback = [];
        this.$nextTab = [];
        this.showEditor();
    };
    t.prototype = {
        constructor: t,
        __alterButtons: function(t, n) {
            var r = this.$handler, i = t == "all", s = this;
            e.each(r, function(e, r) {
                var o = !0;
                i ? o = !1 : o = r.indexOf(t) < 0;
                o == 0 && n(s.$editor.find('button[data-handler="' + r + '"]'));
            });
        },
        __buildButtons: function(t, n) {
            var r, i = this.$ns, s = this.$handler, o = this.$callback;
            for (r = 0; r < t.length; r++) {
                var u, a = t[r];
                for (u = 0; u < a.length; u++) {
                    var f, l = a[u].data, c = e("<div/>", {
                        "class": "btn-group"
                    });
                    for (f = 0; f < l.length; f++) {
                        var h = l[f], p = "", d = i + "-" + h.name, v = h.btnText ? h.btnText : "", m = h.btnClass ? h.btnClass : "btn btn-info", g = h.tabIndex ? h.tabIndex : "-1";
                        h.toggle == 1 && (p = ' data-toggle="button"');
                        c.append('<button class="' + m + ' btn-small" title="' + h.title + '" tabindex="' + g + '" data-provider="' + i + '" data-handler="' + d + '"' + p + '><i class="' + h.icon + '"></i> ' + v + "</button>");
                        s.push(d);
                        o.push(h.callback);
                    }
                    n.append(c);
                }
            }
            return n;
        },
        __setListener: function() {
            var t = typeof this.$textarea.attr("rows") != "undefined", n = this.$textarea.val().split("\n").length > 5 ? this.$textarea.val().split("\n").length : "5", r = t ? this.$textarea.attr("rows") : n;
            this.$textarea.attr("rows", r);
            this.$textarea.css("resize", "none");
            this.$textarea.on("focus", e.proxy(this.focus, this)).on("keypress", e.proxy(this.keypress, this)).on("keyup", e.proxy(this.keyup, this));
            this.eventSupported("keydown") && this.$textarea.on("keydown", e.proxy(this.keydown, this));
            this.$textarea.data("markdown", this);
        },
        __handle: function(t) {
            var n = e(t.currentTarget), r = this.$handler, i = this.$callback, s = n.attr("data-handler"), o = r.indexOf(s), u = i[o];
            e(t.currentTarget).focus();
            u(this);
            s.indexOf("cmdSave") < 0 && this.$textarea.focus();
            t.preventDefault();
        },
        showEditor: function() {
            var t = this, n, r = this.$ns, i = this.$element, s = i.css("height"), o = i.css("width"), u = this.$editable, a = this.$handler, f = this.$callback, l = this.$options, c = e("<div/>", {
                "class": "md-editor",
                click: function() {
                    t.focus();
                }
            });
            if (this.$editor == null) {
                var h = e("<div/>", {
                    "class": "md-header"
                });
                l.buttons.length > 0 && (h = this.__buildButtons(l.buttons, h));
                l.additionalButtons.length > 0 && (h = this.__buildButtons(l.additionalButtons, h));
                c.append(h);
                if (i.is("textarea")) {
                    i.before(c);
                    n = i;
                    n.addClass("md-input");
                    c.append(n);
                } else {
                    var p = typeof toMarkdown == "function" ? toMarkdown(i.html()) : i.html(), d = e.trim(p);
                    n = e("<textarea/>", {
                        "class": "md-input",
                        val: d
                    });
                    c.append(n);
                    u.el = i;
                    u.type = i.prop("tagName").toLowerCase();
                    u.content = i.html();
                    e(i[0].attributes).each(function() {
                        u.attrKeys.push(this.nodeName);
                        u.attrValues.push(this.nodeValue);
                    });
                    i.replaceWith(c);
                }
                if (l.savable) {
                    var v = e("<div/>", {
                        "class": "md-footer"
                    }), m = "cmdSave";
                    a.push(m);
                    f.push(l.onSave);
                    v.append('<button class="btn btn-success" data-provider="' + r + '" data-handler="' + m + '"><i class="fa fa-white icon-ok"></i> Save</button>');
                    c.append(v);
                }
                e.each([ "height", "width" ], function(e, t) {
                    l[t] != "inherit" && (jQuery.isNumeric(l[t]) ? c.css(t, l[t] + "px") : c.addClass(l[t]));
                });
                this.$editor = c;
                this.$textarea = n;
                this.$editable = u;
                this.$oldContent = this.getContent();
                this.__setListener();
                this.$editor.attr("id", (new Date).getTime());
                this.$editor.on("click", '[data-provider="bootstrap-markdown"]', e.proxy(this.__handle, this));
            } else this.$editor.show();
            if (l.autofocus) {
                this.$textarea.focus();
                this.$editor.addClass("active");
            }
            l.onShow(this);
            return this;
        },
        showPreview: function() {
            var t = this.$options, n = t.onPreview(this), r = this.$textarea, i = r.next(), s = e("<div/>", {
                "class": "md-preview",
                "data-provider": "markdown-preview"
            }), o;
            this.$isPreview = !0;
            this.disableButtons("all").enableButtons("cmdPreview");
            typeof n == "string" ? o = n : o = typeof markdown == "object" ? markdown.toHTML(r.val()) : r.val();
            s.html(o);
            i && i.attr("class") == "md-footer" ? s.insertBefore(i) : r.parent().append(s);
            r.hide();
            s.data("markdown", this);
            return this;
        },
        hidePreview: function() {
            this.$isPreview = !1;
            var e = this.$editor.find('div[data-provider="markdown-preview"]');
            e.remove();
            this.enableButtons("all");
            this.$textarea.show();
            this.__setListener();
            return this;
        },
        isDirty: function() {
            return this.$oldContent != this.getContent();
        },
        getContent: function() {
            return this.$textarea.val();
        },
        setContent: function(e) {
            this.$textarea.val(e);
            return this;
        },
        findSelection: function(e) {
            var t = this.getContent(), n;
            if (n = t.indexOf(e), n >= 0 && e.length > 0) {
                var r = this.getSelection(), i;
                this.setSelection(n, n + e.length);
                i = this.getSelection();
                this.setSelection(r.start, r.end);
                return i;
            }
            return null;
        },
        getSelection: function() {
            var e = this.$textarea[0];
            return ("selectionStart" in e && function() {
                var t = e.selectionEnd - e.selectionStart;
                return {
                    start: e.selectionStart,
                    end: e.selectionEnd,
                    length: t,
                    text: e.value.substr(e.selectionStart, t)
                };
            } || function() {
                return null;
            })();
        },
        setSelection: function(e, t) {
            var n = this.$textarea[0];
            return ("selectionStart" in n && function() {
                n.selectionStart = e;
                n.selectionEnd = t;
                return;
            } || function() {
                return null;
            })();
        },
        replaceSelection: function(e) {
            var t = this.$textarea[0];
            return ("selectionStart" in t && function() {
                t.value = t.value.substr(0, t.selectionStart) + e + t.value.substr(t.selectionEnd, t.value.length);
                t.selectionStart = t.value.length;
                return this;
            } || function() {
                t.value += e;
                return jQuery(t);
            })();
        },
        getNextTab: function() {
            if (this.$nextTab.length == 0) return null;
            var e, t = this.$nextTab.shift();
            typeof t == "function" ? e = t() : typeof t == "object" && t.length > 0 && (e = t);
            return e;
        },
        setNextTab: function(e, t) {
            if (typeof e == "string") {
                var n = this;
                this.$nextTab.push(function() {
                    return n.findSelection(e);
                });
            } else if (typeof e == "numeric" && typeof t == "numeric") {
                var r = this.getSelection();
                this.setSelection(e, t);
                this.$nextTab.push(this.getSelection());
                this.setSelection(r.start, r.end);
            }
            return;
        },
        enableButtons: function(e) {
            var t = function(e) {
                e.removeAttr("disabled");
            };
            this.__alterButtons(e, t);
            return this;
        },
        disableButtons: function(e) {
            var t = function(e) {
                e.attr("disabled", "disabled");
            };
            this.__alterButtons(e, t);
            return this;
        },
        eventSupported: function(e) {
            var t = e in this.$element;
            if (!t) {
                this.$element.setAttribute(e, "return;");
                t = typeof this.$element[e] == "function";
            }
            return t;
        },
        keydown: function(t) {
            this.suppressKeyPressRepeat = ~e.inArray(t.keyCode, [ 40, 38, 9, 13, 27 ]);
            this.keyup(t);
        },
        keypress: function(e) {
            if (this.suppressKeyPressRepeat) return;
            this.keyup(e);
        },
        keyup: function(e) {
            var t = !1;
            switch (e.keyCode) {
              case 40:
              case 38:
              case 16:
              case 17:
              case 18:
                break;
              case 9:
                var n;
                if (n = this.getNextTab(), n != null) {
                    var r = this;
                    setTimeout(function() {
                        r.setSelection(n.start, n.end);
                    }, 500);
                    t = !0;
                } else {
                    var i = this.getSelection();
                    if (i.start == i.end && i.end == this.getContent().length) t = !1; else {
                        this.setSelection(this.getContent().length, this.getContent().length);
                        t = !0;
                    }
                }
                break;
              case 13:
              case 27:
                t = !1;
                break;
              default:
                t = !1;
            }
            if (t) {
                e.stopPropagation();
                e.preventDefault();
            }
        },
        focus: function(t) {
            var n = this.$options, r = n.hideable, i = this.$editor;
            i.addClass("active");
            e(document).find(".md-editor").each(function() {
                if (e(this).attr("id") != i.attr("id")) {
                    var t;
                    if (t = e(this).find("textarea").data("markdown"), t == null) t = e(this).find('div[data-provider="markdown-preview"]').data("markdown");
                    t && t.blur();
                }
            });
            return this;
        },
        blur: function(t) {
            var n = this.$options, r = n.hideable, i = this.$editor, s = this.$editable;
            if (i.hasClass("active") || this.$element.parent().length == 0) {
                i.removeClass("active");
                if (r) if (s.el != null) {
                    var o = e("<" + s.type + "/>"), u = this.getContent(), a = typeof markdown == "object" ? markdown.toHTML(u) : u;
                    e(s.attrKeys).each(function(e, t) {
                        o.attr(s.attrKeys[e], s.attrValues[e]);
                    });
                    o.html(a);
                    i.replaceWith(o);
                } else i.hide();
                n.onBlur(this);
            }
            return this;
        }
    };
    var n = e.fn.markdown;
    e.fn.markdown = function(n) {
        return this.each(function() {
            var r = e(this), i = r.data("markdown"), s = typeof n == "object" && n;
            i || r.data("markdown", i = new t(this, s));
        });
    };
    e.fn.markdown.defaults = {
        autofocus: !1,
        hideable: !1,
        savable: !1,
        width: "inherit",
        height: "inherit",
        buttons: [ [ {
            name: "groupFont",
            data: [ {
                name: "cmdBold",
                title: "Bold",
                icon: "fa fa-bold",
                callback: function(e) {
                    var t, n, r = e.getSelection(), i = e.getContent();
                    r.length == 0 ? t = "strong text" : t = r.text;
                    if (i.substr(r.start - 2, 2) == "**" && i.substr(r.end, 2) == "**") {
                        e.setSelection(r.start - 2, r.end + 2);
                        e.replaceSelection(t);
                        n = r.start - 2;
                    } else {
                        e.replaceSelection("**" + t + "**");
                        n = r.start + 2;
                    }
                    e.setSelection(n, n + t.length);
                }
            }, {
                name: "cmdItalic",
                title: "Italic",
                icon: "fa fa-italic",
                callback: function(e) {
                    var t, n, r = e.getSelection(), i = e.getContent();
                    r.length == 0 ? t = "emphasized text" : t = r.text;
                    if (i.substr(r.start - 1, 1) == "*" && i.substr(r.end, 1) == "*") {
                        e.setSelection(r.start - 1, r.end + 1);
                        e.replaceSelection(t);
                        n = r.start - 1;
                    } else {
                        e.replaceSelection("*" + t + "*");
                        n = r.start + 1;
                    }
                    e.setSelection(n, n + t.length);
                }
            }, {
                name: "cmdHeading",
                title: "Heading",
                icon: "fa fa-font",
                callback: function(e) {
                    var t, n, r = e.getSelection(), i = e.getContent(), s, o;
                    r.length == 0 ? t = "heading text" : t = r.text;
                    if ((s = 4, i.substr(r.start - s, s) == "### ") || (s = 3, i.substr(r.start - s, s) == "###")) {
                        e.setSelection(r.start - s, r.end);
                        e.replaceSelection(t);
                        n = r.start - s;
                    } else if (o = i.substr(r.start - 1, 1), !o || o == "\n") {
                        e.replaceSelection("### " + t + "\n");
                        n = r.start + 4;
                    } else {
                        e.replaceSelection("\n\n### " + t + "\n");
                        n = r.start + 6;
                    }
                    e.setSelection(n, n + t.length);
                }
            } ]
        }, {
            name: "groupLink",
            data: [ {
                name: "cmdUrl",
                title: "URL/Link",
                icon: "fa fa-globe",
                callback: function(e) {
                    var t, n, r = e.getSelection(), i = e.getContent(), s;
                    r.length == 0 ? t = "enter link description here" : t = r.text;
                    s = prompt("Insert Hyperlink", "http://");
                    if (s != null) {
                        e.replaceSelection("[" + t + "](" + s + ")");
                        n = r.start + 1;
                        e.setSelection(n, n + t.length);
                    }
                }
            }, {
                name: "cmdImage",
                title: "Image",
                icon: "fa fa-picture",
                callback: function(e) {
                    var t, n, r = e.getSelection(), i = e.getContent(), s;
                    r.length == 0 ? t = "enter image description here" : t = r.text;
                    s = prompt("Insert Image Hyperlink", "http://");
                    if (s != null) {
                        e.replaceSelection("![" + t + "](" + s + ' "enter image title here")');
                        n = r.start + 2;
                        e.setNextTab("enter image title here");
                        e.setSelection(n, n + t.length);
                    }
                }
            } ]
        }, {
            name: "groupMisc",
            data: [ {
                name: "cmdList",
                title: "List",
                icon: "fa fa-list",
                callback: function(t) {
                    var n, r, i = t.getSelection(), s = t.getContent();
                    if (i.length == 0) {
                        n = "list text here";
                        t.replaceSelection("- " + n);
                        r = i.start + 2;
                    } else if (i.text.indexOf("\n") < 0) {
                        n = i.text;
                        t.replaceSelection("- " + n);
                        r = i.start + 2;
                    } else {
                        var o = [];
                        o = i.text.split("\n");
                        n = o[0];
                        e.each(o, function(e, t) {
                            o[e] = "- " + t;
                        });
                        t.replaceSelection("\n\n" + o.join("\n"));
                        r = i.start + 4;
                    }
                    t.setSelection(r, r + n.length);
                }
            } ]
        }, {
            name: "groupUtil",
            data: [ {
                name: "cmdPreview",
                toggle: !0,
                title: "Preview",
                btnText: "Preview",
                btnClass: "btn btn-success",
                icon: "fa fa-white icon-search",
                callback: function(e) {
                    var t = e.$isPreview, n;
                    t == 0 ? e.showPreview() : e.hidePreview();
                }
            } ]
        } ] ],
        additionalButtons: [],
        onShow: function(e) {},
        onPreview: function(e) {},
        onSave: function(e) {},
        onBlur: function(e) {}
    };
    e.fn.markdown.Constructor = t;
    e.fn.markdown.noConflict = function() {
        e.fn.markdown = n;
        return this;
    };
    var r = function(e) {
        var t = e;
        if (t.data("markdown")) {
            t.data("markdown").showEditor();
            return;
        }
        t.markdown(t.data());
    }, i = function(t) {
        var n = !1, r, i = e(t.currentTarget);
        if ((t.type == "focusin" || t.type == "click") && i.length == 1 && typeof i[0] == "object") {
            r = i[0].activeElement;
            if (!e(r).data("markdown")) if (typeof e(r).parent().parent().parent().attr("class") == "undefined" || e(r).parent().parent().parent().attr("class").indexOf("md-editor") < 0) {
                if (typeof e(r).parent().parent().attr("class") == "undefined" || e(r).parent().parent().attr("class").indexOf("md-editor") < 0) n = !0;
            } else n = !1;
            n && e(document).find(".md-editor").each(function() {
                var t = e(r).parent();
                if (e(this).attr("id") != t.attr("id")) {
                    var n;
                    if (n = e(this).find("textarea").data("markdown"), n == null) n = e(this).find('div[data-provider="markdown-preview"]').data("markdown");
                    n && n.blur();
                }
            });
            t.stopPropagation();
        }
    };
    e(document).on("click.markdown.data-api", '[data-provide="markdown-editable"]', function(t) {
        r(e(this));
        t.preventDefault();
    }).on("click", function(e) {
        i(e);
    }).on("focusin", function(e) {
        i(e);
    }).ready(function() {
        e('textarea[data-provide="markdown"]').each(function() {
            r(e(this));
        });
    });
}(window.jQuery);
/*!
 * Timepicker Component for Twitter Bootstrap
 *
 * Copyright 2013 Joris de Wit
 *
 * Contributors https://github.com/jdewit/bootstrap-timepicker/graphs/contributors
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */(function(e, t, n, r) {
    "use strict";
    var i = function(t, n) {
        this.widget = "";
        this.$element = e(t);
        this.defaultTime = n.defaultTime;
        this.disableFocus = n.disableFocus;
        this.disableMousewheel = n.disableMousewheel;
        this.isOpen = n.isOpen;
        this.minuteStep = n.minuteStep;
        this.modalBackdrop = n.modalBackdrop;
        this.orientation = n.orientation;
        this.secondStep = n.secondStep;
        this.showInputs = n.showInputs;
        this.showMeridian = n.showMeridian;
        this.showSeconds = n.showSeconds;
        this.template = n.template;
        this.appendWidgetTo = n.appendWidgetTo;
        this.showWidgetOnAddonClick = n.showWidgetOnAddonClick;
        this._init();
    };
    i.prototype = {
        constructor: i,
        _init: function() {
            var t = this;
            if (this.showWidgetOnAddonClick && (this.$element.parent().hasClass("input-group") || this.$element.parent().hasClass("input-prepend"))) {
                this.$element.parent(".input-group, .input-prepend").find(".input-group-addon").on({
                    "click.timepicker": e.proxy(this.showWidget, this)
                });
                this.$element.on({
                    "focus.timepicker": e.proxy(this.highlightUnit, this),
                    "click.timepicker": e.proxy(this.highlightUnit, this),
                    "keydown.timepicker": e.proxy(this.elementKeydown, this),
                    "blur.timepicker": e.proxy(this.blurElement, this),
                    "mousewheel.timepicker DOMMouseScroll.timepicker": e.proxy(this.mousewheel, this)
                });
            } else this.template ? this.$element.on({
                "focus.timepicker": e.proxy(this.showWidget, this),
                "click.timepicker": e.proxy(this.showWidget, this),
                "blur.timepicker": e.proxy(this.blurElement, this),
                "mousewheel.timepicker DOMMouseScroll.timepicker": e.proxy(this.mousewheel, this)
            }) : this.$element.on({
                "focus.timepicker": e.proxy(this.highlightUnit, this),
                "click.timepicker": e.proxy(this.highlightUnit, this),
                "keydown.timepicker": e.proxy(this.elementKeydown, this),
                "blur.timepicker": e.proxy(this.blurElement, this),
                "mousewheel.timepicker DOMMouseScroll.timepicker": e.proxy(this.mousewheel, this)
            });
            this.template !== !1 ? this.$widget = e(this.getTemplate()).on("click", e.proxy(this.widgetClick, this)) : this.$widget = !1;
            this.showInputs && this.$widget !== !1 && this.$widget.find("input").each(function() {
                e(this).on({
                    "click.timepicker": function() {
                        e(this).select();
                    },
                    "keydown.timepicker": e.proxy(t.widgetKeydown, t),
                    "keyup.timepicker": e.proxy(t.widgetKeyup, t)
                });
            });
            this.setDefaultTime(this.defaultTime);
        },
        blurElement: function() {
            this.highlightedUnit = null;
            this.updateFromElementVal();
        },
        clear: function() {
            this.hour = "";
            this.minute = "";
            this.second = "";
            this.meridian = "";
            this.$element.val("");
        },
        decrementHour: function() {
            if (this.showMeridian) if (this.hour === 1) this.hour = 12; else {
                if (this.hour === 12) {
                    this.hour--;
                    return this.toggleMeridian();
                }
                if (this.hour === 0) {
                    this.hour = 11;
                    return this.toggleMeridian();
                }
                this.hour--;
            } else this.hour <= 0 ? this.hour = 23 : this.hour--;
        },
        decrementMinute: function(e) {
            var t;
            e ? t = this.minute - e : t = this.minute - this.minuteStep;
            if (t < 0) {
                this.decrementHour();
                this.minute = t + 60;
            } else this.minute = t;
        },
        decrementSecond: function() {
            var e = this.second - this.secondStep;
            if (e < 0) {
                this.decrementMinute(!0);
                this.second = e + 60;
            } else this.second = e;
        },
        elementKeydown: function(e) {
            switch (e.keyCode) {
              case 9:
              case 27:
                this.updateFromElementVal();
                break;
              case 37:
                e.preventDefault();
                this.highlightPrevUnit();
                break;
              case 38:
                e.preventDefault();
                switch (this.highlightedUnit) {
                  case "hour":
                    this.incrementHour();
                    this.highlightHour();
                    break;
                  case "minute":
                    this.incrementMinute();
                    this.highlightMinute();
                    break;
                  case "second":
                    this.incrementSecond();
                    this.highlightSecond();
                    break;
                  case "meridian":
                    this.toggleMeridian();
                    this.highlightMeridian();
                }
                this.update();
                break;
              case 39:
                e.preventDefault();
                this.highlightNextUnit();
                break;
              case 40:
                e.preventDefault();
                switch (this.highlightedUnit) {
                  case "hour":
                    this.decrementHour();
                    this.highlightHour();
                    break;
                  case "minute":
                    this.decrementMinute();
                    this.highlightMinute();
                    break;
                  case "second":
                    this.decrementSecond();
                    this.highlightSecond();
                    break;
                  case "meridian":
                    this.toggleMeridian();
                    this.highlightMeridian();
                }
                this.update();
            }
        },
        getCursorPosition: function() {
            var e = this.$element.get(0);
            if ("selectionStart" in e) return e.selectionStart;
            if (n.selection) {
                e.focus();
                var t = n.selection.createRange(), r = n.selection.createRange().text.length;
                t.moveStart("character", -e.value.length);
                return t.text.length - r;
            }
        },
        getTemplate: function() {
            var e, t, n, r, i, s;
            if (this.showInputs) {
                t = '<input type="text" class="bootstrap-timepicker-hour" maxlength="2"/>';
                n = '<input type="text" class="bootstrap-timepicker-minute" maxlength="2"/>';
                r = '<input type="text" class="bootstrap-timepicker-second" maxlength="2"/>';
                i = '<input type="text" class="bootstrap-timepicker-meridian" maxlength="2"/>';
            } else {
                t = '<span class="bootstrap-timepicker-hour"></span>';
                n = '<span class="bootstrap-timepicker-minute"></span>';
                r = '<span class="bootstrap-timepicker-second"></span>';
                i = '<span class="bootstrap-timepicker-meridian"></span>';
            }
            s = '<table><tr><td><a href="#" data-action="incrementHour"><i class="fa fa-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="incrementMinute"><i class="fa fa-chevron-up"></i></a></td>' + (this.showSeconds ? '<td class="separator">&nbsp;</td><td><a href="#" data-action="incrementSecond"><i class="fa fa-chevron-up"></i></a></td>' : "") + (this.showMeridian ? '<td class="separator">&nbsp;</td><td class="meridian-column"><a href="#" data-action="toggleMeridian"><i class="fa fa-chevron-up"></i></a></td>' : "") + "</tr>" + "<tr>" + "<td>" + t + "</td> " + '<td class="separator">:</td>' + "<td>" + n + "</td> " + (this.showSeconds ? '<td class="separator">:</td><td>' + r + "</td>" : "") + (this.showMeridian ? '<td class="separator">&nbsp;</td><td>' + i + "</td>" : "") + "</tr>" + "<tr>" + '<td><a href="#" data-action="decrementHour"><i class="fa fa-chevron-down"></i></a></td>' + '<td class="separator"></td>' + '<td><a href="#" data-action="decrementMinute"><i class="fa fa-chevron-down"></i></a></td>' + (this.showSeconds ? '<td class="separator">&nbsp;</td><td><a href="#" data-action="decrementSecond"><i class="fa fa-chevron-down"></i></a></td>' : "") + (this.showMeridian ? '<td class="separator">&nbsp;</td><td><a href="#" data-action="toggleMeridian"><i class="fa fa-chevron-down"></i></a></td>' : "") + "</tr>" + "</table>";
            switch (this.template) {
              case "modal":
                e = '<div class="bootstrap-timepicker-widget modal hide fade in" data-backdrop="' + (this.modalBackdrop ? "true" : "false") + '">' + '<div class="modal-header">' + '<a href="#" class="close" data-dismiss="modal">×</a>' + "<h3>Pick a Time</h3>" + "</div>" + '<div class="modal-content">' + s + "</div>" + '<div class="modal-footer">' + '<a href="#" class="btn btn-primary" data-dismiss="modal">OK</a>' + "</div>" + "</div>";
                break;
              case "dropdown":
                e = '<div class="bootstrap-timepicker-widget dropdown-menu">' + s + "</div>";
            }
            return e;
        },
        getTime: function() {
            return this.hour === "" ? "" : this.hour + ":" + (this.minute.toString().length === 1 ? "0" + this.minute : this.minute) + (this.showSeconds ? ":" + (this.second.toString().length === 1 ? "0" + this.second : this.second) : "") + (this.showMeridian ? " " + this.meridian : "");
        },
        hideWidget: function() {
            if (this.isOpen === !1) return;
            this.$element.trigger({
                type: "hide.timepicker",
                time: {
                    value: this.getTime(),
                    hours: this.hour,
                    minutes: this.minute,
                    seconds: this.second,
                    meridian: this.meridian
                }
            });
            this.template === "modal" && this.$widget.modal ? this.$widget.modal("hide") : this.$widget.removeClass("open");
            e(n).off("mousedown.timepicker, touchend.timepicker");
            this.isOpen = !1;
            this.$widget.detach();
        },
        highlightUnit: function() {
            this.position = this.getCursorPosition();
            this.position >= 0 && this.position <= 2 ? this.highlightHour() : this.position >= 3 && this.position <= 5 ? this.highlightMinute() : this.position >= 6 && this.position <= 8 ? this.showSeconds ? this.highlightSecond() : this.highlightMeridian() : this.position >= 9 && this.position <= 11 && this.highlightMeridian();
        },
        highlightNextUnit: function() {
            switch (this.highlightedUnit) {
              case "hour":
                this.highlightMinute();
                break;
              case "minute":
                this.showSeconds ? this.highlightSecond() : this.showMeridian ? this.highlightMeridian() : this.highlightHour();
                break;
              case "second":
                this.showMeridian ? this.highlightMeridian() : this.highlightHour();
                break;
              case "meridian":
                this.highlightHour();
            }
        },
        highlightPrevUnit: function() {
            switch (this.highlightedUnit) {
              case "hour":
                this.showMeridian ? this.highlightMeridian() : this.showSeconds ? this.highlightSecond() : this.highlightMinute();
                break;
              case "minute":
                this.highlightHour();
                break;
              case "second":
                this.highlightMinute();
                break;
              case "meridian":
                this.showSeconds ? this.highlightSecond() : this.highlightMinute();
            }
        },
        highlightHour: function() {
            var e = this.$element.get(0), t = this;
            this.highlightedUnit = "hour";
            e.setSelectionRange && setTimeout(function() {
                t.hour < 10 ? e.setSelectionRange(0, 1) : e.setSelectionRange(0, 2);
            }, 0);
        },
        highlightMinute: function() {
            var e = this.$element.get(0), t = this;
            this.highlightedUnit = "minute";
            e.setSelectionRange && setTimeout(function() {
                t.hour < 10 ? e.setSelectionRange(2, 4) : e.setSelectionRange(3, 5);
            }, 0);
        },
        highlightSecond: function() {
            var e = this.$element.get(0), t = this;
            this.highlightedUnit = "second";
            e.setSelectionRange && setTimeout(function() {
                t.hour < 10 ? e.setSelectionRange(5, 7) : e.setSelectionRange(6, 8);
            }, 0);
        },
        highlightMeridian: function() {
            var e = this.$element.get(0), t = this;
            this.highlightedUnit = "meridian";
            e.setSelectionRange && (this.showSeconds ? setTimeout(function() {
                t.hour < 10 ? e.setSelectionRange(8, 10) : e.setSelectionRange(9, 11);
            }, 0) : setTimeout(function() {
                t.hour < 10 ? e.setSelectionRange(5, 7) : e.setSelectionRange(6, 8);
            }, 0));
        },
        incrementHour: function() {
            if (this.showMeridian) {
                if (this.hour === 11) {
                    this.hour++;
                    return this.toggleMeridian();
                }
                this.hour === 12 && (this.hour = 0);
            }
            if (this.hour === 23) {
                this.hour = 0;
                return;
            }
            this.hour++;
        },
        incrementMinute: function(e) {
            var t;
            e ? t = this.minute + e : t = this.minute + this.minuteStep - this.minute % this.minuteStep;
            if (t > 59) {
                this.incrementHour();
                this.minute = t - 60;
            } else this.minute = t;
        },
        incrementSecond: function() {
            var e = this.second + this.secondStep - this.second % this.secondStep;
            if (e > 59) {
                this.incrementMinute(!0);
                this.second = e - 60;
            } else this.second = e;
        },
        mousewheel: function(t) {
            if (this.disableMousewheel) return;
            t.preventDefault();
            t.stopPropagation();
            var n = t.originalEvent.wheelDelta || -t.originalEvent.detail, r = null;
            t.type === "mousewheel" ? r = t.originalEvent.wheelDelta * -1 : t.type === "DOMMouseScroll" && (r = 40 * t.originalEvent.detail);
            if (r) {
                t.preventDefault();
                e(this).scrollTop(r + e(this).scrollTop());
            }
            switch (this.highlightedUnit) {
              case "minute":
                n > 0 ? this.incrementMinute() : this.decrementMinute();
                this.highlightMinute();
                break;
              case "second":
                n > 0 ? this.incrementSecond() : this.decrementSecond();
                this.highlightSecond();
                break;
              case "meridian":
                this.toggleMeridian();
                this.highlightMeridian();
                break;
              default:
                n > 0 ? this.incrementHour() : this.decrementHour();
                this.highlightHour();
            }
            return !1;
        },
        place: function() {
            if (this.isInline) return;
            var n = this.$widget.outerWidth(), r = this.$widget.outerHeight(), i = 10, s = e(t).width(), o = e(t).height(), u = e(t).scrollTop(), a = parseInt(this.$element.parents().filter(function() {}).first().css("z-index"), 10) + 10, f = this.component ? this.component.parent().offset() : this.$element.offset(), l = this.component ? this.component.outerHeight(!0) : this.$element.outerHeight(!1), c = this.component ? this.component.outerWidth(!0) : this.$element.outerWidth(!1), h = f.left, p = f.top;
            this.$widget.removeClass("timepicker-orient-top timepicker-orient-bottom timepicker-orient-right timepicker-orient-left");
            if (this.orientation.x !== "auto") {
                this.picker.addClass("datepicker-orient-" + this.orientation.x);
                this.orientation.x === "right" && (h -= n - c);
            } else {
                this.$widget.addClass("timepicker-orient-left");
                f.left < 0 ? h -= f.left - i : f.left + n > s && (h = s - n - i);
            }
            var d = this.orientation.y, v, m;
            if (d === "auto") {
                v = -u + f.top - r;
                m = u + o - (f.top + l + r);
                Math.max(v, m) === m ? d = "top" : d = "bottom";
            }
            this.$widget.addClass("timepicker-orient-" + d);
            d === "top" ? p += l : p -= r + parseInt(this.$widget.css("padding-top"), 10);
            this.$widget.css({
                top: p,
                left: h,
                zIndex: a
            });
        },
        remove: function() {
            e("document").off(".timepicker");
            this.$widget && this.$widget.remove();
            delete this.$element.data().timepicker;
        },
        setDefaultTime: function(e) {
            if (!this.$element.val()) if (e === "current") {
                var t = new Date, n = t.getHours(), r = t.getMinutes(), i = t.getSeconds(), s = "AM";
                if (i !== 0) {
                    i = Math.ceil(t.getSeconds() / this.secondStep) * this.secondStep;
                    if (i === 60) {
                        r += 1;
                        i = 0;
                    }
                }
                if (r !== 0) {
                    r = Math.ceil(t.getMinutes() / this.minuteStep) * this.minuteStep;
                    if (r === 60) {
                        n += 1;
                        r = 0;
                    }
                }
                if (this.showMeridian) if (n === 0) n = 12; else if (n >= 12) {
                    n > 12 && (n -= 12);
                    s = "PM";
                } else s = "AM";
                this.hour = n;
                this.minute = r;
                this.second = i;
                this.meridian = s;
                this.update();
            } else if (e === !1) {
                this.hour = 0;
                this.minute = 0;
                this.second = 0;
                this.meridian = "AM";
            } else this.setTime(e); else this.updateFromElementVal();
        },
        setTime: function(e, t) {
            if (!e) {
                this.clear();
                return;
            }
            var n, r, i, s, o;
            if (typeof e == "object" && e.getMonth) {
                r = e.getHours();
                i = e.getMinutes();
                s = e.getSeconds();
                if (this.showMeridian) {
                    o = "AM";
                    if (r > 12) {
                        o = "PM";
                        r %= 12;
                    }
                    r === 12 && (o = "PM");
                }
            } else {
                e.match(/p/i) !== null ? o = "PM" : o = "AM";
                e = e.replace(/[^0-9\:]/g, "");
                n = e.split(":");
                r = n[0] ? n[0].toString() : n.toString();
                i = n[1] ? n[1].toString() : "";
                s = n[2] ? n[2].toString() : "";
                r.length > 4 && (s = r.substr(4, 2));
                if (r.length > 2) {
                    i = r.substr(2, 2);
                    r = r.substr(0, 2);
                }
                if (i.length > 2) {
                    s = i.substr(2, 2);
                    i = i.substr(0, 2);
                }
                s.length > 2 && (s = s.substr(2, 2));
                r = parseInt(r, 10);
                i = parseInt(i, 10);
                s = parseInt(s, 10);
                isNaN(r) && (r = 0);
                isNaN(i) && (i = 0);
                isNaN(s) && (s = 0);
                if (this.showMeridian) r < 1 ? r = 1 : r > 12 && (r = 12); else {
                    r >= 24 ? r = 23 : r < 0 && (r = 0);
                    r < 13 && o === "PM" && (r += 12);
                }
                i < 0 ? i = 0 : i >= 60 && (i = 59);
                this.showSeconds && (isNaN(s) ? s = 0 : s < 0 ? s = 0 : s >= 60 && (s = 59));
            }
            this.hour = r;
            this.minute = i;
            this.second = s;
            this.meridian = o;
            this.update(t);
        },
        showWidget: function() {
            if (this.isOpen) return;
            if (this.$element.is(":disabled")) return;
            this.$widget.appendTo(this.appendWidgetTo);
            var t = this;
            e(n).on("mousedown.timepicker, touchend.timepicker", function(e) {
                t.$element.parent().find(e.target).length || t.$widget.is(e.target) || t.$widget.find(e.target).length || t.hideWidget();
            });
            this.$element.trigger({
                type: "show.timepicker",
                time: {
                    value: this.getTime(),
                    hours: this.hour,
                    minutes: this.minute,
                    seconds: this.second,
                    meridian: this.meridian
                }
            });
            this.place();
            this.disableFocus && this.$element.blur();
            this.hour === "" && (this.defaultTime ? this.setDefaultTime(this.defaultTime) : this.setTime("0:0:0"));
            this.template === "modal" && this.$widget.modal ? this.$widget.modal("show").on("hidden", e.proxy(this.hideWidget, this)) : this.isOpen === !1 && this.$widget.addClass("open");
            this.isOpen = !0;
        },
        toggleMeridian: function() {
            this.meridian = this.meridian === "AM" ? "PM" : "AM";
        },
        update: function(e) {
            this.updateElement();
            e || this.updateWidget();
            this.$element.trigger({
                type: "changeTime.timepicker",
                time: {
                    value: this.getTime(),
                    hours: this.hour,
                    minutes: this.minute,
                    seconds: this.second,
                    meridian: this.meridian
                }
            });
        },
        updateElement: function() {
            this.$element.val(this.getTime()).change();
        },
        updateFromElementVal: function() {
            this.setTime(this.$element.val());
        },
        updateWidget: function() {
            if (this.$widget === !1) return;
            var e = this.hour, t = this.minute.toString().length === 1 ? "0" + this.minute : this.minute, n = this.second.toString().length === 1 ? "0" + this.second : this.second;
            if (this.showInputs) {
                this.$widget.find("input.bootstrap-timepicker-hour").val(e);
                this.$widget.find("input.bootstrap-timepicker-minute").val(t);
                this.showSeconds && this.$widget.find("input.bootstrap-timepicker-second").val(n);
                this.showMeridian && this.$widget.find("input.bootstrap-timepicker-meridian").val(this.meridian);
            } else {
                this.$widget.find("span.bootstrap-timepicker-hour").text(e);
                this.$widget.find("span.bootstrap-timepicker-minute").text(t);
                this.showSeconds && this.$widget.find("span.bootstrap-timepicker-second").text(n);
                this.showMeridian && this.$widget.find("span.bootstrap-timepicker-meridian").text(this.meridian);
            }
        },
        updateFromWidgetInputs: function() {
            if (this.$widget === !1) return;
            var e = this.$widget.find("input.bootstrap-timepicker-hour").val() + ":" + this.$widget.find("input.bootstrap-timepicker-minute").val() + (this.showSeconds ? ":" + this.$widget.find("input.bootstrap-timepicker-second").val() : "") + (this.showMeridian ? this.$widget.find("input.bootstrap-timepicker-meridian").val() : "");
            this.setTime(e, !0);
        },
        widgetClick: function(t) {
            t.stopPropagation();
            t.preventDefault();
            var n = e(t.target), r = n.closest("a").data("action");
            r && this[r]();
            this.update();
            n.is("input") && n.get(0).setSelectionRange(0, 2);
        },
        widgetKeydown: function(t) {
            var n = e(t.target), r = n.attr("class").replace("bootstrap-timepicker-", "");
            switch (t.keyCode) {
              case 9:
                if (this.showMeridian && r === "meridian" || this.showSeconds && r === "second" || !this.showMeridian && !this.showSeconds && r === "minute") return this.hideWidget();
                break;
              case 27:
                this.hideWidget();
                break;
              case 38:
                t.preventDefault();
                switch (r) {
                  case "hour":
                    this.incrementHour();
                    break;
                  case "minute":
                    this.incrementMinute();
                    break;
                  case "second":
                    this.incrementSecond();
                    break;
                  case "meridian":
                    this.toggleMeridian();
                }
                this.setTime(this.getTime());
                n.get(0).setSelectionRange(0, 2);
                break;
              case 40:
                t.preventDefault();
                switch (r) {
                  case "hour":
                    this.decrementHour();
                    break;
                  case "minute":
                    this.decrementMinute();
                    break;
                  case "second":
                    this.decrementSecond();
                    break;
                  case "meridian":
                    this.toggleMeridian();
                }
                this.setTime(this.getTime());
                n.get(0).setSelectionRange(0, 2);
            }
        },
        widgetKeyup: function(e) {
            (e.keyCode === 65 || e.keyCode === 77 || e.keyCode === 80 || e.keyCode === 46 || e.keyCode === 8 || e.keyCode >= 46 && e.keyCode <= 57) && this.updateFromWidgetInputs();
        }
    };
    e.fn.timepicker = function(t) {
        var n = Array.apply(null, arguments);
        n.shift();
        return this.each(function() {
            var r = e(this), s = r.data("timepicker"), o = typeof t == "object" && t;
            s || r.data("timepicker", s = new i(this, e.extend({}, e.fn.timepicker.defaults, o, e(this).data())));
            typeof t == "string" && s[t].apply(s, n);
        });
    };
    e.fn.timepicker.defaults = {
        defaultTime: "current",
        disableFocus: !1,
        disableMousewheel: !1,
        isOpen: !1,
        minuteStep: 15,
        modalBackdrop: !1,
        orientation: {
            x: "auto",
            y: "auto"
        },
        secondStep: 15,
        showSeconds: !1,
        showInputs: !0,
        showMeridian: !0,
        template: "dropdown",
        appendWidgetTo: "body",
        showWidgetOnAddonClick: !0
    };
    e.fn.timepicker.Constructor = i;
})(jQuery, window, document);
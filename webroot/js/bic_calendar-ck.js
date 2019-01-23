/*
 *
 * bic calendar
 * Autor: bichotll
 * Web-autor: bic.cat
 * Web script: http://bichotll.github.io/bic_calendar/
 * Llicència Apache
 *
 */$.fn.bic_calendar = function(e) {
    var t = $.extend({}, $.fn.bic_calendar.defaults, e);
    this.each(function() {
        function p() {
            n = $('<table class="diasmes table table">');
            v();
            var t = new Date, s = h.val();
            if (s != "" && w(s)) {
                var o = s.split("/");
                if (o[2].length == 2) {
                    o[2].charAt(0) == "0" && (o[2] = o[2].substring(1));
                    o[2] = parseInt(o[2]);
                    o[2] < 50 && (o[2] += 2e3);
                }
                t = new Date(o[2], o[1] - 1, o[0]);
            }
            var u = t.getMonth(), a = t.getFullYear();
            m(u, a);
            var f = $('<td><a href="#" class="botonmessiguiente"><i class="fa fa-arrow-right" ></i></a></td>');
            f.click(function(e) {
                e.preventDefault();
                u = (u + 1) % 12;
                u == 0 && a++;
                d(u, a);
            });
            var l = $('<td><a href="#" class="botonmesanterior"><i class="fa fa-arrow-left" ></i></a></td>');
            l.click(function(e) {
                e.preventDefault();
                u -= 1;
                if (u == -1) {
                    a--;
                    u = 11;
                }
                d(u, a);
            });
            var c = $('<table class="table header"><tr></tr></table>'), p = $('<td colspan=5 class="mesyano span6"></td>');
            c.append(l);
            c.append(p);
            c.append(f);
            p.append(r);
            e = $('<div class="bic_calendar" id="' + i + '" ></div>');
            e.prepend(c);
            e.append(n);
            h.append(e);
            E(u, a);
        }
        function d(e, t) {
            n.empty();
            v();
            m(e, t);
            E(e, t);
        }
        function v() {
            if (a != 0) {
                var e = $('<tr class="dias_semana" >'), t = "";
                $(o).each(function(e, n) {
                    t += "<td";
                    e == 0 && (t += ' class="primero"');
                    e == 6 && (t += ' class="domingo ultimo"');
                    t += ">" + n + "</td>";
                });
                t += "</tr>";
                e.append(t);
                n.append(e);
            }
        }
        function m(e, t) {
            r.text(u[e] + " " + t);
            var s = 1, o = g(1, e, t), a = b(e, t), f = e + 1, l = "";
            for (var c = 0; c < 7; c++) {
                if (c < o) {
                    var h = "";
                    c == 0 && (h += "<tr>");
                    h += '<td class="diainvalido';
                    c == 0 && (h += " primero");
                    h += '"></td>';
                } else {
                    var h = "";
                    c == 0 && (h += "<tr>");
                    h += '<td id="' + i + "_" + s + "_" + f + "_" + t + '" ';
                    c == 0 && (h += ' class="primero"');
                    c == 6 && (h += ' class="ultimo domingo"');
                    h += "><a>" + s + "</a></span>";
                    c == 6 && (h += "</tr>");
                    s++;
                }
                l += h;
            }
            var p = 1;
            while (s <= a) {
                var h = "";
                p % 7 == 1 && (h += "<tr>");
                h += '<td id="' + i + "_" + s + "_" + f + "_" + t + '" ';
                p % 7 == 1 && (h += ' class="primero"');
                p % 7 == 0 && (h += ' class="domingo ultimo"');
                h += "><a>" + s + "</a></td>";
                p % 7 == 0 && (h += "</tr>");
                s++;
                p++;
                l += h;
            }
            p--;
            if (p % 7 != 0) {
                h = "";
                for (var c = p % 7 + 1; c <= 7; c++) {
                    var h = "";
                    h += '<td class="diainvalido';
                    c == 7 && (h += " ultimo");
                    h += '"></td>';
                    c == 7 && (h += "</tr>");
                    l += h;
                }
            }
            n.append(l);
        }
        function g(e, t, n) {
            var r = new Date(n, t, e), i = r.getDay();
            i == 0 ? i = 6 : i--;
            return i;
        }
        function y(e, t, n) {
            return e > 0 && e < 13 && n > 0 && n < 32768 && t > 0 && t <= (new Date(n, e, 0)).getDate();
        }
        function b(e, t) {
            var n = 28;
            while (y(e + 1, n + 1, t)) n++;
            return n;
        }
        function w(e) {
            var t = e.split("/");
            return t.length != 3 ? !1 : y(t[1], t[0], t[2]);
        }
        function E(e, t) {
            c != 0 ? $.ajax({
                type: c.type,
                url: c.url,
                data: {
                    mes: e + 1,
                    ano: t
                },
                dataType: "json"
            }).done(function(n) {
                s = [];
                $.each(n, function(e, t) {
                    s.push(n[e]);
                });
                S(e, t);
            }) : S(e, t);
        }
        function S(e, t) {
            var n = e + 1;
            for (var r = 0; r < s.length; r++) if (s[r][0].split("/")[1] == n && s[r][0].split("/")[2] == t) {
                $("#" + i + "_" + s[r][0].replace(/\//g, "_")).addClass("event");
                $("#" + i + "_" + s[r][0].replace(/\//g, "_") + " a").attr("data-original-title", s[r][1]);
                s[r][3] && $("#" + i + "_" + s[r][0].replace(/\//g, "_")).css("background", s[r][3]);
                if (s[r][2] == "" || s[r][2] == "#") if (s[r][4] != "") {
                    $("#" + i + "_" + s[r][0].replace(/\//g, "_") + " a").attr("data-trigger", "manual");
                    $("#" + i + "_" + s[r][0].replace(/\//g, "_") + " a").addClass("manual_popover");
                } else $("#" + i + "_" + s[r][0].replace(/\//g, "_") + " a").attr("href", "javascript:false;"); else $("#" + i + "_" + s[r][0].replace(/\//g, "_") + " a").attr("href", s[r][2]);
                if (s[r][4]) {
                    $("#" + i + "_" + s[r][0].replace(/\//g, "_")).addClass("event_popover");
                    $("#" + i + "_" + s[r][0].replace(/\//g, "_") + " a").attr("rel", "popover");
                    $("#" + i + "_" + s[r][0].replace(/\//g, "_") + " a").attr("data-content", s[r][4]);
                } else {
                    $("#" + i + "_" + s[r][0].replace(/\//g, "_")).addClass("event_tooltip");
                    $("#" + i + "_" + s[r][0].replace(/\//g, "_") + " a").attr("rel", "tooltip");
                }
            }
            $("#" + i + " " + ".event_tooltip a").tooltip(l);
            $("#" + i + " " + ".event_popover a").popover(f);
            $(".manual_popover").click(function() {
                $(this).popover("toggle");
            });
        }
        var e, n, r = $('<div class="visualmesano"></div>'), i = "bic_cal_" + Math.floor(Math.random() * 99999).toString(36), s = t.events, o;
        typeof t.dias != "undefined" ? o = t.dias : o = [ "l", "m", "x", "j", "v", "s", "d" ];
        var u;
        typeof t.nombresMes != "undefined" ? u = t.nombresMes : u = [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ];
        var a;
        typeof t.show_days != "undefined" ? a = t.show_days : a = !0;
        var f;
        typeof t.popover_options != "undefined" ? f = t.popover_options : f = {
            placement: "top"
        };
        var l;
        typeof t.tooltip_options != "undefined" ? l = t.tooltip_options : l = {
            placement: "top"
        };
        var c;
        typeof t.req_ajax != "undefined" ? c = t.req_ajax : c = !1;
        var h = $(this);
        p();
    });
    return this;
};
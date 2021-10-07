(function(e) {
    e.fn.extend({
        accordion: function() {
            return this.each(function() {
                function e(e, u) {
                    $(e).parent(o).siblings().removeClass(n).children(i).slideUp(s);
                    $(e).siblings(i)[u || r](u == "show" ? s : !1, function() {
                        $(e).siblings(i).is(":visible") ? $(e).parents(o).not(t.parents()).addClass(n) : $(e).parent(o).removeClass(n);
                        u == "show" && $(e).parents(o).not(t.parents()).addClass(n);
                        $(e).parents().show();
                    });
                }
                var t = $(this), n = "active", r = "slideToggle", i = "ul, div", s = "fast", o = "li";
                if (t.data("accordiated")) return !1;
                $.each(t.find("ul, li>div"), function() {
                    $(this).data("accordiated", !0);
                    $(this).hide();
                });
                $.each(t.find("a"), function() {
                    $(this).click(function() {
                        e(this, r);
                    });
                    $(this).bind("activate-node", function() {
                        t.find(i).not($(this).parents()).not($(this).siblings()).slideUp(s);
                        e(this, "slideDown");
                    });
                });
                var u = location.hash ? t.find("a[href=" + location.hash + "]")[0] : t.find("li.current a")[0];
                u && e(u, !1);
            });
        }
    });
})(jQuery);
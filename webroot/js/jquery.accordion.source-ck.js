/**
*	@name							Accordion
*	@descripton						This Jquery plugin makes creating accordions pain free
*	@version						1.4
*	@requires						Jquery 1.2.6+
*
*	@author							Jan Jarfalk
*	@author-email					jan.jarfalk@unwrongest.com
*	@author-website					http://www.unwrongest.com
*
*	@licens							MIT License - http://www.opensource.org/licenses/mit-license.php
*/(function(e) {
    e.fn.extend({
        accordion: function() {
            return this.each(function() {
                function a(t, u) {
                    $(t).parent(o).siblings().removeClass(n).children(i).slideUp(s);
                    $(t).siblings(i)[u || r](u == "show" ? s : !1, function() {
                        $(t).siblings(i).is(":visible") ? $(t).parents(o).not(e.parents()).addClass(n) : $(t).parent(o).removeClass(n);
                        u == "show" && $(t).parents(o).not(e.parents()).addClass(n);
                        $(t).parents().show();
                    });
                }
                var e = $(this), t = "accordiated", n = "active", r = "slideToggle", i = "ul, div", s = "fast", o = "li";
                if (e.data(t)) return !1;
                $.each(e.find("ul, li>div"), function() {
                    $(this).data(t, !0);
                    $(this).hide();
                });
                $.each(e.find("a"), function() {
                    $(this).click(function(e) {
                        a(this, r);
                        return void 0;
                    });
                    $(this).bind("activate-node", function() {
                        e.find(i).not($(this).parents()).not($(this).siblings()).slideUp(s);
                        a(this, "slideDown");
                    });
                });
                var u = location.hash ? e.find("a[href=" + location.hash + "]")[0] : e.find("li.current a")[0];
                u && a(u, !1);
            });
        }
    });
})(jQuery);
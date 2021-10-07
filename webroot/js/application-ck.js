// Some general UI pack related JS
// Extend JS String with repeat method
String.prototype.repeat = function(e) {
    return (new Array(e + 1)).join(this);
};

(function(e) {
    e.fn.addSliderSegments = function(t) {
        return this.each(function() {
            var n = 100 / (t - 1) + "%", r = "<div class='ui-slider-segment' style='margin-left: " + n + ";'></div>";
            e(this).prepend(r.repeat(t - 2));
        });
    };
    e(function() {
        e("select[name='huge']").selectpicker({
            style: "btn-hg btn-primary",
            menuStyle: "dropdown-inverse"
        });
        e("select[name='large']").selectpicker({
            style: "btn-lg btn-danger"
        });
        e("select[name='info']").selectpicker({
            style: "btn-info"
        });
        e("select[name='small']").selectpicker({
            style: "btn-sm btn-warning"
        });
        e(".nav-tabs a").on("click", function(t) {
            t.preventDefault();
            e(this).tab("show");
        });
        e("[data-toggle=tooltip]").tooltip("show");
        e(".tagsinput").tagsInput();
        var t = e("#slider");
        t.length > 0 && t.slider({
            min: 1,
            max: 5,
            value: 3,
            orientation: "horizontal",
            range: "min"
        }).addSliderSegments(t.slider("option").max);
        var n = e("#slider2");
        n.length > 0 && n.slider({
            min: 1,
            max: 5,
            values: [ 3, 4 ],
            orientation: "horizontal",
            range: !0
        }).addSliderSegments(n.slider("option").max);
        var r = e("#slider3"), i = 100, s;
        if (r.length > 0) {
            r.slider({
                min: 1,
                max: 5,
                values: [ 3, 4 ],
                orientation: "horizontal",
                range: !0,
                slide: function(e, t) {
                    r.find(".ui-slider-value:first").text("$" + t.values[0] * i).end().find(".ui-slider-value:last").text("$" + t.values[1] * i);
                }
            });
            s = r.slider("option");
            r.addSliderSegments(s.max).find(".ui-slider-value:first").text("$" + s.values[0] * i).end().find(".ui-slider-value:last").text("$" + s.values[1] * i);
        }
        e(".tooltip").addClass(function() {
            if (e(this).prev().attr("data-tooltip-style")) return "tooltip-" + e(this).prev().attr("data-tooltip-style");
        });
        e("input, textarea").placeholder();
        e(".pagination a").on("click", function() {
            e(this).parent().siblings("li").removeClass("active").end().addClass("active");
        });
        e(".btn-group a").on("click", function() {
            e(this).siblings().removeClass("active").end().addClass("active");
        });
        e('a[href="#fakelink"]').on("click", function(e) {
            e.preventDefault();
        });
        e.widget("ui.customspinner", e.ui.spinner, {
            widgetEventPrefix: e.ui.spinner.prototype.widgetEventPrefix,
            _buttonHtml: function() {
                return "<a class='ui-spinner-button ui-spinner-up ui-corner-tr'><span class='ui-icon " + this.options.icons.up + "'></span>" + "</a>" + "<a class='ui-spinner-button ui-spinner-down ui-corner-br'>" + "<span class='ui-icon " + this.options.icons.down + "'></span>" + "</a>";
            }
        });
        e("#spinner-01").customspinner({
            min: -99,
            max: 99
        }).on("focus", function() {
            e(this).closest(".ui-spinner").addClass("focus");
        }).on("blur", function() {
            e(this).closest(".ui-spinner").removeClass("focus");
        });
        e(".input-group").on("focus", ".form-control", function() {
            e(this).closest(".form-group, .navbar-search").addClass("focus");
        }).on("blur", ".form-control", function() {
            e(this).closest(".form-group, .navbar-search").removeClass("focus");
        });
        e(".table .toggle-all").on("click", function() {
            var t = e(this).find(":checkbox").prop("checked");
            e(this).closest(".table").find("tbody :checkbox").checkbox(t ? "uncheck" : "check");
        });
        e(".table tbody :checkbox").on("check uncheck toggle", function(t) {
            var n = e(this), r = n.prop("checked"), i = t.type == "toggle", s = e(".table tbody :checkbox"), o = s.length == s.filter(":checked").length;
            n.closest("tr")[r ? "addClass" : "removeClass"]("selected-row");
            i && n.closest(".table").find(".toggle-all :checkbox").checkbox(o ? "check" : "uncheck");
        });
        var o = "#datepicker-01";
        e(o).datepicker({
            showOtherMonths: !0,
            selectOtherMonths: !0,
            dateFormat: "d MM, yy",
            yearRange: "-1:+1"
        }).prev(".btn").on("click", function(t) {
            t && t.preventDefault();
            e(o).focus();
        });
        e.extend(e.datepicker, {
            _checkOffset: function(e, t, n) {
                return t;
            }
        });
        e(o).datepicker("widget").css({
            "margin-left": -e(o).prev(".input-group-btn").find(".btn").outerWidth()
        });
        e("[data-toggle='switch']").wrap('<div class="switch" />').parent().bootstrapSwitch();
        window.prettyPrint && prettyPrint();
    });
})(jQuery);
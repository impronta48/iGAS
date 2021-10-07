$(document).ready(function() {
    $("#basic_validate").validate({
        rules: {
            required: {
                required: !0
            },
            email: {
                required: !0,
                email: !0
            },
            date: {
                required: !0,
                date: !0
            },
            url: {
                required: !0,
                url: !0
            },
            zip: {
                required: !0,
                digits: !0,
                minlength: 5,
                maxlength: 5
            }
        },
        errorClass: "help-inline text-danger",
        errorElement: "span",
        highlight: function(e, t, n) {
            $(e).parents(".form-group").addClass("has-error");
        },
        unhighlight: function(e, t, n) {
            $(e).parents(".form-group").removeClass("has-error");
            $(e).parents(".form-group").addClass("has-success");
        }
    });
    $("#signup_form").validate({
        rules: {
            required: {
                required: !0
            },
            email: {
                required: !0,
                email: !0
            },
            password: {
                required: !0,
                minlength: 6
            },
            confirmPassword: {
                required: !0,
                minlength: 6,
                equalTo: "#password"
            },
            url: {
                required: !0,
                url: !0
            },
            username: {
                required: !0,
                minlength: 5,
                maxlength: 16
            }
        },
        errorClass: "help-inline text-danger",
        errorElement: "span",
        highlight: function(e, t, n) {
            $(e).parents(".form-group").addClass("has-error");
        },
        unhighlight: function(e, t, n) {
            $(e).parents(".form-group").removeClass("has-error");
            $(e).parents(".form-group").addClass("has-success");
        }
    });
});
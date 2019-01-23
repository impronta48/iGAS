$("document").ready(function() {
    function e(e, t, n) {
        var r = new Date, i = r.getHours() + ":" + r.getMinutes() + ":" + r.getSeconds(), s = $(".conversation");
        s.append('<a class="list-group-item"><img src="' + e + '" class="chat-user-avatar" alt="" /><span class="username" >' + t + '<span class="time">' + i + "</span> </span><p>" + n + "</p></a>");
        s.animate({
            scrollTop: s.height() + 900
        }, 1e3);
        $(".write-message").val("").focus();
    }
    $(".contact a").click(function() {
        $(".contact a").removeClass("active");
        $(this).addClass("active");
        var t = $(this).html();
        $(".recipient").html(t);
        $(".conversation").html("");
        $(".write-message").focus();
        setTimeout(function() {
            e("images/profile50x50.png", "Jane Deo", "Hello How can I help you my friend ?");
        }, 1500);
    });
    $("#send-message").click(function() {
        var t = $(".write-message").val();
        e("images/profile50x50.png", "tupakula kumar", t);
    });
    document.getElementById("write-message").onkeypress = function(t) {
        var n = t || window.event, r = n.which || n.keyCode;
        if (r == "13") {
            var i = $(".write-message").val();
            e("images/profile50x50.png", "tupakula kumar", i);
        }
    };
});
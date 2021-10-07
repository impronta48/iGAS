$(document).ready(function() {
    function e(e) {
        if (e == "") return;
        var n = $(".event-color").val();
        $("#external-events ul").prepend('<li data-class="' + n + '" class="external-event list-group-item ' + n + ' list-group-item">' + e + " </li>");
        $("#write-event").val("");
        t();
    }
    function t() {
        $("#external-events ul li.external-event").each(function() {
            var e = {
                title: $.trim($(this).text())
            };
            $(this).data("eventObject", e);
            $(this).draggable({
                zIndex: 999,
                revert: !0,
                revertDuration: 0
            });
        });
    }
    $("#create-event").click(function() {
        var t = $("#write-event").val();
        e(t);
    });
    document.getElementById("write-event").onkeypress = function(t) {
        var n = t || window.event, r = n.which || n.keyCode;
        if (r == "13") {
            var i = $("#write-event").val();
            e(i);
        }
    };
    t();
    var n = new Date, r = n.getDate(), i = n.getMonth(), s = n.getFullYear(), o = $("#calendar").fullCalendar({
        header: {
            left: "prev,next today",
            center: "title",
            right: "month,agendaWeek,agendaDay"
        },
        selectable: !0,
        selectHelper: !0,
        select: function(e, t, n) {
            var r = prompt("Event Title:");
            r && o.fullCalendar("renderEvent", {
                title: r,
                start: e,
                end: t,
                allDay: n
            }, !0);
            o.fullCalendar("unselect");
        },
        editable: !0,
        droppable: !0,
        drop: function(e, t) {
            var n = $(this).data("eventObject"), r = $.extend({}, n);
            r.start = e;
            r.allDay = t;
            r.className = $(this).data("class");
            $("#calendar").fullCalendar("renderEvent", r, !0);
            $("#drop-remove").is(":checked") && $(this).remove();
        },
        selectable: !0,
        selectHelper: !0,
        select: function(e, t, n) {
            var r = prompt("Event Title:");
            r && o.fullCalendar("renderEvent", {
                title: r,
                start: e,
                end: t,
                allDay: n
            }, !0);
            o.fullCalendar("unselect");
        },
        events: [ {
            title: "All Day Event",
            start: new Date(s, i, 1)
        }, {
            title: "Long Event",
            start: new Date(s, i, r - 5),
            end: new Date(s, i, r - 2)
        }, {
            id: 999,
            title: "Repeating Event",
            start: new Date(s, i, r - 3, 16, 0),
            allDay: !1,
            className: "bg-danger"
        }, {
            id: 999,
            title: "Repeating Event",
            start: new Date(s, i, r + 4, 16, 0),
            allDay: !1,
            className: "bg-success"
        }, {
            title: "Meeting",
            start: new Date(s, i, r, 10, 30),
            allDay: !1,
            className: "bg-info"
        }, {
            title: "Lunch",
            start: new Date(s, i, r, 12, 0),
            end: new Date(s, i, r, 14, 0),
            allDay: !1,
            className: "bg-warning"
        }, {
            title: "Birthday Party",
            start: new Date(s, i, r + 1, 19, 0),
            end: new Date(s, i, r + 1, 22, 30),
            allDay: !1,
            className: "bg-danger"
        }, {
            title: "Click for Google",
            start: new Date(s, i, 28),
            end: new Date(s, i, 29),
            url: "http://google.com/"
        } ]
    });
});
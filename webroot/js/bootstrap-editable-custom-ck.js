$(document).ready(function() {
    $.fn.editable.defaults.mode = "inline";
    $("#username").editable();
    $("#status").editable({
        type: "select",
        title: "Select status",
        placement: "right",
        value: 2,
        source: [ {
            value: 1,
            text: "status 1"
        }, {
            value: 2,
            text: "status 2"
        }, {
            value: 3,
            text: "status 3"
        } ]
    });
    $("#comments").editable({
        title: "Enter comments",
        rows: 10
    });
    $("#dob").editable({
        format: "yyyy-mm-dd",
        viewformat: "dd/mm/yyyy",
        datepicker: {
            weekStart: 1
        }
    });
    $("#last_seen").editable({
        format: "yyyy-mm-dd hh:ii",
        placement: "bottom",
        viewformat: "dd/mm/yyyy hh:ii",
        datetimepicker: {
            weekStart: 1
        }
    });
    $("#dob").editable({
        format: "YYYY-MM-DD",
        viewformat: "DD.MM.YYYY",
        template: "D / MMMM / YYYY",
        combodate: {
            minYear: 2e3,
            maxYear: 2015,
            minuteStep: 1
        }
    });
});
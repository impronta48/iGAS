$(function() {

       
    // Time Pickers
       $('#timepicker1').timepicker();

        $('#timepicker2').timepicker({
                minuteStep: 1,
                showSeconds: true,
                showMeridian: false,
                defaultTime: false
            });
});

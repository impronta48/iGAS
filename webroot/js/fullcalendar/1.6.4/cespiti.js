/**
 * Questo script è compatibile con jQuery FullCalendar v1.6.4
 * 
 * @todo Non ho trovato modo di tradurre FullCalendar v1.6.4 out of the box.
 * 
 */

$(document).ready(function() {
	/*
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
    */
    $('#calendar').fullCalendar({
        defaultView: 'agendaWeek',
        allDayText: 'Day',
        axisFormat: 'H:mm',
        // slotLabelFormat: 'H:mm', // Probabilmente questo c'è dalla versione 2.4.0
        columnFormat: {
            month: 'dddd',
            week: 'dddd M/d',
            day: 'dddd, MMMM dd'
        },
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        editable: true,
        eventLimit: 3, // Probabilmente questo c'è dalla versione 2.1.0
        eventSources: [
            // your event source
            {
                url: 'events',
                type: 'POST',
                data: {
                //custom_param1: 'something',
                //custom_param2: 'somethingelse'
                },
                error: function() {
                alert('there was an error while fetching events!');
                },
                //color: 'light-blue',   // a non-ajax option
                //backgroundColor: 'black',  // a non-ajax option
                //eventTextColor: 'white' // a non-ajax option
            }
        
            // any other sources...
        
        ],
        dayClick: function(date, allDay, jsEvent, view) {
            endDate = new Date(date);
			if (allDay) {
                //console.log('Clicked on the entire day: ' + date);//DEBUG
                endDate.setDate(date.getDate()+1);
                endDate.setSeconds(date.getSeconds()-1);
			}else{
                //console.log('Clicked on the slot: ' + date);//DEBUG
                endDate.setMinutes(date.getMinutes()+29);
                endDate.setSeconds(date.getSeconds()+59);
            }
            $('#CespitecalendarioStart').val(
                                            date.getFullYear() + '-' +
                                            ((date.getMonth()+1) > 9 ? '' : '0') + (date.getMonth()+1) + '-' +
                                            (date.getDate() > 9 ? '' : '0') + date.getDate() + ' ' +
                                            (date.getHours() > 9 ? '' : '0') + date.getHours() + ':' + 
                                            (date.getMinutes() > 9 ? '' : '0') + date.getMinutes() + ':' +
                                            (date.getSeconds() > 9 ? '' : '0') + date.getSeconds()
                                        );
            $('#CespitecalendarioEnd').val(
                                            endDate.getFullYear() + '-' +
                                            ((endDate.getMonth()+1) > 9 ? '' : '0') + (endDate.getMonth()+1) + '-' +
                                            (endDate.getDate() > 9 ? '' : '0') + endDate.getDate() + ' ' +
                                            (endDate.getHours() > 9 ? '' : '0') + endDate.getHours() + ':' + 
                                            (endDate.getMinutes() > 9 ? '' : '0') + endDate.getMinutes() + ':' +
                                            (endDate.getSeconds() > 9 ? '' : '0') + endDate.getSeconds()
                                        );
            $('#CespitecalendarioRepeatFrom').val(
                                            date.getFullYear() + '-' +
                                            ((date.getMonth()+1) > 9 ? '' : '0') + (date.getMonth()+1) + '-' +
                                            (date.getDate() > 9 ? '' : '0') + date.getDate()
                                        );
            $('#CespitecalendarioRepeatTo').val(
                                            date.getFullYear() + '-' +
                                            ((date.getMonth()+(1+1)) > 9 ? '' : '0') + (date.getMonth()+(1+1)) + '-' +
                                            (date.getDate() > 9 ? '' : '0') + date.getDate()
                                        );
			$("#divFormEventAdd").dialog({
                title: "Aggiungi evento Calendario Cespiti",
                autoOpen: false,
                modal: true,
                draggable: false,
                resizable: false,
                width: 400,
                show: { effect: "fade", duration: 250 },
                dialogClass: "no-close"
            });
            $("#divFormEventAdd").dialog("open"); // .dialog() è di jquery-ui
			//alert('Current view: ' + view.name);
			// change the day's background color just for fun
			//$(this).css('background-color', 'red');
		},
        /*
        eventMouseover: function(calEvent, jsEvent, view) {
            $.ajax({
                url: "calendarEventInfo/" + calEvent.id,
                type: "get",
                beforeSend: function() {
                    // Maybe do something
                },
                success: function (data) {
                    // Maybe do something
                },
                error: function (xhr, status, error) {
                    //console.log(status); // DEBUG
                    //console.log(error); // DEBUG
                }
            });
        },
        */
        eventClick: function(calEvent, jsEvent, view) {
            $(window.location).attr('href', 'eventedit/' + calEvent.id);
            //console.log('ID: ' + calEvent.id);//DEBUG
            //console.log('Event: ' + calEvent.title);//DEBUG
            //console.log('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY); // This is Hardcore
            //console.log('View: ' + view.name);//DEBUG
        },
        eventResize: function(calEvent,dayDelta,minuteDelta,revertFunc){
            var newStartDate = calEvent.start.getFullYear() + '-' + 
                        ((calEvent.start.getMonth()+1) > 9 ? '' : '0') + (calEvent.start.getMonth()+1) + '-' +
                        (calEvent.start.getDate() > 9 ? '' : '0') + calEvent.start.getDate() + ' ' +
                        (calEvent.start.getHours() > 9 ? '' : '0') + calEvent.start.getHours() + ':' + 
                        (calEvent.start.getMinutes() > 9 ? '' : '0') + calEvent.start.getMinutes() + ':' +
                        (calEvent.start.getSeconds() > 9 ? '' : '0') + calEvent.start.getSeconds();
            var newEndDate = calEvent.end.getFullYear() + '-' + 
                        ((calEvent.end.getMonth()+1) > 9 ? '' : '0') + (calEvent.end.getMonth()+1) + '-' +
                        (calEvent.end.getDate() > 9 ? '' : '0') + calEvent.end.getDate() + ' ' +
                        (calEvent.end.getHours() > 9 ? '' : '0') + calEvent.end.getHours() + ':' + 
                        (calEvent.end.getMinutes() > 9 ? '' : '0') + calEvent.end.getMinutes() + ':' +
                        (calEvent.end.getSeconds() > 9 ? '' : '0') + calEvent.end.getSeconds();
            $.ajax({
                url: "calendarEventMove/" + calEvent.id,
                data: ({
                    type: calEvent.className,
                    delta: dayDelta, // Available in version 2.0.1 and later but now works....
                    id: calEvent.id,
                    user_id: calEvent.user_id,
                    cespite_id: calEvent.cespite_id,
                    event_type_id: calEvent.event_type_id,
                    newStartDate: newStartDate,
                    newEndDate: newEndDate,
                    note: calEvent.note,
                    AllDays: calEvent.AllDays,
                    allDay: calEvent.allDay
                    //entireObj: calEvent //DEBUG
                }),
                type: "POST",
                beforeSend: function() {
                    //console.log(newStartDate);
                },
                success: function (data) {
                    // alert(calEvent.title + " was dropped on " + calEvent.start);
                    $('#calendar').fullCalendar('refetchEvents');
                },
                error: function (xhr, status, error) {
                    alert(xhr.responseText); // Come portare il messaggio di errore php al posto di stampare "Internal Server Error"??
                    alert("Qualcosa è andato storto, probabilmente le nuove date combaciano con un altro evento, se il problema persiste contattare l'amministratore");
                    $('#calendar').fullCalendar('refetchEvents');
                    //revertFunc();
                }
            });
        },
        eventDrop: function(calEvent, dayDelta, revertFunc) {
            var newStartDate = calEvent.start.getFullYear() + '-' + 
                        ((calEvent.start.getMonth()+1) > 9 ? '' : '0') + (calEvent.start.getMonth()+1) + '-' +
                        (calEvent.start.getDate() > 9 ? '' : '0') + calEvent.start.getDate() + ' ' +
                        (calEvent.start.getHours() > 9 ? '' : '0') + calEvent.start.getHours() + ':' + 
                        (calEvent.start.getMinutes() > 9 ? '' : '0') + calEvent.start.getMinutes() + ':' +
                        (calEvent.start.getSeconds() > 9 ? '' : '0') + calEvent.start.getSeconds();
            var newEndDate = calEvent.end.getFullYear() + '-' + 
                        ((calEvent.end.getMonth()+1) > 9 ? '' : '0') + (calEvent.end.getMonth()+1) + '-' +
                        (calEvent.end.getDate() > 9 ? '' : '0') + calEvent.end.getDate() + ' ' +
                        (calEvent.end.getHours() > 9 ? '' : '0') + calEvent.end.getHours() + ':' + 
                        (calEvent.end.getMinutes() > 9 ? '' : '0') + calEvent.end.getMinutes() + ':' +
                        (calEvent.end.getSeconds() > 9 ? '' : '0') + calEvent.end.getSeconds();
            $.ajax({
                url: "calendarEventMove/" + calEvent.id,
                data: ({
                    type: calEvent.className,
                    delta: dayDelta, // Available in version 2.0.1 and later but now works....
                    id: calEvent.id,
                    user_id: calEvent.user_id,
                    cespite_id: calEvent.cespite_id,
                    event_type_id: calEvent.event_type_id,
                    newStartDate: newStartDate,
                    newEndDate: newEndDate,
                    note: calEvent.note,
                    AllDays: calEvent.AllDays,
                    allDay: calEvent.allDay
                    //entireObj: calEvent //DEBUG
                }),
                type: "POST",
                beforeSend: function() {
                    //console.log(newStartDate);
                },
                success: function (data) {
                    // alert(calEvent.title + " was dropped on " + calEvent.start);
                    $('#calendar').fullCalendar('refetchEvents');
                },
                error: function (xhr, status, error) {
                    alert(xhr.responseText); // Come portare il messaggio di errore php al posto di stampare "Internal Server Error"??
                    alert("Qualcosa è andato storto, probabilmente le nuove date combaciano con un altro evento, se il problema persiste contattare l'amministratore");
                    $('#calendar').fullCalendar('refetchEvents');
                    //revertFunc();
                }
            });
        }
    });
    
});

/**
 * Questo script è compatibile con jQuery FullCalendar v4.0.1
 * 
 */

$(document).ready(function() {

    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'it',
        height: 'auto',
        plugins: [ 'dayGrid', 'timeGrid', 'interaction' ],
        defaultView: 'timeGridWeek',
        allDayText: 'Day',
        views: {
            month: {
                displayEventEnd: 'true',
            }
        },
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        editable: true,
        eventLimit: 5, // Probabilmente questo c'è dalla versione 2.1.0
        eventSources: [
            {
                url: 'events.json',
                method: 'POST',
                extraParams: {
                    //custom_param1: 'something',
                    //custom_param2: 'somethingelse'
                },
                failure: function() {
                    alert('there was an error while fetching events!');
                },
                //color: 'light-blue',   // a non-ajax option
                //backgroundColor: 'black',  // a non-ajax option
                //eventTextColor: 'white' // a non-ajax option
            }
        ],
        dateClick: function(info) {
            var date = info.date;
            var jsEvent = info.jsEvent;
            var view = info.view;
            var allDay = info.allDay;
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
            $('#CespitecalendarioStartTime').val(
                                            (date.getHours() > 9 ? '' : '0') + date.getHours() + ':' + 
                                            (date.getMinutes() > 9 ? '' : '0') + date.getMinutes() + ':' +
                                            (date.getSeconds() > 9 ? '' : '0') + date.getSeconds()
                                        );
            $('#CespitecalendarioEndTime').val(
                                            (endDate.getHours() > 9 ? '' : '0') + endDate.getHours() + ':' + 
                                            (endDate.getMinutes() > 9 ? '' : '0') + endDate.getMinutes() + ':' +
                                            (endDate.getSeconds() > 9 ? '' : '0') + endDate.getSeconds()
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
			// info.dayEl.style.backgroundColor = 'red';
		},
        eventClick: function(info) {
            var calEvent = info.event;
            $(window.location).attr('href', 'eventedit/' + calEvent.id);
            //console.log('ID: ' + calEvent.id);//DEBUG
            //console.log('Event: ' + calEvent.title);//DEBUG
            //console.log('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY); // This is Hardcore
            //console.log('View: ' + info.view.name);//DEBUG
        },
        eventResize: function(info){
            var calEvent = info.event;
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
                    delta: info.endDelta, 
                    id: calEvent.id,
                    user_id: calEvent.extendedProps.user_id,
                    cespite_id: calEvent.extendedProps.cespite_id,
                    event_type_id: calEvent.extendedProps.event_type_id,
                    newStartDate: newStartDate,
                    newEndDate: newEndDate,
                    note: calEvent.extendedProps.note,
                    //AllDays: calEvent.AllDays,
                    allDay: calEvent.allDay
                    //entireObj: calEvent, //DEBUG
                }),
                type: "POST",
                beforeSend: function() {
                    // console.log(calEvent); //DEBUG
                },
                success: function (data) {
                    // alert(calEvent.title + " was dropped on " + calEvent.start);
                    // console.log(data);
                    // this.render;
                },
                error: function (xhr, status, error) { 
                    alert(xhr.responseText); // Come portare il messaggio di errore php al posto di stampare "Internal Server Error"??
                    alert("Qualcosa è andato storto, probabilmente le nuove date combaciano con un altro evento, se il problema persiste contattare l'amministratore");
                    info.revert();
                }
            });
        },
        eventDrop: function(info) {
            var calEvent = info.event;
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
                    delta: info.endDelta, 
                    id: calEvent.id,
                    user_id: calEvent.extendedProps.user_id,
                    cespite_id: calEvent.extendedProps.cespite_id,
                    event_type_id: calEvent.extendedProps.event_type_id,
                    newStartDate: newStartDate,
                    newEndDate: newEndDate,
                    note: calEvent.extendedProps.note,
                    // AllDays: calEvent.AllDays,
                    allDay: calEvent.allDay
                    //entireObj: calEvent //DEBUG
                }),
                type: "POST",
                beforeSend: function() {
                    //console.log(newStartDate);
                },
                success: function (data) {
                    // alert(calEvent.title + " was dropped on " + calEvent.start);
                    // this.render;
                },
                error: function (xhr, status, error) {
                    alert(xhr.responseText); // Come portare il messaggio di errore php al posto di stampare "Internal Server Error"??
                    alert("Qualcosa è andato storto, probabilmente le nuove date combaciano con un altro evento, se il problema persiste contattare l'amministratore");
                    info.revert();
                }
            });
        }
    });

    calendar.render();
    
});

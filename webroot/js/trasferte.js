    var emissioni_co2_auto = 130; //g/Km - Grande Punto 1.3 Benzina
	var emissioni_co2_treno = 44; //g/Km - Dati dell'Agenzia Europea per l'Ambiente (http://dataservice.eea.europa.eu/atlas/viewdata/viewpub.asp?id=3873)
	var emissioni_co2_aereo = 180; //g/Km - Dati dell'Agenzia Europea per l'Ambiente (http://www.viviconstile.org/immagini/emissioni_co2.gif)
    
    var directionsService = new google.maps.DirectionsService();

    
    if ($('#NotaspesaOrigine').val() === '')
    {       
        $('#map_canvas').gmap({ 'center': new google.maps.LatLng(45,7) });
    }
    else
    {
        $('#map_canvas').gmap().bind('init', function(evt, map) { 
                mostraPercorso();
        });   
    }   
    $('#NotaspesaOrigine').change(function(e) {mostraPercorso();}) ;
    $('#NotaspesaDestinazione').change(function(e) {               
        mostraPercorso();
    }) ;
    
    //Questo mi serve per gestire la nota spese in modalità edit-riga
    $('#NotaspesaNSDest').change(function(e) {
        $('#NotaspesaDestinazione').val($('#NotaspesaNSDest').val());   
        mostraPercorso();
    }) ;
    $('#NotaspesaAggiorna').click(function(e) {        
        mostraPercorso();                
    });
    
    function mostraPercorso()
    {
        request = {
          origin: $('#NotaspesaOrigine').val(),
          destination: $('#NotaspesaDestinazione').val(),          
          travelMode: google.maps.TravelMode.DRIVING
        };

        $('#map_canvas').gmap('displayDirections', request,
              { 'panel': document.getElementById('panel') }, 
              function(result, status) {                  
                    if ( status !== 'OK' ) {
                        $("#warnings_panel").html("Percorso non trovato");                        
                    }
        });
       
       var map = $("#map_canvas").gmap("get", "map");
       google.maps.event.trigger(map, "resize");
       
        // Route the directions and pass the response to a
        // function to create markers for each step.
       directionsService.route(request, function(response, status) {
         
         if (status === google.maps.DirectionsStatus.OK) {
           var warnings = document.getElementById("warnings_panel");
           warnings.innerHTML = "" + response.routes[0].warnings + "";
           computeTotalDistance(response);
         }
       });


    }
    

    function computeTotalDistance(result) 
    {
        var total = 0;
        var myroute = result.routes[0];
        for (i = 0; i < myroute.legs.length; i++) {
          total += myroute.legs[i].distance.value;
        }
        total = total / 1000; 
        if ($("#NotaspesaRitorno").prop('checked') === true)
        {
            $("#NotaspesaKm").val(total*2);
        }
        else
        {
            $("#NotaspesaKm").val(total);
        }
        stimaPrezzi();
    }

    function convertiValuta()
    {
        $( "#NotaspesaModalImporto").val( $( "#NotaspesaImportoVal").val() * $( "#NotaspesaTasso").val());
    }

    function stimaPrezzi() 
    {
        var co2 = $('#NotaspesaLegendaMezziId option:selected').attr('co2');        
        var costokm= $('#NotaspesaLegendaMezziId option:selected').attr('costokm');
        var biglietto= $('#NotaspesaLegendaMezziId option:selected').attr('biglietto');
        var km = $( "#NotaspesaKm").val();                        
        
        if (biglietto === undefined)
        {
            $( "#NotaspesaImportoVal").val(Math.round(km * costokm));
            $( "#NotaspesaModalImporto").val(Math.round(km * costokm));
        }
        else
        {
            if ( !$( "#NotaspesaImportoVal").val() )
            {
                $( "#NotaspesaImportoVal").val('');
                $( "#NotaspesaImportoVal").pulsate({
                    color : '#468845',
                    repeat: 5
                });
                $( "#NotaspesaImportoVal"). attr('placeholder', 'Inserire qui il valore del biglietto');
                $( "#NotaspesaModalImporto").val('');
            }
        }
        
        $("#stimato-treno").html( Math.round(km*emissioni_co2_treno/1000));        
        $("#stimato-auto").html(Math.round(km*emissioni_co2_auto/1000) );        
        $("#stimato-aereo").html("--");
        if (co2 > 90 && $('#NotaspesaLegendaMezziId option:selected').attr('value')>2 )
        {
            $("#stimato-auto").html(Math.round(km*co2/1000) );
        }        
        if (km > 400)
        {
            $("#stimato-aereo").html(Math.round(km*emissioni_co2_aereo/1000));
        }
        $("#co2-calc").show();
    }
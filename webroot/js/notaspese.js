$('document').ready(function(){
/* 
 * Queste funzioni servono per gestire l'editing inline della notaspese
 */

//Funzione che viene chiamata quando faccio submit di una riga
  function submit_riga(ed) {         
      $.ajax({
             type: 'POST',
             url: $('form').attr('action'),
             data: $('form').serialize(), // serializes the form's elements.
             success: function(response,textStatus,xhr){                                                                           
                          //Inserire qui la riga salvata
                          $(ed).replaceWith(response);  
                          
                          //Tolgo gli eventi tutte le volte perchè se no esplode
                          $('.btn-edit-riga').unbind('click');
                          $('.btn-del-riga').unbind('click');
                          
                          //Mi attacco ad un evento molto generico perchè
                          //non riesco ad intercettare quello specifico
                          $('.btn-edit-riga').click( function(e) {
                                    handle_edit_riga(e);
                          });

                          $('.btn-del-riga').click( function(e) {
                                    e.preventDefault();
                                    handle_del_riga(e);
                          });
                      }, 
             error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
              },
           });        
  };

  //Manda la riga corrente in edit
  //Associa gli eventi ai pulsanti della riga corrente
  function edit_riga(ed, id_row)
  {
    $.ajax({
        type: 'GET',
        url: $('form').attr('action'),
        data: {id: id_row},
        beforeSend: function(xhr) {
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        },
        success: function(response) {            
                if (response) {                    
                    ed.replaceWith(response);
                    //Binding dinamico
                    $('#submit-riga').on('click', function (e) { e.preventDefault(); 
                        submit_riga($(e.target).parent('td').parent('tr'));}
                        ); 
                    $(".chosen-select").chosen();
                    handle_btn_dettagli();
                    $('#NotaspesaECatSpesa').chosen().change( function(e) {
                         handle_btn_dettagli();
                    });
                }
            },
        error: function(e) {
            alert("An error occurred: " + e.responseText.message);
            console.log(e);
        }
    });            
  }
  
//  //Quando viene premuto il pulsante "del" -- SPOSTATO in IGAS.js
//  function handle_del_riga(evento)
//  {
//    $.ajax({
//        type: 'GET',
//        url: evento.target.href,
//        success: function (response) {
//            evento.target.parentNode.parentNode.remove();
//        },
//        error: function (e) {
//           alert("An error occurred: " + e.responseText.message);
//           console.log(e);
//        }
//    });
//  }

  //Gestisce l'evento "click" sul pulsante edit della riga
  function handle_edit_riga(e)
  {    
      //Controllo se c'è un pulsante già in edit, in quel caso devo salvare
      if($('#submit-riga').length > 0) 
      {
        submit_riga($('#submit-riga').parent('td').parent('tr'));
      }
      edit_riga($(e.target).parent('td').parent('tr'), $(e.target).attr('id'));           
  }

  /** Attiva i dettagli della nota spese per la trasferta in auto/treno/etc **/
function handle_btn_dettagli()
  {
    if ($( "#NotaspesaECatSpesa").val()==1)
    {
        $('#btn-dettagli').show('fast');
        $('#NotaspesaImporto').prop('readonly', true);      
    }
    else
    {
        $('#btn-dettagli').hide('fast');
        $('#NotaspesaImporto').prop('readonly', false);             
    }
      
  }  
  

  
  /*//Click sul pulsante per aggiungere una trasferta
  $('#btn-aggiungi').click( function(e) {
        $('#notaspese-attivita tbody').prepend('<tr id="edit-riga"></tr>');
        edit_riga($('tr#edit-riga'));
  });

  $('#btn-aggiungi-ricorrente').click( function(e) {
    alert('funzione non ancora pronta, mi spiace');
  });
  
  $('#btn-stampa').click( function(e) {
    window.print();
  });
  
  $('#btn-riordina').click( function(e) {
    location.reload(false);
  });
  
  //Pulsante EDIT di ogni riga (devo individuare la riga a cui appartiene il mio pulsante)
  $('.btn-edit-riga').click( function(e) {
          handle_edit_riga(e);
  });
  
  $('.btn-del-riga').click( function(e) {
          e.preventDefault();
          handle_del_riga(e);
  });
*/

/*$(document).on({
     ajaxStart: function() { $('#pleaseWaitDialog').modal();   },
     ajaxStop: function() { $('#pleaseWaitDialog').modal('hide'); }    
});
*/

$("#dpMonths").datepicker( {
    format: "mm/yyyy",
    viewMode: "months",
    minViewMode: 1,
    language: 'it'
});


$("#dpMonths").on('change', function(e) {
    pairs = location.pathname.split('/');
    ma = $("#dpMonths").val().split('/');
    
    l = '';
    anno = false;
    for (i= 0; i < pairs.length; ++i) {
        ppairs = pairs[i].split(':');
        if (ppairs.length == 2)
        {
            if (ppairs[0]=='mese')
            {
                ppairs[1] = ma[0];
            }
            if ( ppairs[0]=='anno')
            {
                anno = true;
                ppairs[1] = ma[1];
            }
            l = l + ppairs[0] + ':' + ppairs[1] + '/';
        }
        else
        {
            //Se non è una coppia di named parameters
            l = l + pairs[i]+ '/'; 
        }
       
    }
     if (!anno) {
            l = l + 'anno:' + ma[1]+ '/'; 
        }
    location.pathname = l.substr(0,l.length -1);
});

$("#non-euro-zone").hide();        
$("#co2-calc").hide();              
$('#responsive').on('show.bs.modal', function (e) {
    $('#NotaspesaNSDest').val($('#NotaspesaDestinazione').val());                     
});
$('#responsive').on('hide.bs.modal', function (e) {
    $('#NotaspesaImporto').val($('#NotaspesaModalImporto').val());                     
});
// $('#btn-modal-save').click( function (e) {
//         $('#NotaspesaImporto').val($('#NotaspesaModalImporto').val());                     
//         //Scrivo nella descrizione se è andata e ritorno
//         rit = '';
//         if ($('#NotaspesaRitorno').is(':checked') )
//         {
//             rit = ' (A/R)';
//         }

//         $('#NotaspesaDescrizione').val( $( "#NotaspesaLegendaMezziId option:selected" ).text() + ' '+  $('#NotaspesaOrigine').val() + ' > ' + $('#NotaspesaDestinazione').val() + rit);
//         $('#responsive').modal('hide');
// });
$( "#NotaspesaRitorno").change(function(e) {mostraPercorso();});
$( "#NotaspesaImportoVal").change(function(e) {convertiValuta();});
$( "#NotaspesaTasso").change(function(e) {convertiValuta();});
$( "#NotaspesaLegendaMezziId").change(function(e) {stimaPrezzi();});      
$("#non-euro").click(function (e) {            
    $("#non-euro-zone").toggle();
    $("#euro-addon").toggle();
    return false;
    }
);


    //Funzione che viene chiamata quando faccio un applica tag
    function submit_action(ed, action) {     
          //console.log($('form#multiriga').serialize());
          $.ajax({
                 type: 'POST',
                 url:  baseurl + '/notaspese/' + action + '/' + ed.id ,   //ed.id è l'id del <a id="XXX"> e diventa il  parametro del controller
                 data: $('form#multiriga').serialize(), // serializes the form's elements.
                 success: function(response,textStatus,xhr){   
                            window.location.reload(true);
                          }, 
                 error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                  } 
               });        
      };

    $('#spostamento').hide();

    $('#NotaspesaECatSpesa').on('change', function(){
        if(this.value == 1) {
          $('#spostamento').show(500);
        } else {
          $('#spostamento').hide(500);
        }
      })

    $( '#select-all').change ( function() {
        $('.selectable').trigger('click');
    });

    //Ricevo un click su una funzione assegna TAG
    $('a.rimborsa').click( function(e) {
        e.preventDefault();
        submit_action(e.target, 'rimborsa');
    });
	
	//Ricevo un click su una funzione assegna TAG
    $('a.stampa').click( function(e) {
        e.preventDefault();

    if($('input[type=checkbox]:checked').length == 0){
      alert('Devi Selezionare almeno un elmento!');
      return;
    } 

		$('form#multiriga').attr('action', baseurl + '/notaspese/stampa');
		$('form#multiriga').submit();
    });

    $('a.stampa_collaboratore').click( function(e) {
        e.preventDefault();
        
    if($('input[type=checkbox]:checked').length == 0){
      alert('Devi Selezionare almeno un elmento!');
      return;
    } 

    $('form#multiriga').attr('action', baseurl + '/notaspese/stampa_collaboratore');
    $('form#multiriga').submit();
    });
    
});
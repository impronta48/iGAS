$('document').ready(function(){
    //Funzione che viene chiamata quando faccio un applica tag
    function submit_action(ed, action) {     
          //console.log($('form#multiriga').serialize());
          $.ajax({
                 type: 'POST',
                 url:  app.url + '/ore/' + action + '/' + ed.id ,   //ed.id è l'id del <a id="XXX"> e diventa il  parametro del controller
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

    $( '#select-all').change ( function() {
        $('.selectable').trigger('click');
    });

    //Ricevo un click su una funzione assegna TAG
    $('a.paga').click( function(e) {
        e.preventDefault();
        submit_action(e.target, 'paga');
    });

    //Ricevo un click su una funzione assegna TAG
    $('a.stampa').click( function(e) {
        e.preventDefault();

    if($('input[type=checkbox]:checked').length == 0){
      alert('Devi Selezionare almeno un elmento!');
      return;
    } 

    $('form#multiriga').attr('action', app.url + '/ore/stampa');
    $('form#multiriga').submit();
    });
    
});
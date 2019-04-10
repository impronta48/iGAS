$('document').ready(function(){

    function persona_UpdateH1()
    {
        //Aggiorno anche l'H1
        $('#DisplayName').text($( '#PersonaDisplayName').val());
    }
    
    function persona_DisplayName()
    {
            if( $( '#PersonaSocieta').val() !== '' )
            {
                $( '#PersonaDisplayName').val($( '#PersonaSocieta').val());
            }
            else{
                $( '#PersonaDisplayName').val( $( '#PersonaNome').val() + ' ' + $( '#PersonaCognome').val()  ) ;
            }
            persona_UpdateH1();
    }

    //Funzione che viene chiamata quando faccio un applica tag
    function submit_tag(ed, action) {     
          //console.log($('form#multiriga').serialize());
          $.ajax({
                 type: 'POST',
                 url:  app.url + '/persone/' + action + '/' + ed.id ,
                 data: $('form#multiriga').serialize(), // serializes the form's elements.
                 success: function(response,textStatus,xhr){                                                                           
                            window.location.reload(true);
                          }, 
                 error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                  },
               });        
      };
    $( "#PersonaDataDiNascita" ).datepicker( { dateFormat: 'yy-mm-dd' });
    $( "#PersonaUltimoContatto" ).datepicker( { dateFormat: 'yy-mm-dd' });

    $( '#select-all').change ( function() {
        $('.select-persona').trigger('click');
    });

    //Ricevo un click su una funzione assegna TAG
    $('a.change-tag').click( function(e) {
        e.preventDefault();
        submit_tag(e.target, 'addtag');
    });
    
    //Ricevo un click su una funzione assegna TAG
    $('a.delete-tag').click( function(e) {
        e.preventDefault();
        submit_tag(e.target,'deletetag');
    });
    
    //Ricevo un click su una funzione aggiungi a mailchimp
    $('a.subscribe-mailchimp').click( function(e) {
        e.preventDefault();
        submit_tag(e.target,'subscribe');
    });
    
    $( '#PersonaSocieta').change ( function() {persona_DisplayName();});
    $( '#PersonaNome').change ( function() {persona_DisplayName();});
    $( '#PersonaCognome').change ( function() {persona_DisplayName();});
    $( '#PersonaDisplayName').change ( function() {persona_UpdateH1()();});
    
    //Ricevo un click su una funzione dlete target
    $('a.delete-contacts').click(function (e) {
        e.preventDefault();
        submit_tag(e.target, 'deleteMulti');
    });

    
    // Form Validation
	$("#PersonaEditForm").validate({
		rules:{
			required:{
				required:true
			},
			email:{
				required:false,
				email: true
			},
			date:{
				required:false,
				date: true
			},
			complete_url:{
				required:false,
				complete_url: true
                
			},
			zip: {
				required: false,
				digits: true,
				minlength: 5,
				maxlength: 5
			}
		},
		errorClass: "help-inline text-danger",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.form-group').addClass('has-error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.form-group').removeClass('has-error');
			$(element).parents('.form-group').addClass('has-success');
		}
	});
    
    
  
//    re = new RegExp(v + '[\\W]*', 'i');
//    orig = $(dest).val();
//    n = orig.search(re);
//
//    if (n < 0) //Non ho trovato nessun match
//    {
//        $(dest).val(orig.trim() + ' ' + v);
//
//        $(this).addClass('animated bounce active');
//    }
//    else    //n contiene la posizione del match
//    {
//        $(dest).val(orig.replace(re, '').trim());
//        $(this).removeClass('animated bounce active');
//    }

});
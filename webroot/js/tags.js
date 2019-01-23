/** Script usato per la gestione dei tag nelle view **/
$('document').ready(function(){
    dest = '.dest-suggestion';
    $(dest).tagsInput({
		        	'defaultText':'Aggiungi un Tag',
                    'removeWithBackspace' : true,   
                    'width': '100%',
                    'height': '70px'
	        	});	
    
    //Se fai click su un tag suggestion lo aggiungo al select box se non c'è.
    //Se c'è già lo tolgo
    $('.tag-suggestion').click( function() {
        v = $(this).html();  //Il valore selezionato        
                        
        if ($(dest).tagExist(v)) 
        { 
            $(dest).removeTag(v);
        }
        else
        {
            $(dest).addTag(v);
        }
        
        //console.log();
    });
});
// Ajax Code
$(document).ready(function(){		
    $(".fase").attr("disabled","disabled");
	aggiornafase();
	
    $(".attivita").change(function(){
		aggiornafase();
    });
   
});

function aggiornafase()
{
    var fase = $(".fase option:selected").attr('value');
	$(".fase").attr("disabled","disabled");
	$(".fase").html("<option>Please wait...</option>");
    
	var id = $(".attivita option:selected").attr('value');
	
		
	$.get(baseurl + "/faseattivita/getlist/" + id,  function(data){
			$(".fase").removeAttr("disabled");
			$(".fase").html(data);
			$(".fase").attr('size', 5);
			$(".fase").focus();
            //Dopo aver caricato il conenuto devo riforzare il valore selezionato
            $(".fase").val( fase );
        });
    
}
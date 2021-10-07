    $(document).ready(function(){
    	// Smart Wizard 	
  		$('#wizard').smartWizard();
      	$('#wizardVertical').smartWizard({transitionEffect:'slide'});
     
		

      function onFinishCallback(){
        $('#wizard').smartWizard('showMessage','Finish Clicked');
        //alert('Finish Clicked');
      }     
		});

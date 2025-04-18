<?php $baseformclass = Configure::read('iGas.baseFormClass'); ?> 

 <?php
 ///RIGA VUOTA PER INSERIMENTO
     echo $giorno;
     echo $this->Html->tableCells(
        [$this->Form->input('Notaspesa.data', ['label'=>false,                                                          
                                                          'type' => 'date',                                                                      
                                                          'dateFormat' => 'D',
                                                          'default' => $giorno,
                                                        ]) . 
            $this->Form->input('Notaspesa.id'),
            
            $this->Form->input('Notaspesa.eAttivita', ['label'=>false,                                                    
                                                    'options' => $eAttivita, 
                                                    'default' => $attivita_default, 
                                                    'class'=>'chosen-select col col-md-8 attivita',
                                                   ]) . 
			$this->Form->input('Notaspesa.faseattivita_id', ['label'=>'Fase Attività', 													  
												  'class'=>'fase form-control col col-md-8 input-xs']) ,
												  
            $this->Form->input('Notaspesa.destinazione', ['label'=>false,'size'=>10, 'default' => $dest,]),
            
            $this->Form->input('Notaspesa.eCatSpesa', ['label'=>false,
                                                    'options'=>$eCatSpesa, 
                                                    'class'=>'chosen-select col col-md-10',
                                                    
                                                   ]),
            $this->Form->input('Notaspesa.importo', ['label'=>false]) .
                '<button id="btn-dettagli" class="btn btn-xs btn-primary" data-toggle="modal" href="#responsive">inserisci dettagli</button>',  
            
            $this->Form->input('Notaspesa.descrizione', ['label'=>false,'size'=>15]),            
            
            
            $this->Form->input('Notaspesa.fatturabile',  [
                          'type' => 'checkbox',
                          'default' => 1,
                          'label' => 'Fatturabile al cliente finale',
                          'class'=>false,
                          'label' => ['class' => null],                          
                    ]) . 
            $this->Form->input('Notaspesa.rimborsabile',  [
                          'type' => 'checkbox',
                          'default' => 1,
                          'class'=>false,
                          'label' => ['class' => null],                          
                    ]),
            
            '<a id="submit-riga" class="btn btn-primary btn-xs" href="#">Salva Riga</a>',                        
           ]//,
          //array('id'=>'edit-riga')
        );     
    ?>

<script>
	aggiornafase();
	$(document).on("change", '.attivita', function(event) { 		
		aggiornafase();
	});
    
</script>
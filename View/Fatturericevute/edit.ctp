<?php echo $this->Js->set('url', $this->request->base); //Mi porta il path dell'applicazione nella view'?>
<?php echo $this->Html->script('faseattivita',array('inline' => false)); ?>
<?php $baseformclass = Configure::read('iGas.baseFormClass'); ?> 


<div class="fatturericevutes form">
<?php echo $this->Form->create('Fatturaricevuta', array(
        'inputDefaults' => array(
		'div' => 'form-group',
		'label' => array(
			'class' => 'col col-md-2 control-label'
		),
		'wrapInput' => 'col col-md-4',
		'class' => $baseformclass,
	),	
	'class' => 'well form-horizontal'       
    ));  ?>
    
		<fieldset>
		<legend>Modifica Documento Ricevuto</legend>
	<?php
        echo $this->Form->input('id');
        echo $this->Form->input('fornitore_id', array('class' => 'chosen-select'));    
        echo $this->Form->input('protocollo_ricezione');
		echo $this->Form->input('legenda_tipo_documento_id', array('options'=>$legenda_tipo_documento,'label'=>'Tipo Documento','class' => 'chosen-select'));
		echo $this->Form->input('progressivo');        
		echo $this->Form->input('annoFatturazione');		
		
        echo $this->Form->input('dataFattura', array('type' => 'date', 'dateFormat' => 'DMY', 'class'=>'','label'=>'Data Documento'));
		echo $this->Form->input('motivazione');
		echo $this->Form->input('provenienza', array('options'=> $provenienza));
		echo $this->Form->input('attivita_id', array('class'=>'attivita chosen-select' . $baseformclass));  //array('class'=>'chosen-select')
		echo $this->Form->input('faseattivita_id', array('label'=>'Fase Attività', 'options'=>$faseattivita, 'class' => 'fase ' . $baseformclass));
        echo $this->Form->input('legenda_cat_spesa_id', array('options'=>$legenda_cat_spesa, 'label'=>'Tipo Spesa','class' => 'chosen-select'));        
		echo $this->Form->input('importo');		
		echo $this->Form->input('imponibile');
		echo $this->Form->input('iva');
		echo $this->Form->input('fuoriIva');
        echo $this->Form->input('scadPagamento', array('type' => 'date', 'dateFormat' => 'DMY', 'class'=>''));
		echo $this->Form->input('ritenutaAcconto');		
		echo $this->Form->input('scadenzaRitenutaAcconto', array('type' => 'date', 'dateFormat' => 'DMY', 'class'=>''));
		echo $this->Form->input('pagato', array('class'=>false,'wrapInput' => 'col col-md-10 col-md-offset-2', 'type'=>'checkbox','enabled'=>'false'));
		echo $this->Form->input('pagatoRitenutaAcconto', array('class'=>false, 'wrapInput' => 'col col-md-10 col-md-offset-2', 'type'=>'checkbox'));
		
	?>
	</fieldset>
    <?php echo $this->Form->button('Salva Fattura Ricevuta', array('name'=>'submit-fr', 'class'=>'btn btn-primary')); ?>
    &nbsp;
    <?php 
        //Verificare che non sia pagato, se pagato disabilita il bottone e metti un link a prima nota
        echo $this->Form->button('Salva e Paga fattura (registra in Prima Nota)', array('name'=>'submit-pn', 'class'=>'btn btn-primary')); 
    ?>
    
    
</form>
</div>
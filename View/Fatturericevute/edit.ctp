<?php echo $this->Js->set('url', $this->request->base); //Mi porta il path dell'applicazione nella view'?>
<?php echo $this->Html->script('faseattivita',array('inline' => false)); ?>
<?php $baseformclass = Configure::read('iGas.baseFormClass'); ?> 

<div class="fatturericevutes form">
<?php echo $this->Form->create('Fatturaricevuta', array(
		'enctype' => 'multipart/form-data',
        'inputDefaults' => array(
		'div' => 'form-group',
		'label' => array(
			'class' => 'col col-md-2 control-label'
		),
		'wrapInput' => 'col col-md-7',
		'class' => 'form-control '.$baseformclass,
	),	
	'class' => 'well form-horizontal'       
    ));  ?>
    
		<fieldset>
		<legend>Modifica Documento Ricevuto</legend>
	<?php
        echo $this->Form->input('id');// Questo non è valorizzato
        echo $this->Form->input('fornitore_id', array('class' => 'chosen-select'));    
        echo $this->Form->input('protocollo_ricezione');
		echo $this->Form->input('legenda_tipo_documento_id', array('options'=>$legenda_tipo_documento,'label'=>'Tipo Documento','class' => 'chosen-select'));
		echo $this->Form->input('progressivo');        
		echo $this->Form->input('annoFatturazione');		
        // echo $this->Form->input('dataFattura', array('type' => 'date', 'dateFormat' => 'DMY', 'class'=>'','label'=>'Data Documento'));
		echo $this->Form->input('dataFattura', array('type'=>'text', 'label' => 'Data Documento', 'dateFormat' => 'DMY', 'class'=> 'datepicker form-control',));
		echo $this->Form->input('motivazione');
		echo $this->Form->input('provenienza', array('options'=> $provenienza));
		echo $this->Form->input('attivita_id', array('class'=>'attivita chosen-select' . $baseformclass));  //array('class'=>'chosen-select')
		echo $this->Form->input('faseattivita_id', array('label'=>'Fase Attività', 'options'=>$faseattivita, 'class' => 'fase form-control input-xs'));
        echo $this->Form->input('legenda_cat_spesa_id', array('options'=>$legenda_cat_spesa, 'label'=>'Tipo Spesa','class' => 'chosen-select'));        
		echo $this->Form->input('importo');		
		echo $this->Form->input('imponibile');
		echo $this->Form->input('iva');
		echo $this->Form->input('fuoriIva');
		// echo $this->Form->input('scadPagamento', array('type' => 'date', 'dateFormat' => 'DMY', 'class'=>''));
		echo $this->Form->input('scadPagamento', array('type'=>'text', 'label' => 'Data Documento', 'dateFormat' => 'DMY', 'class'=> 'datepicker form-control',));
		echo $this->Form->input('ritenutaAcconto');		
		// echo $this->Form->input('scadenzaRitenutaAcconto', array('type' => 'date', 'dateFormat' => 'DMY', 'class'=>''));
		echo $this->Form->input('scadenzaRitenutaAcconto', array('type'=>'text', 'label' => 'Data Documento', 'dateFormat' => 'DMY', 'class'=> 'datepicker form-control',));
		//Questo è profondamente sbagliato ma l'alternativa è creare un metodo nel Controller che non sarà
		//associato a nessuna View. Si potrebbe anche mettere nel Component UploadFilesComponent.php ma
		//leggo in giro che è sbagliato perchè i Component dovrebbero essere fruibili solo dai Controller 
		//ed infatti di default i Controller non sono Visibili alle View. 
		foreach(Configure::read('iGas.commonFiles') as $ext => $mimes){
			if(file_exists(WWW_ROOT.'files'.DS.strtolower($this->request->controller).DS.$id.'.'.$ext)){
				echo 'E\' già stato caricato uno documento.';
				echo $this->Html->link(__('Download this '.strtoupper($ext)), HTTP_BASE.DS.APP_DIR.DS.'files'.DS.$this->request->controller.DS.$id.'.'.$ext, array('class'=>'btn btn-xs btn-primary'));
				echo '&nbsp;'; // Uso questo anche se non è bello perchè vedo che ogni tanto è già usato.
				echo $this->Html->link(__('Delete this '.strtoupper($ext)), array('action' => 'deleteDoc', $id), array('class'=>'btn btn-xs btn-primary'), __('Are you sure you want to delete %s.%s?', $id, $ext));
				echo '<br />Un nuovo upload sovrascriverà il vecchio documento.';
			}
		}
		echo $this->Form->input('uploadFile', array('label'=>'Upload File', 'class'=>false, 'type'=>'file'));
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

<?php echo $this->Js->set('url', $this->request->base); //Mi porta il path dell'applicazione nella view'?>
<?php echo $this->Html->script('faseattivita',['inline' => false]); ?>
<?php $baseformclass = Configure::read('iGas.baseFormClass'); ?> 

<div class="fatturericevutes form">
<?php echo $this->Form->create('Fatturaricevuta', [
	'enctype' => 'multipart/form-data',
	'inputDefaults' => [
		'div' => 'form-group',
		'label' => [
			'class' => 'col col-md-2 control-label'
		],
		'wrapInput' => 'col col-md-7',
		'class' => 'form-control '.$baseformclass,
	],
	'class' => 'well form-horizontal'       
    ]);  ?>
	<fieldset>
		<legend>Aggiungi Documento Ricevuto</legend>
	<?php
        echo $this->Form->input('fornitore_id', ['class' => 'chosen-select']);    
    ?>   
        <div class="row">
        <div class="col col-md-4 col-md-offset-2">
        <div id="add-fornitore" class="btn btn-xs btn-default"><i class="fa fa-plus-square"></i> Inserisci fornitore non in elenco</div>
        <fieldset id="dettagli-fornitore" class="well">
            <label>Fornitore Non In Elenco</label>            
    <?php
        echo $this->Form->input('Fornitore.DisplayName');
        echo $this->Form->input('Fornitore.piva');
        echo $this->Form->input('Fornitore.iban');
        echo $this->Form->input('Fornitore.NomeBanca');
    ?>                
        </fieldset>
        </div>
        </div>
    <?php        	
		echo $this->Form->input('legenda_tipo_documento_id', ['options'=>$legenda_tipo_documento,'label'=>'Tipo Documento','class' => 'chosen-select']);
        echo $this->Form->input('protocollo_ricezione');
		echo $this->Form->input('progressivo');        
		echo $this->Form->input('annoFatturazione');				
        // echo $this->Form->input('dataFattura', array('type' => 'date', 'dateFormat' => 'DMY', 'class'=>'','label'=>'Data Documento'));
		echo $this->Form->input('dataFattura', ['type' => 'text', 'value' => date('Y-m-d'), 'dateFormat' => 'DMY', 'label'=>'Data Documento', 'class'=> 'datepicker form-control',]);
		echo $this->Form->input('motivazione');
		echo $this->Form->input('provenienza', ['options'=> $provenienza]);
		echo $this->Form->input('attivita_id', ['class'=>'attivita chosen-select' . $baseformclass]);  //array('class'=>'chosen-select')
		echo $this->Form->input('faseattivita_id', ['label'=>'Fase Attività', 'options'=>$faseattivita, 'class' => 'fase form-control input-xs']);
        echo $this->Form->input('legenda_cat_spesa_id', ['options'=>$legenda_cat_spesa, 'label'=>'Tipo Spesa','class' => 'chosen-select']);        
		echo $this->Form->input('importo');		
		echo $this->Form->input('imponibile');
		echo $this->Form->input('iva');
		echo $this->Form->input('fuoriIva');
		// echo $this->Form->input('scadPagamento', array('type' => 'date', 'dateFormat' => 'DMY', 'class'=>''));
		echo $this->Form->input('scadPagamento', ['type' => 'text', 'value' => date('Y-m-d'), 'dateFormat' => 'DMY', 'class'=> 'datepicker form-control',]);
		echo $this->Form->input('ritenutaAcconto');		
		// echo $this->Form->input('scadenzaRitenutaAcconto', array('type' => 'date', 'dateFormat' => 'DMY', 'class'=>''));
		echo $this->Form->input('scadenzaRitenutaAcconto', ['type' => 'text', 'value' => date('Y-m-d'), 'dateFormat' => 'DMY', 'class'=> 'datepicker form-control',]);
		// Ho notato che input type="file" non si prende gli inputDefaults settati in $this->Form->create() all'inizio del file
		//echo $this->Form->file('uploadFile');
		// Meglio usare questa sintassi per creare input type="file"
		echo $this->Form->input('uploadFile', ['label'=>'Upload File PDF', 'class'=>false, 'type'=>'file']);
		echo $this->Form->input('pagato', ['class'=>false,'wrapInput' => 'col col-md-10 col-md-offset-2', 'type'=>'checkbox']);
		echo $this->Form->input('pagatoRitenutaAcconto', ['class'=>false, 'wrapInput' => 'col col-md-10 col-md-offset-2', 'type'=>'checkbox']);
		
	?>
	</fieldset>
    <?php echo $this->Form->button('Salva Fattura Ricevuta', ['name'=>'submit-fr', 'class'=>'btn btn-primary']); ?>
    &nbsp;
    <?php 
        //Verificare che non sia pagato, se pagato disabilita il bottone e metti un link a prima nota
        echo $this->Form->button('Salva e Paga fattura (registra in Prima Nota)', ['name'=>'submit-pn', 'class'=>'btn btn-primary']); 
    ?>

</div>

<?php $this->Html->scriptStart(['inline' => false]); ?>          
    
    $('#dettagli-fornitore').hide('fast');

    $( "#add-fornitore" ).click( function (e) { $("#dettagli-fornitore").toggle('fast'); $("#FatturaricevutaFornitoreId").parent().toggle('fast'); });

<?php $this->Html->scriptEnd();

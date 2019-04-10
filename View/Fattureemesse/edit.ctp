<?php
    if (isset($this->request->data['Attivita']['id']))
    {
        $attivita_id = $this->request->data['Attivita']['id'];
        $progressivolibero = $this->request->data['Fatturaemessa']['Progressivo'];
        $Serie = $this->request->data['Fatturaemessa']['Serie'];
    }
    else //Sono nell'ADD, quindi il parametro è l'id dell'attività
    {
        $attivita_id= $this->request->params['pass'][0]; 
    }
    //Genero il menu secondario
    echo $this->element('secondary_attivita', array('aid'=>$attivita_id)); 
?>

<div class="fattureemesse form container">
<?php echo $this->Form->create('Fatturaemessa',array(
	   'url' => array('action' => 'edit'),
       'inputDefaults' => array(
		'div' => 'form-group',
		'label' => array(
			'class' => 'col col-md-2 control-label'
		),
		'wrapInput' => 'col col-md-4',
		'class' => 'form-control'
	),	
	'class' => 'well form-horizontal'        
    )); ?>
	
    <h2>Modifica la fattura</h2>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('attivita_id', array('readonly'=>'readonly', 'default'=>$attivita_id));
    ?>
	
    <?php echo $this->Form->input('Progressivo', array('default'=>$progressivolibero)); ?>
    <?php //echo $this->Form->input('Serie', array('default' => $Serie)); ?>
    <?php echo $this->Form->input('Serie', array('options'=>$serieOptions, 'label'=>'Serie', 'default' => $serieOptions[$Serie])); ?>
		<?php echo $this->Form->input('AnnoFatturazione', array('default'=>date('Y'))); ?>
    
    <?php
        echo $this->Form->input('data', array('dateFormat' => 'DMY', 'class'=>''));
        echo $this->Form->input('Competenza');
		echo $this->Form->input('Motivazione');
		
		

		$fattura_id = 1;
		echo $this->element('fattura_dettaglio', array('righe' => $this->request->data['Rigafattura'], 'fattura_id' => $fattura_id, 'codiciiva' => $codiciiva));
   ?>     
    <fieldset><legend>Condizioni di Pagamento e Note</legend>
   <?php
        echo $this->Form->input('provenienzasoldi_id');
        echo $this->Form->input('ScadPagamento');
        echo $this->Form->input('CondPagamento');
		echo $this->Form->input('AnticipoFatture',  array(
                          'class'=>false,
                          'label' => array('class' => null),
                          'wrapInput' => 'col col-md-9 col-md-offset-2',
                    ));
		
		echo $this->Form->input('FineMese', array(
                          'class'=>false,
                          'label' => array('class' => null),
                          'wrapInput' => 'col col-md-9 col-md-offset-2',
                    ));

	?>
    </fieldset>
    <div class="row">
        <?php echo $this->Form->submit(__('Save'), array('class'=>'col-md-offset-2 col')); ?>
        <?php echo $this->Form->submit(__('Print'), array('class'=>'col-md-offset-2 col')); ?>
    </div>
    
    <?php echo $this->Form->end();?>
</div>

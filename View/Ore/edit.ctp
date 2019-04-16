<?php echo $this->Js->set('url', $this->request->base); //Mi porta il path dell'applicazione nella view'?>
<?php echo $this->Html->script('faseattivita',array('inline' => false)); ?>
<?php $baseformclass = Configure::read('iGas.baseFormClass'); ?> 

<div class="ore form">
    <?php echo $this->Form->create('Ora', array(
	'inputDefaults' => array(
		'div' => 'form-group',
		'label' => array(
			'class' => 'col col-md-2 control-label'
		),
		'wrapInput' => 'col col-md-4',
		'class' => $baseformclass,
	),	
	'class' => 'well form-horizontal'        
    )); ?>
    
    <?php echo $this->Form->input('id'); ?>
    <?php echo $this->Form->hidden('old_numOre', array('default' => $this->request->data['Ora']['numOre']));?>
    <?php echo $this->Form->input('eRisorsa', array('default' => $eRisorsa, 'options' => $eRisorse, 'label' => 'Persona', 'class'=>'chosen-select col col-md-8')); ?>
    
    <?php
    $def = array('type' => 'date', 'dateFormat' => 'DMY', 'class'=>'');
    if (strlen("$anno-$mese-$giorno")) {
        $def['selected'] = "$anno-$mese-$giorno";
    }    
    echo $this->Form->input('data', $def);
    ?>
        
        
    <?php echo $this->Form->input('eAttivita', array('options' => $eAttivita, 
                                                'label' => array('text'=>'Attivita'), 
                                                'class'=>'col col-md-8 attivita chosen-select ' . $baseformclass, //chosen-select
                                                'after' => $this->Html->link('<i class="fa fa-plus-square"></i> Aggiungi Attività', 
                                                            array('controller'=>'attivita','action'=>'edit'), 
                                                            array('class'=>'btn btn-xs btn-primary', 'escape'=>false)
                                                        ),
                                               ) 
                                  ); ?>        

    <?php echo $this->Form->input('faseattivita_id', array('label'=>'Fase Attività', 'options'=>$faseattivita, 'class'=>'fase ' . $baseformclass, 'value'=>$this->data['Ora']['faseattivita_id'])); ?> 
    <?php echo $this->Form->input('numOre', array('label' => 'Ore')); ?>
    <?php echo $this->Form->input('dettagliAttivita'); ?>
    <?php echo $this->Form->input('LuogoTrasferta'); ?>
    <?php echo $this->Form->submit(__('Submit'), array('class'=>'col-md-offset-2')); ?>
    <?php echo $this->Form->end();?>
</div>

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
    <?php echo $this->Form->input('persona_dummy', array('label'=>'Persona', 'value'=>$this->data['Persona']['DisplayName'], 'class' => 'form-control', 'disabled' => true)); ?>
    <?php echo $this->Form->hidden('eRisorsa', array('label' => 'Persona', 'type'=>'text', 'default' => $eRisorsa, 'value' => $eRisorsa, 'class' => 'form-control')); ?>
    <?php
    $def = array('type' => 'date', 'dateFormat' => 'DMY');
    if (strlen("$anno-$mese-$giorno")) {
        $def['selected'] = "$anno-$mese-$giorno";
    }    
    echo $this->Form->input('data', $def);
    ?>
        
    <?php
    if(($this->Session->read('Auth.User.group_id') == 1) or ($this->Session->read('Auth.User.group_id') == 2)){
        $aggiungiAttivita = $this->Html->link('<i class="fa fa-plus-square"></i> Aggiungi Attività', 
                                                array('controller'=>'attivita','action'=>'edit'), 
                                                array('class'=>'btn btn-xs btn-primary', 'escape'=>false)
                                            );
    } else {
        $aggiungiAttivita = false;
    }
    ?>    
    <?php 
    echo $this->Form->input('attivita_dummy', array('label'=>'Attività', 'value'=>$this->data['Attivita']['name'], 'class' => 'form-control', 'disabled' => true));
    ?> 
    <?php echo $this->Form->hidden('eAttivita', array('value'=>$this->data['Ora']['eAttivita'])); ?> 
    <?php echo $this->Form->input('faseattivita_dummy', array('label'=>'Fase Attività', 'value'=>$this->data['Faseattivita']['Descrizione'], 'class' => 'form-control', 'disabled' => true)); ?> 
    <?php echo $this->Form->hidden('faseattivita_id', array('label'=>'Fase Attività', 'value'=>$this->data['Ora']['faseattivita_id'])); ?> 
    <?php echo $this->Form->input('numOre', array('label' => 'Ore', 'class' => 'form-control')); ?>
    <?php echo $this->Form->input('dettagliAttivita', array('class' => 'form-control')); ?>
    <?php echo $this->Form->input('LuogoTrasferta', array('class' => 'form-control')); ?>
    <?php echo $this->Form->submit(__('Modifica'), array('class'=>'col-md-offset-2 btn btn-primary')); ?>
    <?php echo $this->Form->end();?>
</div>

<?php $this->Html->scriptStart(array('inline' => false)); ?>
$(function() {
    $(".chosen-select").prop('disabled', true).trigger("chosen:updated");
});
<?php $this->Html->scriptEnd(); ?>

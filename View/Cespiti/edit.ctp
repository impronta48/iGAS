<?php
    echo $this->Html->script("cespite.js",array('inline' => false));
    echo $this->Html->script("validate1.19",array('inline' => false));
    $this->Html->addCrumb('Cespiti', '/cespiti');
    $this->Html->addCrumb('Modifica elemento', array('controller' => 'cespiti', 'action' => 'edit/'.$this->request->data['Cespite']['id']));
?>
    <h2><i class='fa fa-gear'></i> <?php echo __('Modifica '.$this->request->data['Cespite']['DisplayName'].' (ID#'.$this->request->data['Cespite']['id'].')');?></h2>
    <br />
<?php
    echo $this->Form->create('Cespite', array(
        'inputDefaults' => array(
		'div' => 'form-group',
		'label' => array(
			'class' => 'col col-md-2 control-label'
		),
		'wrapInput' => 'col col-md-10',
		'class' => 'form-control'
	),	
	'class' => 'form-horizontal'       
    )); 
    echo $this->Form->input('id');
    echo $this->Form->input('DisplayName', array('label' => 'Nome Cespite', 'class'=> 'form-control required'));
    echo $this->Form->input('descrizione');
    echo $this->Form->input('costo_acquisto', array('class'=> 'form-control required'));
    echo $this->Form->input('costo_affitto');
    echo $this->Form->input('data_acquisto', array('type'=>'text', 'class'=> 'form-control'));
?>
<div class="row">
<?php echo $this->Form->submit('Salva', array('class'=>'btn btn-primary', 'div' => false)); ?>

<?php echo $this->Form->reset('Reset', array('class'=>'btn btn-warning', 'div' => false)); ?>
</div>
<?php echo $this->Form->end(); ?>

<?php $this->Html->scriptStart(array('inline' => false)); ?>
$(function() {

	$( "#CespiteDataAcquisto" ).datepicker( { dateFormat: 'yy-mm-dd 00:00:00' });

} );
<?php $this->Html->scriptEnd(); ?>
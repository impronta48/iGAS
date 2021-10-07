<?php $baseclass = 'form-control form-cascade-control input-xs'; ?>
<?php 
	echo $this->Form->input('attivita_id', array('class'=>'attivita ' . $baseclass, 'options' => $faseattivita ));  //array('class'=>'chosen-select')) 
?>
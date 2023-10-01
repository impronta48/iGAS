<?php $baseclass = 'form-control form-cascade-control input-xs'; ?>
<?php 
	echo $this->Form->input('attivita_id', ['class'=>'attivita ' . $baseclass, 'options' => $faseattivita ]);  //array('class'=>'chosen-select')) 
?>
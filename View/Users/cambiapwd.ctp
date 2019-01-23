<br>
<br>
<div class="panel panel-default">
<div class="panel-heading">Modifica password</div>
<div class="panel-body">
<?php echo $this->Form->create('User');?>
<?php
        echo $this->Form->input('id');
        echo $this->Form->input("vecchia_password", array('size' => 20, 'type'=>'password'));
        echo $this->Form->input('nuova_password', array('size' => 20,'type'=>'password'));
        echo $this->Form->input('conferma_password', array('size' => 20,'type'=>'password'));
		echo '<br>';
        echo $this->Form->end(array('label' => 'Cambia', 'class' => 'btn btn-primary'));
?>
</div>
</div>


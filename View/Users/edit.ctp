<h1>Modifica Utente</h1>
<?php echo $this->Form->create('Users'); ?>
<FIELDSET>
<?php echo $this->Form->input('User.username'); ?>
<?php echo $this->Form->input('User.group_id'); ?>
<?php echo $this->Form->input('User.password', array('default'=>null)); ?>
<?php echo $this->Form->input('User.persona_id', array('class'=>'chosen-select', 'label'=>'Associa al contatto:')); ?>
<?php echo $this->Form->hidden('User.id'); ?>

</FIELDSET>
<?php echo $this->Form->end('Salva Modifiche'); ?>
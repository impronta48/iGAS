<h1>Aggiungi Utente</h1>
<?php echo $this->Form->create('User'); ?>
<FIELDSET>
<?php echo $this->Form->input('username'); ?>
<?php echo $this->Form->input('password'); ?>
<?php echo $this->Form->input('group_id'); ?>
<?php echo $this->Form->input('User.persona_id', array('class'=>'chosen-select', 'label'=>'Associa al contatto:')); ?>
</FIELDSET>
<?php echo $this->Form->end('Salva Modifiche'); ?>

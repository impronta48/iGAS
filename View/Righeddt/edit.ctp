<div class="righeddt form">
<?php echo $this->Form->create('Rigaddt'); ?>
	<fieldset>
		<legend><?php echo __('Edit Rigaddt'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('ddt_id');
		echo $this->Form->input('Descrizione');
		echo $this->Form->input('qta');
		echo $this->Form->input('um');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $this->Form->value('Rigaddt.id')], null, __('Are you sure you want to delete # %s?', $this->Form->value('Rigaddt.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Righeddt'), ['action' => 'index']); ?></li>
		<li><?php echo $this->Html->link(__('List Ddt'), ['controller' => 'ddt', 'action' => 'index']); ?> </li>
		<li><?php echo $this->Html->link(__('New Ddt'), ['controller' => 'ddt', 'action' => 'add']); ?> </li>
	</ul>
</div>

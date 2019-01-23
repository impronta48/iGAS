<div class="righeordini form">
<?php echo $this->Form->create('Rigaordine'); ?>
	<fieldset>
		<legend><?php echo __('Edit Rigaordine'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('ordine_id');
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

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Rigaordine.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Rigaordine.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Righeordini'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Ordini'), array('controller' => 'ordini', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ordine'), array('controller' => 'ordini', 'action' => 'add')); ?> </li>
	</ul>
</div>

<div class="righeordini form">
<?php echo $this->Form->create('Rigaordine'); ?>
	<fieldset>
		<legend><?php echo __('Add Rigaordine'); ?></legend>
	<?php
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

		<li><?php echo $this->Html->link(__('List Righeordini'), ['action' => 'index']); ?></li>
		<li><?php echo $this->Html->link(__('List Ordini'), ['controller' => 'ordini', 'action' => 'index']); ?> </li>
		<li><?php echo $this->Html->link(__('New Ordine'), ['controller' => 'ordini', 'action' => 'add']); ?> </li>
	</ul>
</div>

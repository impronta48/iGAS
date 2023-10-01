<div class="provenienzesoldi form">
<?php echo $this->Form->create('Provenienzasoldi'); ?>
	<fieldset>
		<legend><?php echo __('Add Provenienzasoldi'); ?></legend>
	<?php
		echo $this->Form->input('ModoPagamento');
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Provenienzesoldi'), ['action' => 'index']); ?></li>
		<li><?php echo $this->Html->link(__('List Aziende'), ['controller' => 'aziende', 'action' => 'index']); ?> </li>
		<li><?php echo $this->Html->link(__('New Azienda'), ['controller' => 'aziende', 'action' => 'add']); ?> </li>
	</ul>
</div>

<div class="legendaTipoDocumentos form">
<?php echo $this->Form->create('LegendaTipoDocumento'); ?>
	<fieldset>
		<legend><?php echo __('Edit Legenda Tipo Documento'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('title');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('LegendaTipoDocumento.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('LegendaTipoDocumento.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Legenda Tipo Documentos'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Fatturericevute'), array('controller' => 'fatturericevute', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Fatturaricevuta'), array('controller' => 'fatturericevute', 'action' => 'add')); ?> </li>
	</ul>
</div>

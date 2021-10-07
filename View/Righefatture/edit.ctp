<div class="righefatture form">
<?php echo $this->Form->create('Rigafattura');?>
	<fieldset>
		<legend><?php echo __('Edit Rigafattura'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->hidden('fattura_id');
		echo $this->Form->input('DescrizioneVoci');
		
		echo $this->Form->input('Importo');
		echo $this->Form->input('codiceiva_id');
        echo $this->Form->input('Ordine');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $this->Form->value('Rigafattura.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('Rigafattura.id'))); ?></li>		
	</ul>
</div>
<div class="righefatture form">
<?php echo $this->Form->create('Rigafattura');?>
	<fieldset>
		<legend><?php echo __('Add Rigafattura'); ?></legend>
	<?php        
		echo $this->Form->hidden('fattura_id', array('default' => $fattura_id));
		echo $this->Form->input('DescrizioneVoci');		
		echo $this->Form->input('Importo');
		echo $this->Form->input('codiceiva_id', array('default'=> Configure::read('iGas.IvaDefault')));
        echo $this->Form->input('Ordine');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Righefatture'), array('action' => 'index'));?></li>
	</ul>
</div>
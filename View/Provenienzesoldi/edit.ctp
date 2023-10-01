<?php echo $this->Html->script("provenienzasoldi.js",['inline' => false]); ?>


<div class="provenienzesoldi form">
<?php echo $this->Form->create('Provenienzasoldi'); ?>	
	<h1>Modifica Conto</h1>
	<?php
		echo $this->Form->input('id');
		
		echo $this->Form->input('name', ['label'=>'Nome Conto']);
	?>
	<br>
	<label>Indicazioni da riportare in fattura</label>
		<?php echo $this->Form->input('ModoPagamento'); ?>		
	</div>
		
	
	
<?php echo $this->Form->end(__('Submit')); ?>
</div>


<?php

echo $this->Html->script('bootstrap-colorpicker', ['inline'=>false]);
echo $this->Html->css('bootstrap-colorpicker', null, ['inline'=>false]); 

?>

<div class="legendaTipoAttivitaCalendarios form">
<?php echo $this->Form->create('LegendaTipoAttivitaCalendario'); ?>
	<div class="form-group">
	<fieldset>
		<legend><?php echo __('Edit Legenda Tipo Attività Calendario'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('title', ['class' => 'form-control', 'label' => 'Attività Calendario']);
		echo $this->Form->input('color', ['class' => 'form-control', 'label' => 'Colore Associato']);
		echo $this->Form->input('textColor', ['class' => 'form-control', 'label' => 'Colore Testo Associato', 'placeholder' => 'Colore Testo Associato']);
	?>
	</fieldset>
	</div>
	<div class="row">
	<?php echo $this->Form->button(__('Submit'), ['class' => 'btn btn-sm btn-primary']); ?>

	<?php echo $this->Form->reset(__('Reset'), ['class' => 'btn btn-sm btn-danger']); ?>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Lista Tipi Attività Calendario'), ['action' => 'index']); ?></li>

	</ul>
</div>

<?php $this->Html->scriptStart(['inline' => false]); ?>

$(function() {
	$('#LegendaTipoAttivitaCalendarioColor').colorpicker();
	$('#LegendaTipoAttivitaCalendarioTextColor').colorpicker();
});

<?php $this->Html->scriptEnd(); ?>
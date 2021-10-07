<?php

echo $this->Html->script('bootstrap-colorpicker', Array('inline'=>false));
echo $this->Html->css('bootstrap-colorpicker', null, Array('inline'=>false)); 

?>

<div class="legendaTipoAttivitaCalendarios form">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Aggiungi Tipo di Attività Calendario'); ?></h1>
			</div>
		</div>
	</div>


<div class="row">
		<div class="col-md-3">
			<div class="actions">
				<div class="panel panel-default">
					<div class="panel-heading"><?php echo __('Azioni'); ?></div>
						<div class="panel-body">
							<ul class="nav nav-pills nav-stacked">

		<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('Legenda'), array('action' => 'index'), array('escape' => false)); ?></li>
		<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('Calendario Cespiti'), array('controller' => 'cespiti', 'action' => 'calendar'), array('escape' => false)); ?> </li>

							</ul>
						</div>
					</div>
				</div>			
		</div><!-- end col md 3 -->
		<div class="col-md-9">
			<?php echo $this->Form->create('LegendaTipoAttivitaCalendario', array('role' => 'form')); ?>

				<div class="form-group">
					<?php 
					echo $this->Form->input('title', array('class' => 'form-control', 'label' => 'Attività Calendario', 'placeholder' => 'Attività Calendario'));
					echo $this->Form->input('color', Array('class' => 'form-control', 'label' => 'Colore BG Associato', 'placeholder' => 'Click to choose the BG Color'));
					echo $this->Form->input('textColor', Array('class' => 'form-control', 'label' => 'Colore Testo Associato', 'placeholder' => 'Click to choose text Color'));
					?>
					</div>
				<div class="row">
					<?php echo $this->Form->button(__('Invia'), array('class' => 'btn btn-sm btn-primary')); ?>
					
					<?php echo $this->Form->reset(__('Reset'), Array('class' => 'btn btn-sm btn-danger')); ?>
				</div>

			<?php echo $this->Form->end() ?>

		</div><!-- end col md 12 -->
	</div><!-- end row -->
</div>

<?php $this->Html->scriptStart(array('inline' => false)); ?>

$(function() {
	$('#LegendaTipoAttivitaCalendarioColor').colorpicker();
	$('#LegendaTipoAttivitaCalendarioTextColor').colorpicker();
});

<?php $this->Html->scriptEnd(); ?>
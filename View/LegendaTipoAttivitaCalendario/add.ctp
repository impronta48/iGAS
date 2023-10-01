<?php

echo $this->Html->script('bootstrap-colorpicker', ['inline'=>false]);
echo $this->Html->css('bootstrap-colorpicker', null, ['inline'=>false]); 

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

		<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('Legenda'), ['action' => 'index'], ['escape' => false]); ?></li>
		<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('Calendario Cespiti'), ['controller' => 'cespiti', 'action' => 'calendar'], ['escape' => false]); ?> </li>

							</ul>
						</div>
					</div>
				</div>			
		</div><!-- end col md 3 -->
		<div class="col-md-9">
			<?php echo $this->Form->create('LegendaTipoAttivitaCalendario', ['role' => 'form']); ?>

				<div class="form-group">
					<?php 
					echo $this->Form->input('title', ['class' => 'form-control', 'label' => 'Attività Calendario', 'placeholder' => 'Attività Calendario']);
					echo $this->Form->input('color', ['class' => 'form-control', 'label' => 'Colore BG Associato', 'placeholder' => 'Click to choose the BG Color']);
					echo $this->Form->input('textColor', ['class' => 'form-control', 'label' => 'Colore Testo Associato', 'placeholder' => 'Click to choose text Color']);
					?>
					</div>
				<div class="row">
					<?php echo $this->Form->button(__('Invia'), ['class' => 'btn btn-sm btn-primary']); ?>
					
					<?php echo $this->Form->reset(__('Reset'), ['class' => 'btn btn-sm btn-danger']); ?>
				</div>

			<?php echo $this->Form->end() ?>

		</div><!-- end col md 12 -->
	</div><!-- end row -->
</div>

<?php $this->Html->scriptStart(['inline' => false]); ?>

$(function() {
	$('#LegendaTipoAttivitaCalendarioColor').colorpicker();
	$('#LegendaTipoAttivitaCalendarioTextColor').colorpicker();
});

<?php $this->Html->scriptEnd(); ?>
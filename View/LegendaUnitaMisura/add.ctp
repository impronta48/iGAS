<div class="legendaUnitaMisuras form">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Aggiungi Unit&agrave; di Misura'); ?></h1>
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
														</ul>
						</div>
					</div>
				</div>			
		</div><!-- end col md 3 -->
		<div class="col-md-9">
			<?php echo $this->Form->create('LegendaUnitaMisura', array('role' => 'form')); ?>

				<div class="form-group">
					<?php echo $this->Form->input('name', array('class' => 'form-control', 'label' => 'Nome', 'placeholder' => 'Nome'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->submit(__('Invia'), array('class' => 'btn btn-default')); ?>
				</div>

			<?php echo $this->Form->end() ?>

		</div><!-- end col md 12 -->
	</div><!-- end row -->
</div>

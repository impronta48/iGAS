<div class="legendaCodiciIvas form">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Add Legenda Codici Iva'); ?></h1>
			</div>
		</div>
	</div>



	<div class="row">
		<div class="col-md-3">
			<div class="actions">
				<div class="panel panel-default">
					<div class="panel-heading"><?php echo __('Actions'); ?></div>
						<div class="panel-body">
							<ul class="nav nav-pills nav-stacked">

																<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('List Legenda Codici Ivas'), ['action' => 'index'], ['escape' => false]); ?></li>
									
							</ul>
						</div>
					</div>
				</div>			
		</div><!-- end col md 3 -->
		<div class="col-md-9">
			<?php echo $this->Form->create('LegendaCodiciIva', ['role' => 'form']); ?>

				<div class="form-group">
					<?php echo $this->Form->input('Percentuale', ['class' => 'form-control', 'placeholder' => 'Percentuale']);?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('Descrizione', ['class' => 'form-control', 'placeholder' => 'Descrizione']);?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->submit(__('Submit'), ['class' => 'btn btn-default']); ?>
				</div>

			<?php echo $this->Form->end() ?>

		</div><!-- end col md 12 -->
	</div><!-- end row -->
</div>

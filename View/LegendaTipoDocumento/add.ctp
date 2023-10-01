<div class="legendaTipoDocumentos form">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Aggiungi Tipo di Documento'); ?></h1>
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
		<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('Fatture Ricevute'), ['controller' => 'fatturericevute', 'action' => 'index'], ['escape' => false]); ?> </li>
		<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('Nuova Fattura Ricevuta'), ['controller' => 'fatturericevute', 'action' => 'add'], ['escape' => false]); ?> </li>

							</ul>
						</div>
					</div>
				</div>			
		</div><!-- end col md 3 -->
		<div class="col-md-9">
			<?php echo $this->Form->create('LegendaTipoDocumento', ['role' => 'form']); ?>

				<div class="form-group">
					<?php echo $this->Form->input('title', ['class' => 'form-control', 'label' => 'Nome', 'placeholder' => 'Nome']);?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->submit(__('Invia'), ['class' => 'btn btn-default']); ?>
				</div>

			<?php echo $this->Form->end() ?>

		</div><!-- end col md 12 -->
	</div><!-- end row -->
</div>


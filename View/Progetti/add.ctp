<div class="progetti form">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Add Progetto'); ?></h1>
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

																<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('List Progetti'), ['action' => 'index'], ['escape' => false]); ?></li>
									<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('List Aree'), ['controller' => 'aree', 'action' => 'index'], ['escape' => false]); ?> </li>
		<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('New Area'), ['controller' => 'aree', 'action' => 'add'], ['escape' => false]); ?> </li>
		<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('List Attivita'), ['controller' => 'attivita', 'action' => 'index'], ['escape' => false]); ?> </li>
		<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('New Attivita'), ['controller' => 'attivita', 'action' => 'add'], ['escape' => false]); ?> </li>
							</ul>
						</div>
					</div>
				</div>			
		</div><!-- end col md 3 -->
		<div class="col-md-9">
			<?php echo $this->Form->create('Progetto', ['role' => 'form']); ?>

				<div class="form-group">
					<?php echo $this->Form->input('name', ['class' => 'form-control', 'placeholder' => 'Name']);?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('DescrizioneProgetto', ['class' => 'form-control', 'placeholder' => 'DescrizioneProgetto']);?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('area_id', ['class' => 'form-control', 'placeholder' => 'Area Id']);?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('PercentualeIVA', ['class' => 'form-control', 'placeholder' => 'PercentualeIVA']);?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('Nota', ['class' => 'form-control', 'placeholder' => 'Nota']);?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->submit(__('Submit'), ['class' => 'btn btn-default']); ?>
				</div>

			<?php echo $this->Form->end() ?>

		</div><!-- end col md 12 -->
	</div><!-- end row -->
</div>

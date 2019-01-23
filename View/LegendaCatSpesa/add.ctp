<div class="legendaCatSpesas form">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Add Legenda Cat Spesa'); ?></h1>
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

																<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('List Legenda Cat Spesas'), array('action' => 'index'), array('escape' => false)); ?></li>
									<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('List Primanota'), array('controller' => 'primanota', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('New Primanota'), array('controller' => 'primanota', 'action' => 'add'), array('escape' => false)); ?> </li>
							</ul>
						</div>
					</div>
				</div>			
		</div><!-- end col md 3 -->
		<div class="col-md-9">
			<?php echo $this->Form->create('LegendaCatSpesa', array('role' => 'form')); ?>

				<div class="form-group">
					<?php echo $this->Form->input('name', array('class' => 'form-control', 'placeholder' => 'Name'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('voceNotaSpesa', array('class' => 'form-control', 'placeholder' => 'Voce Nota Spesa'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->submit('Invia', array('class' => 'btn btn-default')); ?> 
				</div>

				<?php  

				// FILIPPO     16/05/2016
				//__('Submit') questa era al posto di 'Invia' ?>

			<?php echo $this->Form->end() ?>

		</div><!-- end col md 12 -->
	</div><!-- end row -->
</div>

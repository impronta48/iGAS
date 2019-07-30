<div class="impiegati form">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Add Impiegato'); ?></h1>
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

																<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('List Impiegati'), array('action' => 'index'), array('escape' => false)); ?></li>
									<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('List Persone'), array('controller' => 'persone', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('New Persona'), array('controller' => 'persone', 'action' => 'add'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('List Legenda Tipo Impiegatos'), array('controller' => 'legenda_tipo_impiegatos', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('New Legenda Tipo Impiegato'), array('controller' => 'legenda_tipo_impiegatos', 'action' => 'add'), array('escape' => false)); ?> </li>
							</ul>
						</div>
					</div>
				</div>			
		</div><!-- end col md 3 -->
		<div class="col-md-9">
			<?php echo $this->Form->create('Impiegato', array('role' => 'form')); ?>
				<div class="form-group">
					<?php echo $this->Form->input('disattivo', array('class' => '', 'placeholder' => 'Disattivo'));?>
				</div>				
				<div class="form-group">
					<?php echo $this->Form->hidden('persona_id', array('class' => 'form-control', 'placeholder' => 'Persona Id', 'value'=>$persona_id));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('legendaTipoImpiegato_id', array('class' => 'form-control', 'options' => $legendaTipiImpiegati));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('numeroAssistenzaSociale', array('class' => 'form-control', 'placeholder' => 'NumeroAssistenzaSociale'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('numeroLibrettoDiLavoro', array('class' => 'form-control', 'placeholder' => 'NumeroLibrettoDiLavoro'));?>
				</div>
				<div class="form-group">
					<?php // echo $this->Form->input('dataAssunzione', array('class' => 'null', 'placeholder' => 'DataAssunzione', 'dateFormat'=>'DMY', 'minYear'=>1970));?>
					<?php echo $this->Form->input('dataAssunzione', array('type'=>'text', 'placeholder' => 'Clicca per impostare una data', 'dateFormat' => 'DMY', 'class' => 'form-control')); ?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('costoAziendale', array('class' => 'form-control', 'placeholder' => 'CostoAziendale'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('venduto', array('class' => 'form-control', 'placeholder' => 'Venduto'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('legendaUnitaMisura_id', array('class' => 'form-control', 'options' => $legendaUnitaMisura));?>
				</div>
				<div class="form-group">
					<?php // echo $this->Form->input('dataValidita', array('class' => 'null', 'label' => 'Data inizio validità', 'dateFormat'=>'DMY', 'minYear'=>1970));?>
					<?php echo $this->Form->input('dataValidita', array('type'=>'text', 'label' => 'Data inizio validità', 'placeholder' => 'Clicca per impostare una data', 'dateFormat' => 'DMY', 'class' => 'form-control')); ?>
				</div>				
				<div>
					<h3>Ore a Contratto</h3>
					<table class="table">
					<tr>
					<th>lun</th><th>mar</th><th>mer</th><th>gio</th><th>ven</th><th>sab</th><th>dom</th>
					</tr>
					<tr>
					<td><?php echo $this->Form->input('oreLun', array('class' => 'form-control', 'placeholder' => '8', 'label'=>'', 'default'=>8));?></td>
					<td><?php echo $this->Form->input('oreMar', array('class' => 'form-control', 'placeholder' => '8', 'label'=>'', 'default'=>8));?></td>
					<td><?php echo $this->Form->input('oreMer', array('class' => 'form-control', 'placeholder' => '8', 'label'=>'', 'default'=>8));?></td>
					<td><?php echo $this->Form->input('oreGio', array('class' => 'form-control', 'placeholder' => '8', 'label'=>'', 'default'=>8));?></td>
					<td><?php echo $this->Form->input('oreVen', array('class' => 'form-control', 'placeholder' => '8', 'label'=>'', 'default'=>8));?></td>
					<td><?php echo $this->Form->input('oreSab', array('class' => 'form-control', 'placeholder' => '0', 'label'=>'', 'default'=>0));?></td>
					<td><?php echo $this->Form->input('oreDom', array('class' => 'form-control', 'placeholder' => '0', 'label'=>'', 'default'=>0));?></td>
					</tr>
					</table>
				</div>
				
				

				<div class="form-group">
					<?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-default')); ?>
				</div>

			<?php echo $this->Form->end() ?>

		</div><!-- end col md 12 -->
	</div><!-- end row -->
</div>

<?php $this->Html->scriptStart(array('inline' => false)); ?>

    $( "#ImpiegatoDataAssunzione" ).datepicker( { dateFormat: 'yy-mm-dd' });
	$( "#ImpiegatoDataValidita" ).datepicker( { dateFormat: 'yy-mm-dd' });

<?php $this->Html->scriptEnd(); ?>
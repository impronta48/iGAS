<div class="impiegati form">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1>Modifica i dati di <?php echo $persone[$this->request->data['Impiegato']['persona_id']]; ?> </h1>
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
							<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;' . __('Crea Una Variazione'), ['action' => 'variation', $this->Form->value('Impiegato.id')], ['escape' => false]); ?></li>
							<li><?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;'.__('Elimina'), ['action' => 'delete', $this->Form->value('Impiegato.id')], ['escape' => false], __('Are you sure you want to delete # %s?', $this->Form->value('Impiegato.id'))); ?></li>
							<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('Elenco Impiegati'), ['action' => 'index'], ['escape' => false]); ?></li>
							</ul>
						</div>
					</div>
				</div>			
		</div><!-- end col md 3 -->
		<div class="col-md-9">
			<?php echo $this->Form->create('Impiegato', ['role' => 'form']); ?>
				<div class="form-group">
					<?php echo $this->Form->input('id', ['class' => 'form-control', 'placeholder' => 'Id']);?>
					<?php echo $this->Form->hidden('persona_id');?>
				</div>		
				<div class="form-group">
					<?php echo $this->Form->input('disattivo', ['class' => '', 'placeholder' => 'Disattivo']);?>
				</div>				
				<div class="form-group">
					<?php echo $this->Form->input('legendaTipoImpiegato_id', ['class' => 'form-control', 'options' => $legendaTipiImpiegati]);?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('numeroAssistenzaSociale', ['class' => 'form-control', 'placeholder' => 'NumeroAssistenzaSociale']);?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('numeroLibrettoDiLavoro', ['class' => 'form-control', 'placeholder' => 'NumeroLibrettoDiLavoro']);?>
				</div>
				<div class="form-group">
					<?php // echo $this->Form->input('dataAssunzione', array('class' => 'null', 'placeholder' => 'DataAssunzione', 'dateFormat'=>'DMY', 'minYear'=>1970));?>
					<?php echo $this->Form->input('dataAssunzione', ['type'=>'text', 'placeholder' => 'Clicca per impostare una data', 'dateFormat' => 'DMY', 'class' => 'form-control datepicker']); ?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('costoAziendale', ['class' => 'form-control', 'placeholder' => 'CostoAziendale']);?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('venduto', ['class' => 'form-control', 'placeholder' => 'Venduto']);?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('legendaUnitaMisura_id', ['class' => 'form-control', 'options' => $legendaUnitaMisura]);?>
				</div>
				<div class="form-group">
					<?php // echo $this->Form->input('dataValidita', array('class' => 'null', 'label' => 'Data inizio validità', 'dateFormat'=>'DMY', 'minYear'=>1970));?>
					<?php echo $this->Form->input('dataValidita', ['type'=>'text', 'label' => 'Data inizio validità', 'placeholder' => 'Clicca per impostare una data', 'dateFormat' => 'DMY', 'class' => 'form-control datepicker']); ?>
				</div>
				<div>
					<h3>Ore a Contratto</h3>
					<table class="table">
					<tr>
					<th>lun</th><th>mar</th><th>mer</th><th>gio</th><th>ven</th><th>sab</th><th>dom</th>
					</tr>
					<tr>
					<td><?php echo $this->Form->input('oreLun', ['class' => 'form-control', 'placeholder' => '8', 'label'=>'', 'default'=>8]);?></td>
					<td><?php echo $this->Form->input('oreMar', ['class' => 'form-control', 'placeholder' => '8', 'label'=>'', 'default'=>8]);?></td>
					<td><?php echo $this->Form->input('oreMer', ['class' => 'form-control', 'placeholder' => '8', 'label'=>'', 'default'=>8]);?></td>
					<td><?php echo $this->Form->input('oreGio', ['class' => 'form-control', 'placeholder' => '8', 'label'=>'', 'default'=>8]);?></td>
					<td><?php echo $this->Form->input('oreVen', ['class' => 'form-control', 'placeholder' => '8', 'label'=>'', 'default'=>8]);?></td>
					<td><?php echo $this->Form->input('oreSab', ['class' => 'form-control', 'placeholder' => '0', 'label'=>'', 'default'=>0]);?></td>
					<td><?php echo $this->Form->input('oreDom', ['class' => 'form-control', 'placeholder' => '0', 'label'=>'', 'default'=>0]);?></td>
					</tr>
					</table>
				</div>

				<?php
						echo "<small><b>Ultima Modifica</b> di {$persone[$this->request->data['Impiegato']['modificatoDa']]} il {$this->data['Impiegato']['modified']} </small><br>";
        		?>
				<div class="form-group">
					<?php echo $this->Form->submit(__('Submit'), ['class' => 'btn btn-default']); ?>
				</div>

			<?php echo $this->Form->end() ?>

		</div><!-- end col md 12 -->
	</div><!-- end row -->
</div>

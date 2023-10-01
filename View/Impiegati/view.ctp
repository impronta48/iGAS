<div class="impiegati view">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Impiegato'); ?></h1>
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
									<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-edit"></span>&nbsp&nbsp;Edit Impiegato'), ['action' => 'edit', $impiegato['Impiegato']['id']], ['escape' => false]); ?> </li>
		<li><?php echo $this->Form->postLink(__('<span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Delete Impiegato'), ['action' => 'delete', $impiegato['Impiegato']['id']], ['escape' => false], __('Are you sure you want to delete # %s?', $impiegato['Impiegato']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Impiegati'), ['action' => 'index'], ['escape' => false]); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New Impiegato'), ['action' => 'add'], ['escape' => false]); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Persone'), ['controller' => 'persone', 'action' => 'index'], ['escape' => false]); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New Persona'), ['controller' => 'persone', 'action' => 'add'], ['escape' => false]); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Legenda Tipo Impiegatos'), ['controller' => 'legenda_tipo_impiegatos', 'action' => 'index'], ['escape' => false]); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New Legenda Tipo Impiegato'), ['controller' => 'legenda_tipo_impiegatos', 'action' => 'add'], ['escape' => false]); ?> </li>
							</ul>
						</div><!-- end body -->
				</div><!-- end panel -->
			</div><!-- end actions -->
		</div><!-- end col md 3 -->

		<div class="col-md-9">			
			<table cellpadding="0" cellspacing="0" class="table table-striped">
				<tbody>
				<tr>
		<th><?php echo __('Id'); ?></th>
		<td>
			<?php echo h($impiegato['Impiegato']['id']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Persona'); ?></th>
		<td>
			<?php echo $this->Html->link($impiegato['Persona']['DisplayName'], ['controller' => 'persone', 'action' => 'view', $impiegato['Persona']['id']]); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('LegendaTipoImpiegato Id'); ?></th>
		<td>
			<?php echo h($impiegato['Impiegato']['legendaTipoImpiegato_id']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('NumeroAssistenzaSociale'); ?></th>
		<td>
			<?php echo h($impiegato['Impiegato']['numeroAssistenzaSociale']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('NumeroLibrettoDiLavoro'); ?></th>
		<td>
			<?php echo h($impiegato['Impiegato']['numeroLibrettoDiLavoro']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('DataAssunzione'); ?></th>
		<td>
			<?php echo h($impiegato['Impiegato']['dataAssunzione']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('CostoAziendale'); ?></th>
		<td>
			<?php echo h($impiegato['Impiegato']['costoAziendale']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Venduto'); ?></th>
		<td>
			<?php echo h($impiegato['Impiegato']['venduto']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('LegendaUnitaMisura Id'); ?></th>
		<td>
			<?php echo h($impiegato['Impiegato']['legendaUnitaMisura_id']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Disattivo'); ?></th>
		<td>
			<?php echo h($impiegato['Impiegato']['disattivo']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Modified'); ?></th>
		<td>
			<?php echo h($impiegato['Impiegato']['modified']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('ModificatoDa'); ?></th>
		<td>
			<?php echo h($impiegato['Impiegato']['modificatoDa']); ?>
			&nbsp;
		</td>
</tr>
				</tbody>
			</table>

		</div><!-- end col md 9 -->

	</div>
</div>

